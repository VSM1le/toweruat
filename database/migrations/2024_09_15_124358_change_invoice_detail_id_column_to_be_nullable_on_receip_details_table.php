<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('receip_details', function (Blueprint $table) {

            $table->dropForeign(['invoice_detail_id']);
            $table->unsignedBigInteger('invoice_detail_id')->nullable()->change();
            $table->foreign('invoice_detail_id')->references('id')->on('invoice_details');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receip_details', function (Blueprint $table) {

            $table->dropForeign(['invoice_detail_id']);
            $table->unsignedBigInteger('invoice_detail_id')->change(); 
            $table->foreign('invoice_detail_id')->references('id')->on('invoice_details');

        });
    }
};
