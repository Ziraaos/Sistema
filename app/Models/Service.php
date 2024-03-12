<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'dwn_spd',
        'up_spd',
        'plan_id'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
