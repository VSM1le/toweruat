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
        Schema::create('receipt_headers', function (Blueprint $table) {
            $table->id();
            $table->char('rec_no', 20); // REC_NO
            $table->date('rec_date')->nullable(); // REC_DATE
            $table->char('rec_cust_code', 10)->nullable(); // REC_CUST_CODE
            $table->char('rec_inv_no', 20)->nullable(); // REC_INV_NO
            $table->char('rec_ps_group', 5)->nullable(); // REC_PS_GROUP
            $table->char('rec_status', 5)->nullable(); // REC_STATUS
            $table->double('rec_tamt', 15, 8)->nullable(); // REC_TAMT
            $table->double('rec_tvat_amt', 15, 8)->nullable(); // REC_TVAT_AMT
            $table->double('rec_twh_tax_amt', 15, 8)->nullable(); // REC_TWH_TAX_AMT
            $table->double('rec_tnet_amt', 15, 8)->nullable(); // REC_TNET_AMT
            $table->double('rec_tdiscount_amt', 15, 8)->nullable(); // REC_TDISCOUNT_AMT
            $table->char('rec_payment_type', 5)->nullable(); // REC_PAYMENT_TYPE
            $table->double('rec_payment_amt', 15, 8)->nullable(); // REC_PAYMENT_AMT
            $table->double('rec_payment_diff', 15, 8)->nullable(); // REC_PAYMENT_DIFF
            $table->char('rec_bank', 20)->nullable(); // REC_BANK
            $table->char('rec_cheque_no', 10)->nullable(); // REC_CHEQUE_NO
            $table->date('rec_cheque_date')->nullable(); // REC_CHEQUE_DATE
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
        Schema::dropIfExists('receipt_headers');
    }
};
