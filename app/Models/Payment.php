<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'plot_booking_id',
        'total_cost',
        'advance_amount',
        'agreement_amount',
        'net_balance',
        'paid_amount',
        'remaining_balance',
        'due_date',
        'payment_mode',
        'receipt_no',
    ];

    public function booking()
    {
        return $this->belongsTo(PlotBooking::class, 'plot_booking_id');
    }
}
