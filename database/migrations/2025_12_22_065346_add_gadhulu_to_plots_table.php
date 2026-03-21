<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    



public function up(): void
{
    Schema::table('plots', function (Blueprint $table) {
        $table->decimal('gadhulu', 8, 2)->nullable()->after('sq_yards');
    });
}

public function down(): void
{
    Schema::table('plots', function (Blueprint $table) {
        $table->dropColumn('gadhulu');
    });
}
};