<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeePayment extends Model
{
    use HasFactory;
    protected $fillable = [
    'enrolled_student_id',
    'fee_month',
    'fee_date',
    'fee_time',
    'tuition_fee',
    'discount',           // add
    'admission_fee',
    'admission_fee_waiver',
    'arrears',
    'previous_advance',   // add
    'total_fees',         // add
    'net_payable',        // add
    'amount_received',
    'remaining_amount',
    'advance_amount',
    'collected_by',
];

    // protected $fillable = [
    //     'enrolled_student_id',
    //     'fee_month',
    //     'fee_date',
    //     'fee_time',
    //     'tuition_fee',
    //     'admission_fee',
    //     'admission_fee_waiver',
    //     'arrears',
    //     'amount_received',
    //     'remaining_amount',
    //     'advance_amount',
    //     'collected_by',
    // ];

    public function enrolledStudent()
    {
        return $this->belongsTo(EnrolledStudent::class);
    }
    public function allocations()
{
    return $this->hasMany(FeePaymentAllocation::class);
}
}