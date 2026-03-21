<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plot_booking_id')
                ->constrained('plot_bookings')
                ->cascadeOnDelete();

            $table->date('agreement_date')->nullable();
            $table->string('agreement_number')->nullable();
            $table->text('schedule_of_property')->nullable();

            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
