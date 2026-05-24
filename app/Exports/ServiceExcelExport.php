<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServiceExcelExport implements WithStyles, WithHeadings

{
    /**
    * @return \Illuminate\Support\Collection
    */
    private  $services;
    public function __construct($services)
    {
        $this->services = $services;
    }
    public function headings(): array{
        return [
            "service name TH",
            "service name EN",
            "PS CODE",
            "PS Group",
            "vat",
            "WHTX",
            "GOVWHTX",
        ];
    }

    public function styles(Worksheet $sheet){

        $column = 2;

        foreach($this->services as $service){

            $sheet->setCellValue("A$column", $service->ps_name_th);
            $sheet->setCellValue("B$column", $service->ps_name_en);
            $sheet->setCellValue("C$column", $service->ps_code);
            $sheet->setCellValue("D$column", $service->ps_type);
            $sheet->setCellValue("E$column", $service->ps_vat);
            $sheet->setCellValue("F$column", $service->ps_whtax);
            $sheet->setCellValue("G$column", $service->gov_whtax);

            $column++;
        }
    }
}
