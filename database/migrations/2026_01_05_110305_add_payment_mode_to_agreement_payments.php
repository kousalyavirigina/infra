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
        Schema::table('agreement_payments', function (Blueprint $table) {
            $table->string('payment_mode')->after('amount');
            $table->string('reference_no')->nullable()->after('payment_mode');
            $table->string('bank_name')->nullable()->after('reference_no');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agreement_payments', function (Blueprint $table) {
            //
        });
    }
};
