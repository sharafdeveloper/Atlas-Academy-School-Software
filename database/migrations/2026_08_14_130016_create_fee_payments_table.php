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
       Schema::create('fee_payments', function (Blueprint $table) {

        $table->id();

        $table->foreignId('enrolled_student_id')
              ->constrained('enrolled_students')
              ->onDelete('cascade');

        $table->string('fee_month');

        $table->date('fee_date');

        $table->time('fee_time');

        $table->decimal('tuition_fee', 10, 2);

        $table->decimal('amount_received', 10, 2);

        $table->decimal('remaining_amount', 10, 2)
              ->default(0);

        $table->decimal('advance_amount', 10, 2)
              ->default(0);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
