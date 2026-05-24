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
        Schema::create('invoice_headers', function (Blueprint $table) {
            $table->id();
            $table->char('inv_no',length:20);
            $table->date('inv_date')->nullable();
            $table->foreignId('ps_group_id')->constrained();
            $table->char('inv_ps_group', 5)->nullable();
            $table->char('inv_status',length:5)->nullable();
            $table->double('inv_tamp',15,8)->nullable();
            $table->double('inv_tvat_amt',15,8)->nullable();
            $table->double('inv_twh_tax_amt',15,8)->nullable();
            $table->double('inv_tdiscount_amt',15,8)->nullable();
            $table->char('inv_receipt_flag',length:5)->nullable();
            $table->double('inv_receipt_amt',15,8)->nullable();
            $table->char('inv_tower',length:1)->nullable();
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
        Schema::dropIfExists('invoice_headers');
    }
};
