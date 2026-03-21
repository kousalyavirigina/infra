<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PlotBooking extends Model
{

    const STATUS_BOOKED = 'booked';
    const STATUS_CANCELLED = 'cancelled';
    protected $fillable = [
    'plot_id',
    'customer_name',
    'father_name',
    'date_of_birth',
    'contact_number',
    'alternate_contact_number',
    'email',
    'permanent_address',
    'temporary_address',
    'same_address',
    'booking_date_time',
    'advance_amount',
    'payment_method',
    'agreement_due_date',
    'extension_days',
    'status',
    'live_photo_path',
    'admin_email_note',
    'created_by',

    // ✅ ADD THIS LINE
    'sales_person_id',
];


    protected $casts = [
        'date_of_birth' => 'date',
        'booking_date_time' => 'datetime',
        'agreement_due_date' => 'date',
        'same_address' => 'boolean',
    ];

    public function plot()
    {
        return $this->belongsTo(\App\Models\Plot::class);
    }


    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function salesPerson()
{
    return $this->belongsTo(\App\Models\User::class, 'sales_person_id');
}

public function agreement()
{
    return $this->hasOne(\App\Models\Agreement::class, 'plot_booking_id');
}



}
