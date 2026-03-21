<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_booking_id')->constrained()->onDelete('cascade');
            $table->date('agreement_date');
            $table->string('agreement_number');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::table('agreements', function (Blueprint $table) {

            if (Schema::hasColumn('agreements', 'agreement_html')) {
                $table->dropColumn('agreement_html');
            }

        });
    }
};
