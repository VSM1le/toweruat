<?php

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
        Schema::table('creditnote_headers', function (Blueprint $table) {
            $table->string('credit_remark')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creditnote_headers', function (Blueprint $table) {
            $table->dropColumn('credit_remark'); 
        });
    }
};
