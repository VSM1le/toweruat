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
        Schema::create('creditnote_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creditnote_header_id')->constrained()->cascadeOnDelete();
            $table->char('crd_service_code',20)->nullable();
            $table->char('crd_service_name',150)->nullable();
            $table->double('crd_amt')->nullable();
            $table->double('crd_tax_amt')->nullable();
            $table->double('crd_wh_amt')->nullable();
            $table->double('crd_net_amt')->nullable();
            $table->string('crd_remark')->nullable();
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
        Schema::dropIfExists('creditnote_details');
    }
};
