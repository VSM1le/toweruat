<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PsGroupExcelExport implements WithStyles,WithHeadings 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $psGroups;

    public function __construct($psGroups)
    {
        $this->psGroups = $psGroups;
    }

    public function headings(): array{
        return [
            "Group name",
            "Description", 
            "Begin Date", 
            "End Date", 
            "Period",
        ];
    }
    public function styles(WorkSheet $sheet){
        $column = 2;
        foreach($this->psGroups as $ps){

            $sheet->setCellValue("A$column", $ps->ps_group);
            $sheet->setCellValue("B$column", $ps->ps_desc);
            $sheet->setCellValue("C$column", $ps->begin_date);
            $sheet->setCellValue("D$column", $ps->end_date);
            $sheet->setCellValue("E$column", $ps->ps_period);

            $column++;
        }
    } 
}
