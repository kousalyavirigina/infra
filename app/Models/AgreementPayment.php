<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgreementPayment extends Model
{
    protected $fillable = [
        'agreement_id',
        'amount',
        'payment_mode',
        'reference_no',
        'bank_name',
        'receipt_no',
        'payment_date',
    ];

    protected $dates = ['payment_date'];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
}
