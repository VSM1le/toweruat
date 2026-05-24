<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditnoteDetail extends Model
{
    use HasFactory;
    protected $table = 'creditnote_details';
    protected $fillable = ['creaditnote_header_id',
    'crd_service_code',
    'crd_service_name',
    'crd_amt',
    'crd_tax_amt',
    'crd_wh_amt',
    'crd_net_amt',
    'crd_remark',
    'created_by',
    'updated_by',
    ];
}
