<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
    protected $fillable = ['invd_product_code','invd_amt','invd_vat_amt','invd_wh_tax_amt','invd_net_amt','invd_remake','invd_wh_tax_percent',
                            'invd_vat_percent','invd_receipt_flag','invd_receip_amt','created_by','updated_by','invd_product_name','invd_period'];

    public function invoiceheader():BelongsTo{
        return $this->belongsTo(InvoiceHeader::class,'invoice_header_id');
    }
    public function receiptdetail():HasMany{
        return $this->hasMany(ReciptDetail::class,'invoice_detail_id','id');
    }
}
