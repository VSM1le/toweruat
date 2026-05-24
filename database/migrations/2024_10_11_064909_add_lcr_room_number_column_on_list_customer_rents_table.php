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
        Schema::table('list_customer_rents', function (Blueprint $table) {
            $table->string('lcr_room_number')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('list_customer_rents', function (Blueprint $table) {
            $table->dropColumn('lcr_room_number'); 
        });
    }
};
