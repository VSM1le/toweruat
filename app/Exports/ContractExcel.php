<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ContractExcel implements WithHeadings,WithStyles 
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $contracts;

    public function __construct($contracts)
    {
        $this->contracts = $contracts;
    }
    public function headings(): array
    {
        return ['status', 
            'รหัสลูกค้า' ,
            'รายชื่อลูกค้า', 
            "เลขที่สัญญา\n(ตามเอกสาร)", 
            "เลขที่สัญญา\n(สำหรับคำนวณค่าเช่า)",
            'พื้นที่เลขที่' ,
            'วันที่เริ่มสัญญา',
            'วันที่สิ้นสุดสัญญา',
            'ระยะเวลา(ปี)',
            'พื้นที่ (ตร.ม.)',
            'ค่าเช่า/ตร.ม.',
            "ค่าบริการสาธาฯ \n/ตร.ม.(ยังไม่รวม VAT)",
            'เงินประกันค่าเช่า',
            'เงินประกันค่าบริการ(ยังไม่รวท VAT)',
            'หมายเหตุ',
            ];
    }

    public function styles(Worksheet $sheet){
        $column = 2;
        foreach($this->contracts as $contract){

            $sheet->setCellValue("A$column", $contract->custr_status == 1 ? "Active" : "No");
            $sheet->setCellValue("B$column", $contract->customer->cust_code);
            $sheet->setCellValue("C$column", $contract->customer->cust_name_th);
            $sheet->setCellValue("D$column", $contract->custr_contract_no_real);
            $sheet->setCellValue("E$column", $contract->custr_contract_no);
            $sheet->setCellValueExplicit("F$column", $contract->custr_unit,DataType::TYPE_STRING);
            $sheet->setCellValue("G$column", $contract->custr_begin_date2);
            $sheet->setCellValue("H$column", $contract->custr_end_date2);
            $sheet->setCellValue("I$column", $contract->custr_contract_year);
            $sheet->setCellValue("J$column", $contract->custr_area_sqm);
            $sheet->setCellValue("K$column", $contract->custr_rental_fee);
            $sheet->setCellValue("L$column", $contract->custr_service_fee);
            $sheet->setCellValue("M$column", $contract->insurance_rental);
            $sheet->setCellValue("N$column", $contract->insurance_service);
            $sheet->setCellValue("O$column", $contract->contract_note);

            $column++;
        }
    }
}
