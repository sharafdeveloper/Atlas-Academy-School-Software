<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryStudent extends Model
{
    protected $fillable = [
        'name',
        'class',
        'board',
        'phone_number',
        'whatsapp_number',
        'interested_course',
        'inquiry_date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'inquiry_date' => 'date',
    ];
}