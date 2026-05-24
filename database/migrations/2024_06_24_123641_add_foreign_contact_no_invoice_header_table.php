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
        Schema::table('invoice_headers', function (Blueprint $table) {
            $table->foreignId('customer_rental_id')->constrained();
        });
    }

    /**     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_headers', function (Blueprint $table) {
         $table->dropForeign(['customer_rental_id']);
        
        // Drop the column 'customer_rental_id' itself
        $table->dropColumn('customer_rental_id');
        });
    }
};
