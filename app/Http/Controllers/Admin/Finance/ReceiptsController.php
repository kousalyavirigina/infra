<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlotBooking;
use App\Models\AgreementPayment;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\User;

class ReceiptsController extends Controller
{
    public function index(Request $request)
    {
        $receipts = collect();

        /*
        |------------------------------------------------------------------
        | 1. BOOKING RECEIPTS
        |------------------------------------------------------------------
        */
        $bookingReceipts = PlotBooking::with(['plot', 'salesPerson'])
            ->when(auth()->user()->role === 'sales', function ($q) {
                $q->where('sales_person_id', auth()->id());
            })
            ->when($request->filled('sales_person_id') && auth()->user()->role === 'admin', function ($q) use ($request) {
                $q->where('sales_person_id', $request->sales_person_id);
            })
            ->get()
            ->map(function ($b) {
                return [
                    'type'             => 'BOOKING',
                    'receipt_no'       => 'BK-' . str_pad($b->id, 4, '0', STR_PAD_LEFT),
                    'date'             => $b->created_at,
                    'plot_no'          => optional($b->plot)->plot_no,
                    'customer'         => $b->customer_name,
                    'amount'           => $b->advance_amount ?? 0,
                    'mode'             => '-',
                    'sales_person_id'  => $b->sales_person_id,
                    'sales_person'     => $b->salesPerson->name ?? 'Admin',
                    'view_url'         => route('bookings.receipt', $b->id),
                    'download_url'     => route('bookings.receipt.download', $b->id),
                ];
            });

        /*
        |------------------------------------------------------------------
        | 2. AGREEMENT PAYMENTS
        |------------------------------------------------------------------
        */
        $agreementReceipts = AgreementPayment::with('agreement.booking.plot')
            ->when(auth()->user()->role === 'sales', function ($q) {
                $q->whereHas('agreement.booking', function ($qq) {
                    $qq->where('sales_person_id', auth()->id());
                });
            })
            ->when($request->filled('sales_person_id') && auth()->user()->role === 'admin', function ($q) use ($request) {
                $q->whereHas('agreement.booking', function ($qq) use ($request) {
                    $qq->where('sales_person_id', $request->sales_person_id);
                });
            })
            ->get()
            ->map(function ($p) {
                return [
                    'type'             => 'AGREEMENT',
                    'receipt_no'       => $p->receipt_no,
                    'date'             => $p->payment_date,
                    'plot_no'          => optional($p->agreement->booking->plot)->plot_no,
                    'customer'         => $p->agreement->booking->customer_name,
                    'amount'           => $p->amount,
                    'mode'             => $p->payment_mode,
                    'sales_person_id'  => $p->agreement->booking->sales_person_id,
                    'sales_person'     => $p->agreement->booking->salesPerson->name ?? 'Admin',
                    'view_url'         => route('agreements.receipt.view', $p->agreement_id),
                    'download_url'     => route('agreements.receipt.download', $p->agreement_id),
                ];
            });

        /*
        |------------------------------------------------------------------
        | 3. SALE PAYMENTS
        |------------------------------------------------------------------
        */
        $saleReceipts = Payment::with('booking.plot')
            ->when(auth()->user()->role === 'sales', function ($q) {
                $q->whereHas('booking', function ($qq) {
                    $qq->where('sales_person_id', auth()->id());
                });
            })
            ->when($request->filled('sales_person_id') && auth()->user()->role === 'admin', function ($q) use ($request) {
                $q->whereHas('booking', function ($qq) use ($request) {
                    $qq->where('sales_person_id', $request->sales_person_id);
                });
            })
            ->get()
            ->map(function ($p) {
                return [
                    'type'             => 'SALE',
                    'receipt_no'       => $p->receipt_no ?? 'SALE-' . str_pad($p->id, 4, '0', STR_PAD_LEFT),
                    'date'             => $p->created_at,
                    'plot_no'          => optional($p->booking->plot)->plot_no,
                    'customer'         => $p->booking->customer_name,
                    'amount'           => $p->paid_amount,
                    'mode'             => $p->payment_mode,
                    'sales_person_id'  => $p->booking->sales_person_id,
                    'sales_person'     => $p->booking->salesPerson->name ?? 'Admin',
                    'view_url'         => route('payments.receipt.view', $p->id),
                    'download_url'     => route('payments.receipt.download', $p->id),
                ];
            });

        /*
        |------------------------------------------------------------------
        | MERGE ALL RECEIPTS
        |------------------------------------------------------------------
        */
        $receipts = $receipts
            ->merge($bookingReceipts)
            ->merge($agreementReceipts)
            ->merge($saleReceipts);

        /*
        |------------------------------------------------------------------
        | FILTER BY SALES PERSON (AFTER MERGE)
        |------------------------------------------------------------------
        */
        if ($request->filled('sales_person_id') && auth()->user()->role === 'admin') {
            $receipts = $receipts->filter(function ($r) use ($request) {
                return isset($r['sales_person_id'])
                    && $r['sales_person_id'] == $request->sales_person_id;
            });
        }

        /*
        |------------------------------------------------------------------
        | DATE FILTER
        |------------------------------------------------------------------
        */
        if ($request->filled('from')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $receipts = $receipts->filter(fn ($r) =>
                Carbon::parse($r['date'])->gte($from)
            );
        }

        if ($request->filled('to')) {
            $to = Carbon::parse($request->to)->endOfDay();
            $receipts = $receipts->filter(fn ($r) =>
                Carbon::parse($r['date'])->lte($to)
            );
        }

        /*
        |------------------------------------------------------------------
        | SORT + TOTAL
        |------------------------------------------------------------------
        */
        $receipts = $receipts->sortByDesc('date')->values();
        $totalCollection = $receipts->sum('amount');

        /*
        |------------------------------------------------------------------
        | CSV EXPORT
        |------------------------------------------------------------------
        */
        if ($request->get('export') === 'csv') {

            $headers = [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=receipts.csv",
            ];

            $callback = function () use ($receipts, $totalCollection) {
                $file = fopen('php://output', 'w');

                fputcsv($file, [
                    'Receipt No',
                    'Date',
                    'Plot No',
                    'Customer',
                    'Amount',
                    'Mode',
                    'Type'
                ]);

                foreach ($receipts as $r) {
                    fputcsv($file, [
                        $r['receipt_no'],
                        Carbon::parse($r['date'])->format('d-m-Y'),
                        $r['plot_no'],
                        $r['customer'],
                        $r['amount'],
                        strtoupper($r['mode']),
                        $r['type'],
                    ]);
                }

                fputcsv($file, []);
                fputcsv($file, ['', '', '', 'TOTAL COLLECTION', $totalCollection, '', '']);

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $salesUsers = User::where('role', 'sales')->orderBy('name')->get();

        return view('admin.finance.receipts', compact(
            'receipts',
            'totalCollection',
            'salesUsers'
        ));
    }
}
