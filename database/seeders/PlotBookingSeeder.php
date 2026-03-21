<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlotBooking;
use App\Models\Plot;

class PlotBookingSeeder extends Seeder
{
    public function run()
    {
        $plot = Plot::first(); // take first plot

        PlotBooking::create([
        'plot_id' => $plot->id,
        'customer_name' => 'Kiran',
        'father_name' => 'Ramayya',
        'contact_number' => '1234455598',
        'email' => 'kiran@email.com',
        'permanent_address' => 'Hyderabad',
        'temporary_address' => 'Hyderabad',
        'same_address' => true,

        'booking_date_time' => now(),
        'agreement_due_date' => now()->addDays(7), // ✅ REQUIRED FIX

        'advance_amount' => 50000,
        'payment_method' => 'offline',
        'status' => 'booked',
    ]);


        $plot->update(['status' => 'booked']);
    }
}
