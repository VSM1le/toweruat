<?php

use App\Models\User;
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
        Schema::create('receip_details', function (Blueprint $table) {
             $table->id();
             $table->foreignId('receipt_header_id')->constrained()->onDelete('cascade');
            $table->integer('recd_seq'); // RECD_SEQ
            $table->char('recd_inv_no', 20)->nullable(); // RECD_INV_NO
            $table->char('recd_product_code', 10)->nullable(); // RECD_PRODUCT_CODE
            $table->char('recd_period', 50)->nullable(); // RECD_PERIOD
            $table->double('recd_amt', 15, 8)->nullable(); // RECD_AMT
            $table->double('recd_vat_amt', 15, 8)->nullable(); // RECD_VAT_AMT
            $table->double('recd_wh_tax_amt', 15, 8)->nullable(); // RECD_WH_TAX_AMT
            $table->double('recd_net_amt', 15, 8)->nullable(); // RECD_NET_AMT
            $table->char('recd_remark', 80)->nullable(); // RECD_REMARK
            $table->integer('recd_wh_tax_percent')->nullable(); // RECD_WH_TAX_PERCENT
            $table->integer('recd_vat_percent')->nullable(); // RECD_VAT_PERCENT
            $table->integer('recd_discount_percent')->nullable(); // RECD_DISCOUNT_PERCENT
            $table->double('recd_discount_amt', 15, 8)->nullable(); // RECD_DISCOUNT_AMT
            $table->char('recd_desc1', 80)->nullable(); // RECD_DESC1
            $table->char('recd_desc2', 80)->nullable(); // RECD_DESC2
            $table->foreignIdFor(User::class,'created_by')->constrained('users');
            $table->foreignIdFor(User::class,'updated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receip_details');
    }
};
