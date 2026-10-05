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
        Schema::create('teachers', function (Blueprint $table) {
    $table->id();

    $table->string('name');

    $table->string('phone_number')->nullable();
    $table->string('whatsapp_number')->nullable();

    $table->unsignedInteger('weekly_classes')->default(0);

    $table->decimal('per_class_charge', 10, 2)->default(0);

    $table->date('joining_date')->nullable();

    $table->enum('status', ['Active', 'Inactive'])
          ->default('Active');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
