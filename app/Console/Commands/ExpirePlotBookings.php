<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlotBooking;
use App\Models\Plot;
use Carbon\Carbon;

class ExpirePlotBookings extends Command
{
    protected $signature = 'expire:plot-bookings';
    protected $description = 'Expire bookings past agreement due date and set plot to available';

    public function handle()
    {
        $today = Carbon::today();

        $bookings = PlotBooking::where('booking_status', 'booked')->get();

        foreach ($bookings as $booking) {

            $finalDue = Carbon::parse($booking->agreement_due_date)
                ->addDays((int) ($booking->extension_days ?? 0));

            if ($today->greaterThan($finalDue)) {

                // Expire booking
                $booking->update([
                    'booking_status' => 'expired'
                ]);

                // Make plot available again
                Plot::where('id', $booking->plot_id)
                    ->update(['status' => 'available']);
            }
        }

        $this->info('Expired bookings checked successfully.');
        return Command::SUCCESS;
    }
}
