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
    Schema::create('sale_deeds', function (Blueprint $table) {
        $table->id();
        $table->foreignId('agreement_id')->constrained()->cascadeOnDelete();
        $table->string('sale_deed_number')->unique();
        $table->date('sale_deed_date');
        $table->longText('content'); // FULL SALE DEED HTML
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_deeds');
    }
};
