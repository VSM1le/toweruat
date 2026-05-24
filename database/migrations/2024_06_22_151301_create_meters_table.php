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
        Schema::create('meters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->char('meter_code', 20); // METER_CODE
            $table->char('meter_name', 50)->nullable(); // METER_NAME
            $table->char('meter_type', 5)->nullable(); // METER_TYPE
            $table->char('meter_floor', 20)->nullable(); // METER_FLOOR
            $table->char('meter_zone', 5)->nullable(); // METER_ZONE
            $table->char('meter_tower', 5)->nullable(); // METER_TOWER
            $table->char('meter_status', 5)->nullable(); // METER_STATUS
            $table->float('meter_ratio')->nullable(); // METER_RATIO
            $table->float('meter_area')->nullable(); // METER_AREA
            $table->smallInteger('meter_totalarea')->nullable(); // METER_TOTALAREA
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
        Schema::dropIfExists('meters');
    }
};
