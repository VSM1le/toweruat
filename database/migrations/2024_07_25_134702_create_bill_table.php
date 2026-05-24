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
        Schema::create('bill', function (Blueprint $table) {
            $table->id();
            $table->char('contract_no',20)->nullable();
            $table->char('unit',10)->nullable();
            $table->char('meter',30)->nullable();
            $table->double('p_time')->nullable();
            $table->double('t_time')->nullable();
            $table->double('p_unit')->nullable();
            $table->double('price_unit')->nullable();
            $table->char('status',10)->nullable();
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
        Schema::dropIfExists('bill');
    }
};
