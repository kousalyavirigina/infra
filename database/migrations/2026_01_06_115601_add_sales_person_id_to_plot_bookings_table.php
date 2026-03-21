<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plot_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_person_id')->nullable()->after('id');

            // SQLite supports foreign keys, but sometimes not enforced unless enabled.
            // This is safe even if not enforced.
            $table->foreign('sales_person_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('plot_bookings', function (Blueprint $table) {
            $table->dropForeign(['sales_person_id']);
            $table->dropColumn('sales_person_id');
        });
    }
};
