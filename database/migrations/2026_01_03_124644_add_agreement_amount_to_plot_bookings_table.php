<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgreementAmountToPlotBookingsTable extends Migration
{
    public function up(): void
    {
        Schema::table('plot_bookings', function (Blueprint $table) {
            $table->decimal('agreement_amount', 12, 2)
                  ->default(0)
                  ->after('advance_amount');
        });
    }

    public function down(): void
    {
        Schema::table('plot_bookings', function (Blueprint $table) {
            $table->dropColumn('agreement_amount');
        });
    }
}
