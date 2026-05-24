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
        Schema::table('customer_rentals', function (Blueprint $table) {
            $table->double('insurance_rental')->nullable();
            $table->double('insurance_service')->nullable();
            $table->text('contract_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_rentals', function (Blueprint $table) {
            $table->dropColumn('insurance_rental'); 
            $table->dropColumn('insurance_service'); 
            $table->dropColumn('contract_note'); 
        });
    }
};
