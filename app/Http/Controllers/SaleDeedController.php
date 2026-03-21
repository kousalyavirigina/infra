<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\SaleDeed;
use App\Models\PlotBooking;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class SaleDeedController extends Controller
{
    /**
     * Sale Deeds List
     * ONLY from Agreements
     * NO cancelled bookings
     * NO duplicates
     */
    public function index()
    {
        $agreements = Agreement::query()
            ->distinct() // ✅ prevents duplicates safely

            ->with([
                'booking.plot',
                'saleDeed'
            ])

            // ✅ Agreement must be completed
            ->whereNotNull('agreements.completed_at')

            // ✅ Agreement not deleted
            ->whereNull('agreements.deleted_at')

            // ✅ Booking must exist & NOT cancelled
            ->whereHas('booking', function ($q) {
                $q->where('status', PlotBooking::STATUS_BOOKED)
                  ->whereNull('deleted_at');
            })

            // 🕒 Latest completed first
            ->orderBy('agreements.completed_at', 'desc')
            ->get();

        return view('sale-deeds.index', compact('agreements'));
    }

    /**
     * Create Sale Deed Form
     */
    public function create(Agreement $agreement)
    {
        // 🚫 Block if already created
        if ($agreement->saleDeed) {
            return redirect()
                ->route('sale-deeds.show', $agreement->saleDeed->id)
                ->with('error', 'Sale Deed already exists for this agreement.');
        }

        abort_unless($agreement->isSaleDeedAllowed(), 403);

        $saleDeedDate = now()->format('Y-m-d');

        return view('sale-deeds.create', compact('agreement', 'saleDeedDate'));
    }

    /**
     * Store Sale Deed
     */
    public function store(Request $request, Agreement $agreement)
    {
        // 🚫 Prevent duplicate inserts
        if ($agreement->saleDeed) {
            return redirect()
                ->route('sale-deeds.show', $agreement->saleDeed->id)
                ->with('error', 'Sale Deed already exists.');
        }

        $request->validate([
            'sale_deed_date' => 'required|date',
            'content'        => 'required',
        ]);

        $number = 'SD-' . str_pad(SaleDeed::count() + 1, 4, '0', STR_PAD_LEFT);

        $saleDeed = SaleDeed::create([
            'agreement_id'     => $agreement->id,
            'sale_deed_number' => $number,
            'sale_deed_date'   => $request->sale_deed_date,
            'content'          => $request->content,
        ]);

        return redirect()->route('sale-deeds.show', $saleDeed->id);
    }

    /**
     * View Sale Deed
     */
    public function show(SaleDeed $saleDeed)
    {
        return view('sale-deeds.show', compact('saleDeed'));
    }

    /**
     * Download Sale Deed as Word
     */
    public function downloadWord(SaleDeed $saleDeed)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        Html::addHtml($section, $saleDeed->content, false, false);

        $fileName = $saleDeed->sale_deed_number . '.docx';

        header("Content-Disposition: attachment; filename={$fileName}");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");

        $phpWord->save("php://output", 'Word2007');
        exit;
    }
}
