<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_plots_table.php
public function up()
{
    Schema::create('plots', function (Blueprint $table) {
        $table->id();
        $table->string('plot_no');
        $table->integer('sq_yards'); // 180
        $table->string('facing');    // East / West
        $table->integer('road_width'); // 30 / 40
        $table->enum('status', ['available', 'booked'])->default('available');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};
