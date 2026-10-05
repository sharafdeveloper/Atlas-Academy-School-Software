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
        Schema::table('enrolled_students', function (Blueprint $table) {

            // Selected subjects
            $table->json('subjects')
                ->nullable()
                ->after('board');

            // Number of selected subjects
            $table->unsignedInteger('subjects_count')
                ->default(0)
                ->after('subjects');

            // Original fee from Fee Structure
            $table->decimal('base_fee', 10, 2)
                ->default(0)
                ->after('fees');

            // Discount given to student
            $table->decimal('discount', 10, 2)
                ->default(0)
                ->after('base_fee');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrolled_students', function (Blueprint $table) {

            $table->dropColumn([
                'subjects',
                'subjects_count',
                'base_fee',
                'discount',
            ]);

        });
    }
};