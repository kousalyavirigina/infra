<?php

namespace App\Http\Controllers;

use App\Models\PlotBooking;
use App\Models\Agreement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


use App\Models\AgreementPayment;


use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use Mpdf\Mpdf;


class AgreementController extends Controller
{
    /**
     * Show all bookings (booked) for agreement status
     */
  public function dueList()
{
    $bookings = PlotBooking::with(['plot', 'agreement'])

        // ✅ ONLY BOOKED BOOKINGS
        ->where('status', PlotBooking::STATUS_BOOKED)

        // 🔐 SALES → ONLY THEIR BOOKINGS
        ->when(auth()->user()->role === 'sales', function ($q) {
            $q->where('sales_person_id', auth()->id());
        })

        // 👑 ADMIN → OPTIONAL FILTER
        ->when(
            request('sales_person_id') && auth()->user()->role === 'admin',
            function ($q) {
                $q->where('sales_person_id', request('sales_person_id'));
            }
        )

        ->latest()
        ->get();

    return view('agreements.due', compact('bookings'));
}




    /**
     * Open agreement creation page
     */
    public function create(\App\Models\PlotBooking $booking)
{
    // 🔒 If agreement already exists, redirect to view
    if ($booking->agreement) {
        return redirect()->route('agreements.view', $booking->agreement->id);
    }

    // 🌐 Language handling (default English)
    $lang = request()->get('lang', 'en');

    // 🇮🇳 Telugu agreement
    if ($lang === 'te') {
        return view('agreements.create-te', compact('booking'));
    }

    // 🇬🇧 English agreement (existing)
    return view('agreements.create', compact('booking'));
}


    /**
     * Store agreement (FULL DOCUMENT)
     */
   public function store(Request $request, PlotBooking $booking)
{
    $request->validate([
        'agreement_date'          => 'required|date',
        'agreement_number'        => 'required|string',
        'agreement_paid_amount'   => 'required|numeric|min:0',
        'payment_mode'          => 'required|string',
        'reference_no'          => 'nullable|string',
        'bank_name'             => 'nullable|string',
        'agreement_html'          => 'required',
    ]);

    // 1️⃣ Create Agreement
    $agreement = Agreement::create([
        'plot_booking_id'        => $booking->id,
        'agreement_date'         => $request->agreement_date,
        'agreement_number'       => $request->agreement_number,
        'agreement_html'         => $request->agreement_html,
        'agreement_paid_amount'  => $request->agreement_paid_amount,
        'language'               => $request->agreement_language ?? 'en',
        'is_completed'           => true,
        'completed_at'           => now(),
    ]);

    AgreementPayment::create([
        'agreement_id' => $agreement->id,
        'amount'       => $request->agreement_paid_amount,
        'payment_mode' => $request->payment_mode,
        'reference_no' => $request->reference_no,
        'bank_name'    => $request->bank_name,
        'payment_date' => now(),
        'receipt_no'   => 'AGR-REC-' . str_pad($agreement->id, 4, '0', STR_PAD_LEFT),
    ]);

    // 2️⃣ 🔥 THIS WAS MISSING — SAVE AGREEMENT AMOUNT INTO BOOKING
    $booking->update([
        'agreement_amount' => $request->agreement_paid_amount
    ]);

    return redirect()
        ->route('agreements.view', $agreement->id)
        ->with('success', 'Agreement saved successfully');
}

    /**
     * View agreement
     */
    public function show(Agreement $agreement)
    {
        return view('agreements.view', compact('agreement'));
    }

   /**
 * Download agreement as PDF
 */
/**
 * Download agreement as PDF (FIXED FOR TELUGU)
 */
public function downloadPdf(Agreement $agreement)
{
    $fontPath = storage_path('fonts/NotoSansTelugu-Regular.ttf');

    $html = '
    <style>
        @font-face {
            font-family: "TeluguFont";
            src: url("file://' . $fontPath . '") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: ' . ($agreement->language === 'te'
                ? '"TeluguFont"'
                : '"Times New Roman"') . ';
            font-size: 15px;
            line-height: 1.9;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        h3, p, div {
            text-align: left;
        }
    </style>
    ' . $agreement->agreement_html;

    $pdf = Pdf::loadHTML($html)
        ->setPaper('A4', 'portrait')
        ->setOptions([
            'defaultFont' => $agreement->language === 'te'
                ? 'TeluguFont'
                : 'Times New Roman',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true,
        ]);

    return $pdf->download(
        'Agreement-' . $agreement->agreement_number . '.pdf'
    );
}



    /**
 * Download agreement as Word
 */
public function downloadWord(\App\Models\Agreement $agreement)
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord();

    // 🔤 Language-based font
    $fontName = $agreement->language === 'te'
        ? 'Noto Sans Telugu'
        : 'Times New Roman';

    $phpWord->setDefaultFontName($fontName);
    $phpWord->setDefaultFontSize(15);

    $section = $phpWord->addSection([
        'marginTop'    => 900,
        'marginBottom' => 900,
        'marginLeft'   => 900,
        'marginRight'  => 900,
    ]);

    // ================= CLEAN HTML =================

    $html = $agreement->agreement_html;

    // Fix <br>
    $html = preg_replace('/<br\s*>/i', '<br />', $html);

    // Remove inline styles (PhpWord limitation)
    $html = preg_replace('/style="[^"]*"/i', '', $html);

    // Allow safe tags only
    $html = strip_tags(
        $html,
        '<h1><h2><h3><p><br><strong><b><i><u>'
    );

    // ================= TITLE CENTER =================
    if (preg_match('/<h2>(.*?)<\/h2>/is', $html, $match)) {
        $section->addText(
            strip_tags($match[1]),
            ['bold' => true, 'size' => 16],
            ['alignment' => 'center', 'spaceAfter' => 400]
        );

        // Remove title from body
        $html = str_replace($match[0], '', $html);
    }

    // ================= BODY LEFT =================
    \PhpOffice\PhpWord\Shared\Html::addHtml(
        $section,
        '<html><body>' . $html . '</body></html>',
        false,
        false
    );

    // ================= SAVE =================
    $fileName = 'Agreement-' . $agreement->agreement_number . '.docx';
    $path = storage_path('app/' . $fileName);

    $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($path);

    return response()->download($path)->deleteFileAfterSend(true);
}

    public function list()
    {
        $bookings = \App\Models\PlotBooking::with('agreement')->get();
        return view('agreements.list', compact('bookings'));
    }
    

}
