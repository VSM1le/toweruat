<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PsGroup extends Model
{
    use HasFactory;

    protected $table ='ps_groups';
    protected $fillable = ['ps_group','ps_desc','begin_date','end_date','created_by','updated_by','ps_period'];

    public function invoiceheader():HasMany{
        return $this->hasMany(InvoiceHeader::class);
    }
}
