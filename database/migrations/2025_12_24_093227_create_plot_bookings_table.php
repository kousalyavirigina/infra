<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plot_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plot_id')->constrained('plots')->cascadeOnDelete();

            // Customer details
            $table->string('customer_name');
            $table->string('father_name')->nullable();
            $table->date('date_of_birth')->nullable();

            // Contact
            $table->string('contact_number');
            $table->string('alternate_contact_number')->nullable();
            $table->string('email')->nullable();

            // Address
            $table->text('permanent_address');
            $table->text('temporary_address')->nullable();
            $table->boolean('same_address')->default(false);

            // Booking details
            $table->dateTime('booking_date_time');
            $table->unsignedInteger('advance_amount'); // in INR
            $table->enum('payment_method', ['upi', 'offline']);

            // Agreement
            $table->date('agreement_due_date');     // booking + 50 days
            $table->unsignedTinyInteger('extension_days')->default(0); // admin: 0-15
            $table->enum('status', ['booked', 'cancelled', 'expired'])->default('booked');

            // Media
            $table->string('live_photo_path')->nullable();

            // Admin editable email note
            $table->text('admin_email_note')->nullable();

            // Tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plot_bookings');
    }
};
