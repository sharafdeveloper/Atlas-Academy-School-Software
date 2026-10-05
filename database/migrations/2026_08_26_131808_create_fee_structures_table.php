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
        Schema::create('fee_structures', function (Blueprint $table) {

        $table->id();

        $table->string('class');

        $table->string('board');

        $table->unsignedTinyInteger('number_of_subjects');

        $table->decimal('monthly_fee', 10, 2);

        $table->boolean('status')->default(true);

        $table->timestamps();

        // One fee structure for each
        // class + board + subject count
        $table->unique([
            'class',
            'board',
            'number_of_subjects'
        ]);

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
