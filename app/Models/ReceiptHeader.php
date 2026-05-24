<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceiptHeader extends Model
{
    use HasFactory;
    protected $table = "receipt_headers";
    protected $fillable = 
    ["rec_no","rec_date","rec_cust_code","rec_inv_no","rec_ps_group","rec_status","rec_tamt","rec_tvat_amt",
    "rec_payment_type","rec_payment_amt","rec_payment_diff","rec_bank","rec_cheque_no"
    ,"rec_remark","rec_cheque_date","rec_branch","customer_id","rec_have_inv_flag"
    ,"rec_exceed_desc","rec_exceed_amount","created_by","updated_by"];


    public function receiptdetail():HasMany{
        return $this->HasMany(ReciptDetail::class,'receipt_header_id','id');
    }

    public function customer():BelongsTo{
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
