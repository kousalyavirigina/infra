<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plot_no',
        'sq_yards',
        'gadhulu',
        'facing',
        'road_width',
        'status',
        'x',
        'y',
    ];
    
    /* ================= BOOKINGS ================= */

    public function bookings()
    {
        return $this->hasMany(\App\Models\PlotBooking::class);
    }
    public function latestActiveBooking()
    {
        return $this->hasOne(\App\Models\PlotBooking::class)
            ->where('status', \App\Models\PlotBooking::STATUS_BOOKED)
            ->latestOfMany();
    }


}

