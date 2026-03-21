<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('expense_category_id')
                ->constrained('expense_categories')
                ->cascadeOnDelete();

            $table->date('expense_date');
            $table->string('approved_by');
            $table->string('payment_mode'); // cash/upi/neft/rtgs/online/cheque
            $table->decimal('amount', 12, 2);
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
