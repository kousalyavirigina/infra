<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\PlotBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Mail\BookingReceiptMail;
use Barryvdh\DomPDF\Facade\Pdf;


class PlotController extends Controller
{
    /* ================= ADMIN CREATE ================= */

    public function create()
    {
        
        return view('plots.create');
    }

    public function edit($id)
    {
        $plot = Plot::findOrFail($id);
        return view('plots.edit', compact('plot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plot_no'    => 'required|unique:plots,plot_no',
            'sq_yards'   => 'nullable|numeric',
            'gadhulu'    => 'nullable|numeric',
            'facing'     => 'required',
            'road_width' => 'required|numeric',
        ]);

        if (!$request->sq_yards && !$request->gadhulu) {
            return back()->withErrors(['sq_yards' => 'Enter Sq. Yards or Gadhulu']);
        }

        $sqYards = $request->sq_yards;
        $gadhulu = $request->gadhulu;

        if ($sqYards && !$gadhulu) $gadhulu = $sqYards / 8;
        if ($gadhulu && !$sqYards) $sqYards = $gadhulu * 8;

        Plot::create([
            'plot_no'    => $request->plot_no,
            'sq_yards'   => $sqYards,
            'gadhulu'    => $gadhulu,
            'facing'     => $request->facing,
            'road_width' => $request->road_width,
            'status'     => 'available',
        ]);

        return redirect()->route('admin.plots.index')->with('success', 'Plot added');
    }

    /* ================= DASHBOARD ================= */

    

    public function index(Request $request)
    {
        $query = Plot::orderByRaw('CAST(plot_no AS UNSIGNED) ASC');

    // ✅ FILTER BASED ON STATUS
        if ($request->status === 'available') {
            $query->where('status', 'available');
        }

        if ($request->status === 'booked') {
            $query->where('status', 'booked')
                ->whereHas('latestActiveBooking');
        }


        $plots = $query->get();

        return view('plots.index', compact('plots'));
    }


    /* ================= GET BOOKING PAGE ================= */

    public function booking($id)
    {
        $plot = Plot::findOrFail($id);

        if ($plot->status !== 'available') {
            return redirect()->route('plots.index')
                ->with('error', 'This plot is already booked.');
        }

        return view('plots.plot-booking', compact('plot'));
    }

    public function bookingReceipt($id)
    {
        $booking = PlotBooking::with('plot')->findOrFail($id);

        return view('bookings.receipt', compact('booking'));
    }


    /* ================= STORE BOOKING ================= */

    public function storeBooking(Request $request, $id)
{
    $plot = Plot::findOrFail($id);

    // Prevent double booking
    if ($plot->status !== 'available') {
        return back()->with('error', 'This plot is already booked.');
    }

    // Validation
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'father_name' => 'nullable|string|max:255',
        'date_of_birth' => 'nullable|date',

        'contact_number' => 'required|string|max:20',
        'alternate_contact_number' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',

        'permanent_address' => 'required|string',
        'temporary_address' => 'nullable|string',
        'same_address' => 'nullable|boolean',

        'advance_amount' => 'required|integer|min:50000|max:100000',
        'payment_method' => 'required|in:upi,offline',

        'captured_photo' => 'nullable|string',
        'live_photo' => 'nullable|image|max:5120',
        'admin_email_note' => 'nullable|string',
    ]);

    // Address handling
    $tempAddress = $request->same_address
        ? $request->permanent_address
        : $request->temporary_address;

    // Photo handling
    $photoPath = null;

    if ($request->filled('captured_photo')) {
        $data = $request->captured_photo;

        if (preg_match('/^data:image\/(\w+);base64,/', $data)) {
            $data = base64_decode(substr($data, strpos($data, ',') + 1));
            $fileName = 'booking_photos/' . uniqid('live_') . '.jpg';
            Storage::disk('public')->put($fileName, $data);
            $photoPath = $fileName;
        }
    }

    if (!$photoPath && $request->hasFile('live_photo')) {
        $photoPath = $request->file('live_photo')->store('booking_photos', 'public');
    }

    // ✅ CREATE BOOKING (SQLITE SAFE STATUS)
    $booking = PlotBooking::create([
        'plot_id' => $plot->id,
        'customer_name' => $request->customer_name,
        'father_name' => $request->father_name,
        'date_of_birth' => $request->date_of_birth,
        'contact_number' => $request->contact_number,
        'alternate_contact_number' => $request->alternate_contact_number,
        'email' => $request->email,
        'permanent_address' => $request->permanent_address,
        'temporary_address' => $tempAddress,
        'same_address' => $request->same_address ?? false,
        'booking_date_time' => now('Asia/Kolkata'),
        'advance_amount' => $request->advance_amount,
        'payment_method' => $request->payment_method,
        'agreement_due_date' => now('Asia/Kolkata')->addDays(7),
        'extension_days' => 0,

        // 🔥 IMPORTANT LINE
        'status' => PlotBooking::STATUS_BOOKED,

        'live_photo_path' => $photoPath,
        'admin_email_note' => auth()->user()?->role === 'admin'
            ? $request->admin_email_note
            : null,

        
        'created_by' => auth()->id(),

        'sales_person_id' => auth()->user()->role === 'sales'
            ? auth()->id()
            : null,


    ]);

    // Update plot status
    $plot->update(['status' => 'booked']);

    // Send receipt email
    if ($booking->email) {
        Mail::to($booking->email)->send(new BookingReceiptMail($booking));
    }

    return redirect()
        ->route('plots.index')
        ->with('success', 'Booking completed successfully!');
}


    /* ================= UPDATE PLOT (ADMIN) ================= */

public function update(Request $request, $id)
{
    $plot = Plot::findOrFail($id);

    $request->validate([
        'plot_no'    => 'required|unique:plots,plot_no,' . $plot->id,
        'sq_yards'   => 'nullable|numeric',
        'gadhulu'    => 'nullable|numeric',
        'facing'     => 'required',
        'road_width' => 'required|numeric',
        'status'     => 'required|in:available,booked',
    ]);

    if (!$request->sq_yards && !$request->gadhulu) {
        return back()->withErrors(['sq_yards' => 'Enter Sq. Yards or Gadhulu']);
    }

    $sqYards = $request->sq_yards;
    $gadhulu = $request->gadhulu;

    if ($sqYards && !$gadhulu) $gadhulu = $sqYards / 8;
    if ($gadhulu && !$sqYards) $sqYards = $gadhulu * 8;


    // 🔥 If admin changes plot back to AVAILABLE
    if ($plot->status === 'booked' && $request->status === 'available') {
    PlotBooking::where('plot_id', $plot->id)
        ->where('status', PlotBooking::STATUS_BOOKED)
        ->update(['status' => PlotBooking::STATUS_CANCELLED]);
}





    $plot->update([
        'plot_no'    => $request->plot_no,
        'sq_yards'   => $sqYards,
        'gadhulu'    => $gadhulu,
        'facing'     => $request->facing,
        'road_width' => $request->road_width,
        'status'     => $request->status,
    ]);

    return redirect()
        ->route('admin.plots.index')
        ->with('success', 'Plot updated successfully');
}


    /* ================= ADMIN EXTENSION ================= */

    public function extendAgreement(Request $request, $id)
    {
        $request->validate([
            'extension_days' => 'required|integer|min:1|max:15'
        ]);

        $booking = PlotBooking::where('plot_id', $id)
            ->where('status', PlotBooking::STATUS_BOOKED)
            ->latest()
            ->first();

        if (!$booking) {
            return back()->with('error', 'No active booking found.');
        }

        $booking->update(['extension_days' => $request->extension_days]);

        return back()->with('success', 'Agreement extended successfully.');
    }

    /* ================= DELETE ================= */

    public function destroy($id)
    {
        Plot::findOrFail($id)->delete();
        return redirect()->route('admin.plots.index')->with('success', 'Moved to trash');
    }

    public function trash()
    {
        $plots = Plot::onlyTrashed()->get();
        return view('plots.trash', compact('plots'));
    }

    public function restore($id)
    {
        Plot::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.plots.trash')->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        Plot::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.plots.trash')->with('success', 'Deleted permanently');
    }
    /* ================= BOOKINGS LIST (ADMIN + SALES) ================= */
public function bookingIndex(Request $request)
{
    $query = PlotBooking::with('plot')->latest();

    // 🔐 SALES → ONLY THEIR BOOKINGS
    if (auth()->user()->role === 'sales') {
    $query->where('sales_person_id', auth()->id());
}



    // 🧾 STATUS FILTERS (OPTIONAL)
    if ($request->status === 'booked') {
        $query->where('status', PlotBooking::STATUS_BOOKED);
    }

    if ($request->status === 'cancelled') {
        $query->where('status', PlotBooking::STATUS_CANCELLED);
    }

    $bookings = $query->paginate(20);

    return view('bookings.index', compact('bookings'));
}





/* ================= SINGLE BOOKING DETAILS (ADMIN + SALES) ================= */
    public function bookingShow($id)
    {
        $booking = PlotBooking::with('plot')->findOrFail($id);

        // 🔐 BLOCK SALES FROM OPENING OTHERS BOOKINGS
        if (auth()->user()->role === 'sales' && $booking->sales_person_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }


        return view('bookings.show', compact('booking'));
    }
    /* ================= RECEIPT PDF ================= */






public function downloadReceipt($id)
{
    $booking = PlotBooking::with('plot')->findOrFail($id);

    // ✅ LOAD PDF-SPECIFIC VIEW ONLY
    $pdf = Pdf::loadView('bookings.receipt-pdf', compact('booking'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('RaKe-Receipt-'.$booking->id.'.pdf');
}







}
