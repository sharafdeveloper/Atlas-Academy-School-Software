<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeePaymentAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_payment_id',
        'enrolled_student_id',
        'fee_month',
        'amount_allocated',
    ];

    public function feePayment()
    {
        return $this->belongsTo(FeePayment::class);
    }

    public function enrolledStudent()
    {
        return $this->belongsTo(EnrolledStudent::class);
    }
}