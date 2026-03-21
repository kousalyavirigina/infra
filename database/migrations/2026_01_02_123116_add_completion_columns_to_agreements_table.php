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
    Schema::table('agreements', function (Blueprint $table) {
        $table->boolean('is_completed')->default(false)->after('agreement_html');
        $table->timestamp('completed_at')->nullable()->after('is_completed');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('agreements', function (Blueprint $table) {
        $table->dropColumn(['is_completed', 'completed_at']);
    });
}

};
