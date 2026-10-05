<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = [
        'class',
        'board',
        'number_of_subjects',
        'monthly_fee',
        'status',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'status' => 'boolean',
    ];
}