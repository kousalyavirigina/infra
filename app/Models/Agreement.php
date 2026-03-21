<?php

namespace App\Models;
use App\Models\SaleDeed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AgreementPayment;
class Agreement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plot_booking_id',
        'agreement_date',
        'agreement_number',
        'agreement_html',
        'language',

        // ✅ required for sale deed flow
        'is_completed',
        'completed_at',
        'agreement_paid_amount',
    ];

    protected $casts = [
        'is_completed'   => 'boolean',
        'completed_at'   => 'datetime',
        'agreement_date' => 'date',
    ];

    public function booking()
{
    return $this->belongsTo(\App\Models\PlotBooking::class, 'plot_booking_id');
}

public function payments()
{
    return $this->hasMany(\App\Models\AgreementPayment::class);
}


    public function saleDeed()
{
    return $this->hasOne(SaleDeed::class);
}


    public function isSaleDeedAllowed(): bool
    {
        if (!$this->is_completed) return false;
        if (!$this->completed_at) return false;

        return now()->diffInDays($this->completed_at) <= 45;
    }
    




}
