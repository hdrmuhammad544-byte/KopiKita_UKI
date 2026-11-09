<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('service_type')
                ->default('takeaway')
                ->after('payment_method');

            $table->string('table_number')
                ->nullable()
                ->after('service_type');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'service_type',
                'table_number',
            ]);
        });
    }
};
