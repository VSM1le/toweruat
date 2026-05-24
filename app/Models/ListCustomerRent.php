<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListCustomerRent extends Model
{
    use HasFactory;
    protected $table = "list_customer_rents";
    protected $fillable = [
        "customer_rental_id",
        "product_service_id",
        "lcr_remark",
        "lcr_area_sqm",
        "lcr_rental_fee",
        "lcr_service_fee",
        "lcr_equipment_fee",
        "lcr_line",
        "lcr_room_number",
        "created_by",
        "updated_by"
    ];
    
    public function productservice():BelongsTo{
        return $this->belongsTo(ProductService::class,'product_service_id');
    }
}
