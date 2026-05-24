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
        Schema::create('customer_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // CUST_CODE
            $table->integer('custr_no'); // CUSTR_NO
            $table->char('custr_contract_no', 20)->nullable(); // CUSTR_CONTRACT_NO
            $table->char('custr_tower', 5)->nullable(); // CUSTR_TOWER
            $table->char('custr_unit', 30)->nullable(); // CUSTR_UNIT
            $table->char('custr_floor', 20)->nullable(); // CUSTR_FLOOR
            $table->char('custr_zone', 20)->nullable(); // CUSTR_ZONE
            $table->char('custr_sub_zone', 20)->nullable(); // CUSTR_SUB_ZONE
            $table->decimal('custr_area_sqm', 15, 2)->nullable(); // CUSTR_AREA_SQM
            $table->decimal('custr_rental_fee', 15, 2)->nullable(); // CUSTR_RENTAL_FEE
            $table->decimal('custr_service_fee', 15, 2)->nullable(); // CUSTR_SERVICE_FEE
            $table->decimal('custr_equipment_fee', 15, 2)->nullable(); // CUSTR_EQUIPMENT_FEE
            $table->char('custr_begin_date2', 10)->nullable(); // CUSTR_BEGIN_DATE2
            $table->char('custr_end_date2', 10)->nullable(); // CUSTR_END_DATE2
            $table->char('custr_contract_year', 5)->nullable(); // CUSTR_CONTRACT_YEAR
            $table->char('custr_contract_link', 100)->nullable(); // CUSTR_CONTRACT_LINK
            $table->char('custr_normal_meter', 10)->nullable(); // CUSTR_NORMAL_METER
            $table->float('custr_normal_ratio')->nullable(); // CUSTR_NORMAL_RATIO
            $table->char('custr_emergency_meter', 10)->nullable(); // CUSTR_EMERGENCY_METER
            $table->float('custr_emergency_ratio')->nullable(); // CUSTR_EMERGENCY_RATIO
            $table->char('custr_air_meter', 10)->nullable(); // CUSTR_AIR_METER
            $table->float('custr_air_ratio')->nullable(); // CUSTR_AIR_RATIO
            $table->char('custr_air_shared', 5)->nullable(); // CUSTR_AIR_SHARED
            $table->decimal('custr_surcharge', 15, 2)->nullable(); // CUSTR_SURCHARGE
            $table->decimal('custr_coolingw', 15, 2)->nullable(); // CUSTR_COOLINGW
            $table->date('custr_begin_date')->nullable(); // CUSTR_BEGIN_DATE
            $table->date('custr_end_date')->nullable(); // CUSTR_END_DATE
            $table->char('custr_active', 1)->nullable(); // CUSTR_ACTIVE
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
        Schema::dropIfExists('customer_rentals');
    }
};
