<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditnoteHeader extends Model
{
    use HasFactory;
    protected $table = 'creditnote_headers';
    protected $fillable = ['credit_date',
    'customer_id',
    'customer_rental_id',
    'credit_room_num',
    'credit_receipt_num',
    'credit_receipt_date',
    'receipt_header_id',
    'credit_status',
    'created_by',
    'updated_by',
    'credit_no',
    'credit_remark'];

    public function creditdetail():HasMany{
        return $this->hasMany(CreditnoteDetail::class);
    }

    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class);  
    }
    public function customerrental(): BelongsTo{
        return $this->belongsTo(CustomerRental::class,'customer_rental_id');
    } 

}
