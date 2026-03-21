<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Agreement;   // ✅ add this

class SaleDeed extends Model
{
    protected $fillable = [
        'agreement_id',
        'sale_deed_number',
        'sale_deed_date',
        'content',
    ];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
}
