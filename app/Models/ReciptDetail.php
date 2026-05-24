<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReciptDetail extends Model
{
    use HasFactory;
    protected $table = "receip_details";
    protected $fillable = ['receipt_header_id'
    ,'recd_inv_no'
    ,'recd_product_code'
    ,'recd_period',
    'recd_amt',
    'recd_vat_amt',
    'recd_wh_tax_amt','recd_net_amt','recd_remark','recd_wh_tax_percent','recd_vat_percent','recd_discount_percent','recd_discount_amt'
    ,'recd_desc1','recd_desc2', 'created_by','updated_by' ,'invoice_detail_id','rec_pay','whpay','recd_product_name'];


    

    public function invoicedetail():BelongsTo{
        return $this->belongsTo(InvoiceDetail::class,'invoice_detail_id','id');
    }
    public function receiptheader():BelongsTo{
        return $this->belongsTo(ReceiptHeader::class,'receipt_header_id','id');
    }
}
