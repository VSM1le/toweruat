<?php

use App\Models\Customer;
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
        Schema::table('receipt_headers', function (Blueprint $table) {
           $table->dropColumn('rec_cust_code'); 
           $table->foreignId('customer_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipt_header', function (Blueprint $table) {
            $table->char('rec_cust_code',10)->nullable();
            $table->dropColumn('customer_id');
        });
    }
};
