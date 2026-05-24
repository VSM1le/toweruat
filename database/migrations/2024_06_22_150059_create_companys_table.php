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
        Schema::create('companys', function (Blueprint $table) {
            $table->id();
            $table->char('company_code', 5); // COMPANY_CODE
            $table->char('com_abb', 10)->nullable(); // COM_ABB
            $table->char('com_building', 100)->nullable(); // COM_BUILDING
            $table->char('com_building2', 100)->nullable(); // COM_BUILDING2
            $table->char('com_name_th', 40)->nullable(); // COM_NAME_TH
            $table->char('com_name_en', 40)->nullable(); // COM_NAME_EN
            $table->char('com_taxid', 15)->nullable(); // COM_TAXID
            $table->char('com_address1', 100)->nullable(); // COM_ADDRESS1
            $table->char('com_address2', 50)->nullable(); // COM_ADDRESS2
            $table->char('com_tel', 20)->nullable(); // COM_TEL
            $table->char('com_fax', 20)->nullable(); // COM_FAX
            $table->smallInteger('com_vat_rate1')->nullable(); // COM_VAT_RATE1
            $table->date('com_startdate1')->nullable(); // COM_STARTDATE1
            $table->smallInteger('com_vat_rate2')->nullable(); // COM_VAT_RATE2
            $table->date('com_startdate2')->nullable(); // COM_STARTDATE2
            $table->integer('com_maxpark')->nullable(); // COM_MAXPARK
            $table->integer('com_m_maxpark')->nullable(); // COM_M_MAXPARK
            $table->time('com_starttime')->nullable(); // COM_STARTTIME
            $table->time('com_endtime')->nullable(); // COM_ENDTIME
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
        Schema::dropIfExists('companys');
    }
};
