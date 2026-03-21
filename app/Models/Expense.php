<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_category_id',
        'expense_date',
        'approved_by',
        'payee',
        'payment_mode',
        'amount',
        'notes',
        'created_by',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}
