<?php

namespace App\Mail;

use App\Models\PlotBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public PlotBooking $booking;

    public function __construct(PlotBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('RaKe Infra - Booking Receipt (Plot ' . $this->booking->plot->plot_no . ')')
            ->view('emails.booking-receipt');
    }
}
