<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Barryvdh\DomPDF\Facade\Pdf;

class AgreementPaymentController extends Controller
{
    /**
     * 👀 VIEW RECEIPT IN BROWSER (HTML)
     */
    public function view(Agreement $agreement)
    {
        $payment = $agreement->payments()->latest()->firstOrFail();

        return view(
            'agreements.receipt',   // ✅ browser view (with buttons)
            compact('agreement', 'payment')
        );
    }

    /**
     * ⬇️ DOWNLOAD RECEIPT PDF (NO BUTTONS)
     */
    public function download(Agreement $agreement)
    {
        $payment = $agreement->payments()->latest()->firstOrFail();

        $pdf = Pdf::loadView(
            'agreements.receipt-pdf',   // ✅ PDF-only view
            compact('agreement', 'payment')
        )->setPaper('A4', 'portrait');

        return $pdf->download(
            'agreement-receipt-'.$payment->receipt_no.'.pdf'
        );
    }
}
