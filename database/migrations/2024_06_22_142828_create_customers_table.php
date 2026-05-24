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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->char('cust_code', 10); // CUST_CODE
            $table->char('cust_abb', 20)->nullable(); // CUST_ABB
            $table->char('cust_name_th', 120)->nullable(); // CUST_NAME_TH
            $table->char('cust_name_en', 120)->nullable(); // CUST_NAME_EN
            $table->char('cust_contact', 40)->nullable(); // CUST_CONTACT
            $table->char('cust_taxid', 15)->nullable(); // CUST_TAXID
            $table->char('cust_address_th1', 200)->nullable(); // CUST_ADDRESS_TH1
            $table->char('cust_address_th2', 100)->nullable(); // CUST_ADDRESS_TH2
            $table->char('cust_address_en1', 200)->nullable(); // CUST_ADDRESS_EN1
            $table->char('cust_address_en2', 100)->nullable(); // CUST_ADDRESS_EN2
            $table->char('cust_zipcode', 5)->nullable(); // CUST_ZIPCODE
            $table->char('cust_floor', 20)->nullable(); // CUST_FLOOR
            $table->char('cust_zone', 20)->nullable(); // CUST_ZONE
            $table->char('cust_room', 100)->nullable(); // CUST_ROOM
            $table->char('cust_ref_no', 10)->nullable(); // CUST_REF_NO
            $table->char('cust_tel', 20)->nullable(); // CUST_TEL
            $table->char('cust_fax', 20)->nullable(); // CUST_FAX
            $table->double('cust_area_sqm', 15, 8)->nullable(); // CUST_AREA_SQM
            $table->integer('cust_parking_area')->nullable(); // CUST_PARKING_AREA
            $table->integer('cust_fixfree')->nullable(); // CUST_FIXFREE
            $table->integer('cust_non_fixfree')->nullable(); // CUST_NON_FIXFREE
            $table->double('cust_nfixfree_amt', 15, 8)->nullable(); // CUST_NFIXFREE_AMT
            $table->integer('cust_non_fixfree_pay')->nullable(); // CUST_NON_FIXFREE_PAY
            $table->double('cust_nfixfreep_amt', 15, 8)->nullable(); // CUST_NFIXFREEP_AMT
            $table->integer('cust_tenant_notcall')->nullable(); // CUST_TENANT_NOTCALL
            $table->double('cust_tnc_amt', 15, 8)->nullable(); // CUST_TNC_AMT
            $table->char('cust_conditions', 80)->nullable(); // CUST_CONDITIONS
            $table->char('cust_conditions1', 80)->nullable(); // CUST_CONDITIONS1
            $table->char('cust_conditions2', 80)->nullable(); // CUST_CONDITIONS2
            $table->char('cust_contractno', 20)->nullable(); // CUST_CONTRACTNO
            $table->date('cust_frcontract_date')->nullable(); // CUST_FRCONTRACT_DATE
            $table->date('cust_tocontract_date')->nullable(); // CUST_TOCONTRACT_DATE
            $table->double('cust_parkfree_hour', 15, 8)->nullable(); // CUST_PARKFREE_HOUR
            $table->char('userid', 20)->nullable(); // USERID
            $table->date('lastupdated')->nullable(); // LASTUPDATED
            $table->char('cust_calvat', 5)->nullable(); // CUST_CALVAT
            $table->char('cust_calwhtax', 5)->nullable(); // CUST_CALWHTAX
            $table->char('cust_invauto', 5)->nullable(); // CUST_INVAUTO
            $table->char('cust_branch', 20)->nullable(); // CUST_BRANCH
            $table->double('cust_e_unitcost', 15, 8)->nullable(); // CUST_E_UNITCOST (DP1)
            $table->char('cust_costcenter', 20)->nullable(); // CUST_COSTCENTER
            $table->char('cust_showmeter', 5)->nullable(); // CUST_SHOWMETER
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
        Schema::dropIfExists('customers');
    }
};
