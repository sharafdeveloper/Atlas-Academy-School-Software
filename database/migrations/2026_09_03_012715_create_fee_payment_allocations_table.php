<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_payment_allocations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fee_payment_id')
                ->constrained('fee_payments')
                ->cascadeOnDelete();

            $table->foreignId('enrolled_student_id')
                ->constrained('enrolled_students')
                ->cascadeOnDelete();

            $table->string('fee_month');

            $table->decimal('amount_allocated', 10, 2);

            $table->timestamps();

            $table->index([
                'enrolled_student_id',
                'fee_month'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_payment_allocations');
    }
};