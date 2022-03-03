<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public $fillable = [
        'paid_by',
        'others',
        'amount',
        'item',
        'created_at',
        'update_at',
    ];
}
