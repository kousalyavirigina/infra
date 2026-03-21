<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    protected $table = 'requests';

    protected $fillable = [
    'name',
    'email',
    'phone',
    'request_type',
    'message'
    ];
}
