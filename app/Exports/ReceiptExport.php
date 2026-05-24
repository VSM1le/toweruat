<?php

namespace App\Exports;

// class ReceiptExport  implements 
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReceiptExport implements WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $receipts;
    protected $endDate;
    public function __construct($receipt){
        $this->receipts = $receipt;
    }
    public function headings(): array
    {
        return ['Receipt Date','Receipt No.','Customer name' ,'Contract Number','Service Code','Product','Remark','Amt','Vat Amt','Whtax Amt','Paid Amount','Receipt Status'];
    }

    public function styles(Worksheet $sheet){
        $column = 2;

        foreach($this->receipts as $receiptDetail){

            if ($receiptDetail->receiptheader->rec_have_inv_flag != "0"){

                $sheet->setCellValue("A$column",Carbon::parse($receiptDetail->receiptheader->rec_date,'Asia/Bangkok')->format('d-m-Y') ); 
                $sheet->setCellValue("B$column",$receiptDetail->receiptheader->rec_no);
                $sheet->setCellValue("C$column",$receiptDetail->receiptheader->customer->cust_name_th ?? null);
                $sheet->setCellValue("D$column",$receiptDetail->invoicedetail->invoiceheader->customerrental->custr_contract_no ?? null);
                $sheet->setCellValue("E$column",$receiptDetail->invoicedetail->invd_product_code);
                $sheet->setCellValue("F$column",$receiptDetail->invoicedetail->invd_product_name);
                $sheet->setCellValue("G$column",$receiptDetail->invoicedetail->invd_remake);
                $sheet->setCellValue("H$column",round($receiptDetail->rec_pay * (100 / (100 + $receiptDetail->invoicedetail->invd_vat_percent)),2) ?? 0);
                $sheet->setCellValue("I$column",$receiptDetail->rec_pay - round($receiptDetail->rec_pay * (100 / (100 + $receiptDetail->invoicedetail->invd_vat_percent)),2) ?? 0);
                $sheet->setCellValue("J$column",$receiptDetail->whpay ?? 0);
                $sheet->setCellValue("K$column",$receiptDetail->rec_pay ?? 0,);
                $sheet->setCellValue("L$column",$receiptDetail->receiptheader->rec_status ?? null );

                $column++;
            }else{

                $sheet->setCellValue("A$column",Carbon::parse($receiptDetail->receiptheader->rec_date,'Asia/Bangkok')->format('d-m-Y') ); 
                $sheet->setCellValue("B$column",$receiptDetail->receiptheader->rec_no);
                $sheet->setCellValue("C$column",$receiptDetail->receiptheader->customer->cust_name_th ?? null);
                $sheet->setCellValue("D$column",$receiptDetail->invoicedetail->invoiceheader->customerrental->custr_contract_no ?? null);
                $sheet->setCellValue("E$column",$receiptDetail->recd_product_code);
                $sheet->setCellValue("F$column",$receiptDetail->recd_product_name);
                $sheet->setCellValue("G$column",$receiptDetail->recd_remark);
                $sheet->setCellValue("H$column",$receiptDetail->recd_amt);
                $sheet->setCellValue("I$column",$receiptDetail->recd_vat_amt);
                $sheet->setCellValue("J$column",$receiptDetail->whpay ?? 0);
                $sheet->setCellValue("K$column",$receiptDetail->rec_pay ?? 0,);
                $sheet->setCellValue("L$column",$receiptDetail->receiptheader->rec_status ?? null );

                $column++;
            };

            $sheet->getStyle('H2:K'.($column))->getNumberFormat()->setFormatCode('#,##0.00');

        }
    }
}
