<?php

use App\Models\Customer;
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
        Schema::create('creditnote_headers', function (Blueprint $table) {
            $table->id();
            $table->date('credit_date')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->foreignId('customer_rental_id')->nullable()->constrained();
            $table->string('credit_room_num')->nullable();
            $table->char('credit_receipt_num')->nullable();
            $table->date('credit_receipt_date')->nullable();
            $table->foreignId('receipt_header_id')->nullable()->constrained();
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
        Schema::dropIfExists('creditnote_headers');
    }
};
