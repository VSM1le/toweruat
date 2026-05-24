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
        Schema::create('invoice_details', function (Blueprint $table) {
             $table->id();
            $table->foreignId('invoice_header_id')->constrained()->onDelete('cascade');
            $table->integer('invd_seq');
            $table->char('invd_product_code',10)->nullable();
            $table->char('invd_period',50)->nullable();
            $table->double('invd_amt',15,8)->nullable();
            $table->double('invd_vat_amt',15,8)->nullable();
            $table->double('invd_wh_tax_amt',15,8)->nullable();
            $table->double('invd_net_amt',15,8)->nullable();
            $table->char('invd_remake',80)->nullable();
            $table->integer('invd_wh_tax_percent')->nullable();
            $table->integer('invd_vat_percent')->nullable();
            $table->integer('indv_discount_percent')->nullable();
            $table->double('invd_discount_amt',15,8)->nullable();
            $table->char('invd_desc1',80)->nullable();
            $table->char('invd_desc2',80)->nullable();
            $table->char('invd_receipt_flag',5)->nullable();
            $table->double('invd_receipt_amt',15,8)->nullable();
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
        Schema::dropIfExists('invoice_details');
    }
};
