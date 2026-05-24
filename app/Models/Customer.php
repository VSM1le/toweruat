<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
         'cust_code',
        'cust_abb',
        'cust_name_th',
        'cust_name_en',
        'cust_contact',
        'cust_taxid',
        'cust_address_th1',
        'cust_address_th2',
        'cust_address_en1',
        'cust_address_en2',
        'cust_zipcode',
        'cust_floor',
        'cust_zone',
        'cust_room',
        'cust_ref_no',
        'cust_tel',
        'cust_fax',
        'cust_area_sqm',
        'cust_parking_area',
        'cust_fixfree',
        'cust_non_fixfree',
        'cust_nfixfree_amt',
        'cust_non_fixfree_pay',
        'cust_nfixfreep_amt',
        'cust_tenant_notcall',
        'cust_tnc_amt',
        'cust_conditions',
        'cust_conditions1',
        'cust_conditions2',
        'cust_contractno',
        'cust_frcontract_date',
        'cust_tocontract_date',
        'cust_parkfree_hour',
        'cust_calvat',
        'cust_calwhtax',
        'cust_invauto',
        'cust_branch',
        'cust_e_unitcost',
        'cust_costcenter',
        'cust_showmeter',
        'cust_gov_flag',
        'created_by',
        'updated_by',
    ];
    use HasFactory;

    public function invoiceheader():HasMany{
        return $this->hasMany(InvoiceHeader::class);
    } 
    public function customercontract():HasMany{
        return $this->hasMany(CustomerRental::class);
    }
}
