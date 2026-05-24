<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerRental extends Model
{
    use HasFactory; 

    protected $table = 'customer_rentals';
    protected $fillable = [
        'cust_code',
        'customer_id',
        'custr_no',
        'custr_contract_no',
        'custr_tower',
        'custr_unit',
        'custr_floor',
        'custr_zone',
        'custr_sub_zone',
        'custr_area_sqm',
        'custr_rental_fee',
        'custr_service_fee',
        'custr_equipment_fee',
        'custr_begin_date2',
        'custr_end_date2',
        'custr_contract_year',
        'custr_contract_link',
        'custr_normal_meter',
        'custr_normal_ratio',
        'custr_emergency_meter',
        'custr_emergency_ratio',
        'custr_air_meter',
        'custr_air_ratio',
        'custr_air_shared',
        'custr_surcharge',
        'custr_coolingw',
        'custr_begin_date',
        'custr_end_date',
        'custr_active',
        'created_by',
        'updated_by',
        'custr_contract_no_real',
        'insurance_rental',
        'insurance_service',
        'contract_note',
    ];

    public function invoiceheader():HasMany{
        return $this->hasMany(InvoiceHeader::class);
    }
    public function customer():BelongsTo{
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function listcust():HasMany{
        return $this->hasMany(ListCustomerRent::class);
    } 
   
}
