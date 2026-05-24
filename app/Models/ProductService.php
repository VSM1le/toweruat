<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductService extends Model
{
    use HasFactory;

    protected $table = 'product_services';
    protected $fillable = [
        'ps_code', 'ps_abb', 'ps_name_th', 'ps_name_en', 'ps_unit', 
        'ps_price', 'ps_type', 'ps_group_id', 'ps_vat', 'ps_whtax', 
        'ps_tower', 'ps_price_gr','gov_whtax','created_by','updated_by'];

    public function psgroup():BelongsTo{
        return $this->belongsTo(PsGroup::class,'ps_group_id');
    }
}
