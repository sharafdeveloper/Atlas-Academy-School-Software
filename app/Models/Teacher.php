<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'whatsapp_number',
        'weekly_classes',
        'per_class_charge',
        'joining_date',
        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'per_class_charge' => 'decimal:2',
    ];

    public function salaryPayments()
    {
        return $this->hasMany(TeacherSalaryPayment::class);
    }
}