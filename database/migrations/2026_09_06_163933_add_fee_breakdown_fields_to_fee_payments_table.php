<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fee_payments', function (Blueprint $table) {
            $table->decimal('discount', 10, 2)->default(0)->after('arrears');
            $table->decimal('previous_advance', 10, 2)->default(0)->after('discount');
            $table->decimal('total_fees', 10, 2)->default(0)->after('previous_advance');
            $table->decimal('net_payable', 10, 2)->default(0)->after('total_fees');
        });
    }

    public function down(): void
    {
        Schema::table('fee_payments', function (Blueprint $table) {
            $table->dropColumn(['discount', 'previous_advance', 'total_fees', 'net_payable']);
        });
    }
};