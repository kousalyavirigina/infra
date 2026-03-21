<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            if (!Schema::hasColumn('plots', 'x')) {
                $table->decimal('x', 10, 6)->nullable();
            }

            if (!Schema::hasColumn('plots', 'y')) {
                $table->decimal('y', 10, 6)->nullable();
            }
});

    }

    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->dropColumn(['x','y']);
        });
    }
};
