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
           $table->date('invoice_date')->nullable()->change(); 
           $table->date('due_date')->nullable()->change(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill', function (Blueprint $table) {
           $table->char('invoice_date',12)->nullable()->change();
           $table->char('due_date',12)->nullable()->change();
        });
    }
};
