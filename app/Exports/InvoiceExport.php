<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceExport implements WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $invoice;
    protected $endDate;
    public function __construct($invoice,$endDate){
        $this->invoice = $invoice;
        $this->endDate = $endDate;
    }
    public function headings(): array
    {
        return ['Invoice No.','invoice Date','Customer name' ,'Contract Number','Service Code','Product','Amt','Vat Amt','Whtax Amt','Net Amt','Due Date','Status','Paid Amount','Over Due','Remark','Invoice Status'];
    }
    public function styles(Worksheet $sheet){
        $column = 2;
        foreach($this->invoice as $invoiceDetails){
            foreach($invoiceDetails->invoicedetail as $detail){
                $overdue = null;
                $lastReceipt = $detail->receiptdetail->sortByDesc('id')->first();
                if($detail->invd_receipt_flag == 'No'){
                $invoiceDate = $detail->invoiceheader->invd_duedate ? Carbon::parse($detail->invoiceheader->invd_duedate) : null;
                $receiptDate = $lastReceipt && $lastReceipt->receiptheader ? Carbon::parse($lastReceipt->receiptheader->rec_date) : null;
                $checkDate = $invoiceDate->diffInDays($this->endDate);
                    if($checkDate > 0){
                        $overdue = (int)$checkDate; 
                    }
                    else{
                        $overdue = null;
                    }
                }
                else{
                    $overdue = null;
                }
                if($invoiceDetails->inv_status === "CANCEL"){
                    $sheet->getStyle('A'.($column).':Q'.($column))->getFont()->getColor()->setRGB('FF0000');
                }
               $sheet->setCellValue("A$column",$invoiceDetails->inv_no); 
               $sheet->setCellValue("B$column",Carbon::parse($invoiceDetails->inv_date)->format('d-m-Y')); 
               $sheet->setCellValue("C$column",$invoiceDetails->customer->cust_name_th); 
               $sheet->setCellValue("D$column",$invoiceDetails->customerrental->custr_contract_no ?? null); 
               $sheet->setCellValue("E$column",$detail->invd_product_code ?? null); 
               $sheet->setCellValue("F$column",$detail->invd_product_name ?? null); 
               $sheet->setCellValue("G$column",$detail->invd_amt ?? 0); 
               $sheet->setCellValue("H$column",$detail->invd_vat_amt ?? 0); 
               $sheet->setCellValue("I$column",$detail->invd_wh_tax_amt ?? 0); 
               $sheet->setCellValue("J$column",$detail->invd_net_amt ?? 0); 
               $sheet->setCellValue("K$column",Carbon::parse($invoiceDetails->invd_duedate)->format('d-m-Y')); 
               $sheet->setCellValue("L$column",$detail->invd_receipt_flag); 
               $sheet->setCellValue("M$column",$detail->invd_receipt_amt ?? 0); 
               $sheet->setCellValue("N$column",$overdue); 
               $sheet->setCellValue("O$column",$detail->invd_remark ?? null); 
               $sheet->setCellValue("P$column",$invoiceDetails->inv_status);
               $column += 1;
            } 
            $sheet->getStyle('G2:J'.($column))->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('M'.($column))->getNumberFormat()->setFormatCode('#,##0.00');
        }
    }
}
