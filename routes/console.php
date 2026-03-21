<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Models\PlotBooking;
use App\Models\Plot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $expiredBookings = PlotBooking::where('booking_status', 'booked')
        ->whereDate('agreement_due_date', '<', Carbon::today())
        ->get();

    foreach ($expiredBookings as $booking) {
        // Mark booking as expired
        $booking->update([
            'booking_status' => 'expired'
        ]);

        // Make plot available again
        Plot::where('id', $booking->plot_id)
            ->update(['status' => 'available']);
    }
})->daily();


Schedule::command('expire:plot-bookings')->daily();
