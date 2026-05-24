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
        Schema::create('ps_groups', function (Blueprint $table) {
            $table->id();
            $table->char('ps_group',length:5);
            $table->char('ps_desc',length:30);
            $table->integer('begin_date');
            $table->integer('end_date');
            $table->timestamps();
            $table->foreignIdFor(User::class,'created_by')->constrained('users');
            $table->foreignIdFor(User::class,'updated_by')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ps_groups');
    }
};
