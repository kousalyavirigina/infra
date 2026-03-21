<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

$table->unsignedBigInteger('plot_booking_id');

            $table->decimal('total_cost', 12, 2);
            $table->decimal('advance_amount', 12, 2)->default(0);
            $table->decimal('agreement_amount', 12, 2)->default(0);
            $table->decimal('net_balance', 12, 2);
            $table->decimal('paid_amount', 12, 2);
            $table->decimal('remaining_balance', 12, 2);

            $table->date('due_date')->nullable();
            $table->string('payment_mode');
            $table->string('receipt_no')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
