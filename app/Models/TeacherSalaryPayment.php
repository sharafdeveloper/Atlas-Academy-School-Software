<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherSalaryPayment extends Model
{
    protected $fillable = [
        'teacher_id',
        'salary_month',
        'weekly_classes',
        'per_class_charge',
        'salary_amount',
        'payment_date',
        'payment_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'weekly_classes' => 'decimal:2',
        'per_class_charge' => 'decimal:2',
        'salary_amount' => 'decimal:2',
    ];

    /**
     * Salary payment belongs to a teacher.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
