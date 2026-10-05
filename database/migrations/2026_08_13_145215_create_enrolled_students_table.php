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
         Schema::create('enrolled_students', function (Blueprint $table) {
        $table->id();

        $table->string('name');

        $table->string('class');

        $table->string('board');

        $table->string('phone_number');

        $table->string('whatsapp_number');

        $table->decimal('fees', 10, 2);

        $table->enum('fee_status', ['Paid', 'Fee Defaulter'])
    ->default('Fee Defaulter');

        $table->enum('status', ['Active', 'Inactive'])
            ->default('Active');

        $table->text('remarks')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolled_students');
    }
};
