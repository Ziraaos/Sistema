<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'items',
        'cash',
        'change',
        'status',
        'user_id',
        'customer_id'
    ];
}
