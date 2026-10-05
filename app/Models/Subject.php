<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'monthly_fee',
        'status',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'status' => 'boolean',
    ];
}