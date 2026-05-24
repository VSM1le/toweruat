<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements WithStyles, WithHeadings
{
    /** * @return \Illuminate\Support\Collection */ private $customerInfos = null;
    public function __construct($customerInfos)
    {
        $this->customerInfos = $customerInfos;
    }
    public function headings(): array
    {
        return ['Code', 'Th Name' ,'ENG Name', 'Tax ID', 'Address 1' , 'Address 2' , 'Status'];
    }

    public function styles(WorkSheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(8);
        $column = 2;
        foreach ($this->customerInfos as $customerInfo) {
            $sheet->setCellValue("A$column", $customerInfo->cust_code);
            $sheet->setCellValue("B$column", $customerInfo->cust_name_th);
            $sheet->setCellValue("C$column", $customerInfo->cust_name_en);
            $sheet->setCellValueExplicit(
                "D$column",
                $customerInfo->cust_taxid,
                DataType::TYPE_STRING
            );
            $sheet->setCellValue("E$column", $customerInfo->cust_address_th1);
            $sheet->setCellValue("F$column", $customerInfo->cust_address_th2);
            $sheet->setCellValue("G$column", $customerInfo->cust_status == true ? "active" : "inactive");
            $column++;
        }
    }
}
