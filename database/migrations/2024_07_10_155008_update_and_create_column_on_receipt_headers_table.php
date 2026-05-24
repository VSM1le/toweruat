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
        Schema::table('receipt_headers', function (Blueprint $table) {
            $table->char('rec_branch',90)->nullable();
            $table->char('rec_bank',90)->nullable()->change();
            $table->char('rec_cheque_no',30)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipt_headers', function (Blueprint $table) {
            $table->dropColumn('rec_branch');
            $table->char('rec_bank',20)->nullable()->change();
            $table->char('rec_cheque_no',10)->nullable()->change();
        });
    }
};
