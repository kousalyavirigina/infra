<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plot;
use App\Models\PlotBooking;
use Barryvdh\DomPDF\Facade\Pdf;   // ✅ CORRECT
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    /**
     * STEP 1
     * Dashboard → Enter Plot Number page
     */
    public function plotForm()
{
    // Fetch bookings which have completed agreements
    $bookings = PlotBooking::whereHas('agreement')
        ->with(['plot', 'payments'])
        ->get();

    return view('payments.enter-plot', compact('bookings'));
}
    /**
     * STEP 2
     * Fetch booking using Plot Number
     * Agreement must be completed
     */
    public function fetchBooking(Request $request)
{
    $request->validate([
        'plot_no' => 'required'
    ]);

    $booking = PlotBooking::whereHas('plot', function ($q) use ($request) {
        $q->where('plot_no', $request->plot_no);
    })
    ->with(['plot', 'agreement'])
    ->first();

    if (!$booking || !$booking->agreement) {
        return back()->withErrors(['plot_no' => 'Agreement not found for this plot']);
    }

    return view('payments.create', compact('booking'));
}

    /**
     * STEP 3
     * Store Sale Amount Payment
     */
    public function store(Request $request, PlotBooking $booking)
{
    $request->validate([
        'total_cost'   => 'required|numeric|min:1',
        'paid_amount'  => 'required|numeric|min:1',
        'payment_mode' => 'required|in:cash,upi,neft,rtgs,online',
    ]);

    // Agreement must exist
    if (!$booking->agreement) {
        return back()->withErrors(['plot' => 'Agreement not found']);
    }

    // Agreement date from created_at
    $agreementDate = $booking->agreement->created_at;

    // Due date = Agreement date + 45 days
    $dueDate = Carbon::parse($agreementDate)->addDays(45)->toDateString();

    // ✅ SOURCE OF TRUTH
    $advanceAmount   = (float) ($booking->advance_amount ?? 0);
    $agreementAmount = (float) ($booking->agreement->agreement_paid_amount ?? 0);
    $totalCost       = (float) $request->total_cost;

    // Net Balance
    $netBalance = $totalCost - ($advanceAmount + $agreementAmount);

    if ($netBalance < 0) {
        return back()->withErrors([
            'total_cost' => 'Total cost cannot be less than Advance + Agreement amount'
        ]);
    }

    // Current payment
    $paidNow = (float) $request->paid_amount;
    $remainingBalance = $netBalance - $paidNow;

    if ($remainingBalance < 0) {
        return back()->withErrors([
            'paid_amount' => 'Payment exceeds Net Balance'
        ]);
    }

    // Create payment
    $payment = Payment::create([
        'plot_booking_id'   => $booking->id,
        'total_cost'        => $totalCost,
        'advance_amount'    => $advanceAmount,
        'agreement_amount'  => $agreementAmount,
        'net_balance'       => $netBalance,
        'paid_amount'       => $paidNow,
        'remaining_balance' => $remainingBalance,
        'due_date'          => $dueDate,
        'payment_mode'      => $request->payment_mode,
        'receipt_no'        => 'RAKE-' . now()->format('ymd') . '-' . rand(100, 999),
    ]);

    return redirect()->route('payments.receipt', $payment->id);
}


    /**
     * STEP 4
     * Download Sale Payment Receipt
     */
  

public function receiptView(Payment $payment)
{
    $payment->load(['booking.plot', 'booking.agreement']);

    $pdf = Pdf::loadView('payments.receipt', compact('payment'));

    // 👁️ OPEN IN BROWSER
    return $pdf->stream(
        'Sale-Payment-' . $payment->receipt_no . '.pdf'
    );
}

public function receiptDownload(Payment $payment)
{
    $payment->load(['booking.plot', 'booking.agreement']);

    $pdf = Pdf::loadView('payments.receipt', compact('payment'));

    // ⬇️ FORCE DOWNLOAD
    return $pdf->download(
        'Sale-Payment-' . $payment->receipt_no . '.pdf'
    );
}


    
}
