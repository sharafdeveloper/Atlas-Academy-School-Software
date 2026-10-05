<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teacher_salary_payments', function (Blueprint $table) {

            $table->id();

            // Teacher
            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->cascadeOnDelete();

            // Salary month
            $table->string('salary_month');

            // Salary calculation
            $table->decimal('weekly_classes', 10, 2);
            $table->decimal('per_class_charge', 10, 2);
            $table->decimal('salary_amount', 10, 2);

            // Payment information
            $table->date('payment_date');
            $table->time('payment_time')->nullable();

            $table->enum('status', ['Paid', 'Pending'])
                ->default('Paid');

            $table->text('notes')->nullable();

            $table->timestamps();

            // Prevent duplicate salary payment for same teacher/month
            $table->unique([
                'teacher_id',
                'salary_month'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_salary_payments');
    }
};
