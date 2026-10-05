<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrolled_students', function (Blueprint $table) {
            $table->date('leaving_date')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('enrolled_students', function (Blueprint $table) {
            $table->dropColumn('leaving_date');
        });
    }
};