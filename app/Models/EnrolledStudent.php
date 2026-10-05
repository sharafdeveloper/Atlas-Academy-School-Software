<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrolledStudent extends Model
{
    protected $fillable = [
        'student_code',
        'name',
        'father_name',
        'class',
        'section',
        'board',
        'date_of_admission',
        'subjects',
        'subjects_count',
        'fees',
        'admission_fee',
        'base_fee',
        'status',
        'leaving_date',
        'discount',
        'fee_status',
        'phone_number',
        'whatsapp_number',
    ];

    protected $casts = [
        'subjects' => 'array',
        'subjects_count' => 'integer',
        'fees' => 'decimal:2',
        'admission_fee' => 'decimal:2',
        'base_fee' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }
}