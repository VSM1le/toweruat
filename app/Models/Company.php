<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table= 'companys';
     protected $fillable = [
        'company_code',
        'com_abb',
        'com_building',
        'com_building2',
        'com_name_th',
        'com_name_en',
        'com_taxid',
        'com_address1',
        'com_address2',
        'com_tel',
        'com_fax',
        'com_vat_rate1',
        'com_startdate1',
        'com_vat_rate2',
        'com_startdate2',
        'com_maxpark',
        'com_m_maxpark',
        'com_starttime',
        'com_endtime',
        'created_by',
        'updated_by'
    ];
}
