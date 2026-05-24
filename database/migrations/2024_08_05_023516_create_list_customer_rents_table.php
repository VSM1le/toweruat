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
        Schema::create('list_customer_rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_rental_id')->constrained();
            $table->foreignId('product_service_id')->constrained();
            $table->string('lcr_remark')->nullable();
            $table->double('lcr_area_sqm')->nullable();
            $table->double('lcr_rental_fee')->nullable();
            $table->double('lcr_service_fee')->nullable();
            $table->double('lcr_equipment_fee')->nullable();
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
        Schema::dropIfExists('list_customer_rents');
    }
};
