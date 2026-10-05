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
        Schema::create('inquiry_students', function (Blueprint $table) {
        $table->id();

        $table->string('name');

        $table->enum('class', ['IX', 'X', 'XI', 'XII']);

        $table->enum('board', [
            'Federal Board',
            'Karachi Board'
        ]);

        $table->string('phone_number');

        $table->string('whatsapp_number');

        $table->string('interested_course');

        $table->date('inquiry_date');

        $table->enum('status', [
            'New',
            'Contacted',
            'Joined',
            'Not Interested'
        ])->default('New');

        $table->text('remarks')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_students');
    }
};
