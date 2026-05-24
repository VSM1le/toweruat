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
        Schema::create('product_services', function (Blueprint $table) {
            $table->id();
            $table->char('ps_code', 10); // PS_CODE
            $table->char('ps_abb', 10)->nullable(); // PS_ABB
            $table->char('ps_name_th', 50)->nullable(); // PS_NAME_TH
            $table->char('ps_name_en', 50)->nullable(); // PS_NAME_EN
            $table->char('ps_unit', 20)->nullable(); // PS_UNIT
            $table->double('ps_price', 15, 8)->nullable(); // PS_PRICE
            $table->char('ps_type', 5)->nullable(); // PS_TYPE
            $table->foreignId('ps_group_id')->nullable()->constrained();
            $table->smallInteger('ps_vat')->nullable(); // PS_VAT (SMALLINT)
            $table->smallInteger('ps_whtax')->nullable(); // PS_WHTAX (SMALLINT)
            $table->char('ps_tower', 5)->nullable(); // PS_TOWER
            $table->char('ps_price_gr', 5)->nullable(); // PS_PRICE_GR
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
        Schema::dropIfExists('product_services');
    }
};
