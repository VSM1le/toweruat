<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table = "bill";
    protected $fillable = ["contract_no","unit","meter","p_time","t_time","p_unit"
        ,"price_unit","status","created_by","updated_by","invoice_date","type","due_date","bill_tran_date","bill_open","bill_close","bill_use"];
}
