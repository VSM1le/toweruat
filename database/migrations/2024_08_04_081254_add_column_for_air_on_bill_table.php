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
        Schema::table('bill', function (Blueprint $table) {
            $table->date('bill_tran_date')->nullable();
            $table->time('bill_open')->nullable();
            $table->time('bill_close')->nullable();
            $table->double('bill_use')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill', function (Blueprint $table) {
           $table->dropColumn('bill_tran_date'); 
           $table->dropColumn('bill_open');
           $table->dropColumn('bill_close');
           $table->dropColumn('bill_use');
        });
    }
};
