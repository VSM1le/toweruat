<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GroupedByContractExport implements WithMultipleSheets 
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    protected $type;
    protected $period;
    protected $vat;
    public function __construct($data,$type,$period,$vat){
       $this->data = $data; 
       $this->type = $type;
       $this->period = $period;
       $this->vat = $vat;
    }


    public function sheets(): array{
        $sheets = [];
        // dd($this->data->where('real_contract','N-2404002'));
        $uniqueContract = $this->data->unique('real_contract')->pluck('real_contract');

        foreach ($uniqueContract as $item) {

            $filteredItems = $this->data->where('real_contract', $item)->sortBy('bill_tran_date');

            $sheets[] = new ContractSheetExport($item, $filteredItems,$this->type,$this->period,$this->vat); 
        }   

        return $sheets;
    }
}
