<?php

namespace App\Exports;

use App\Models\CustomerRental;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractSheetExport implements WithCustomStartCell, WithStyles,WithHeadings,WithColumnFormatting
{
    protected $contractNo;
    protected $items;
    protected $type;
    protected $period;
    protected $vat;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($contractNo, $items,$type,$period,$vat)
    {
        $this->contractNo = $contractNo;
        $this->items = $items;
        $this->type = $type;
        $this->period = $period;
        $this->vat = $vat;
    } 

    public function startCell():string{
        return "B8";
    }
    public function headings(): array
    {
        if($this->type == "7"){
            return ['Transantion Date', 'Unit', 'Unit Air','Open','Close','Hours of use','Price/Hr','Amount'];
        }
        else{
           return ['Unit','Meter No.','Period','Previous','This Time','Unit','price/unit','Amount']; 
        }
        
    }

    public function styles(Worksheet $sheet){
        $customerName = CustomerRental::where('custr_contract_no_real',$this->items->first()->real_contract)->first();
        $logo= new Drawing();
        $logo->setName('nuam');
        $logo->setDescription('nuam'); 
        $logo->setPath(public_path('nuam.jpg'));
        $logo->setCoordinates('B1');
        $logo->setWidth(600);
        $logo->setHeight(110);
        $logo->setWorksheet($sheet);
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getRowDimension(1)->setRowHeight(42);
        $sheet->mergeCells("A1:I1");
        $sheet->setCellValue('A1',"บริษัท นวม จำกัด");
        $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A1")->getFont()->setSize(18);
        if($this->type == "5"){
            $sheet->setCellValue('A2',"รายงานการใช้น้ำประปา");
        }elseif($this->type == "3"){
            $sheet->setCellValue('A2',"รายงานการใช้ไฟฟ้า");
        }else{
            $sheet->setCellValue('A2',"รายงานการใช้ไอเย็นล่วงเวลา");
        }

        $sheet->getStyle("A2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A2")->getFont()->setSize(18);
        $sheet->getRowDimension(2)->setRowHeight(35);
        $sheet->mergeCells("A2:I2");
        $sheet->getRowDimension(4)->setRowHeight(25);
        $sheet->getColumnDimension('B')->setWidth(17);
        $sheet->setCellValue("B4","Due Date :");
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->setCellValue("B5","Building :");
        $sheet->getRowDimension(6)->setRowHeight(25);
        $sheet->setCellValue("B6","Customer Code :");
        $sheet->getRowDimension(7)->setRowHeight(25);
        // $sheet->setCellValue("B7","Meter Type :");
        $sheet->getRowDimension(8)->setRowHeight(27);
        $sheet->getColumnDimension('C')->setWidth(19);
        $sheet->setCellValue("C4",Carbon::parse($this->items->first()->due_date)
                                        ->format('d-m-Y'));
        $sheet->setCellValue("C5",'อาคารนวม');
        $sheet->setCellValue("C6",$customerName->customer->cust_name_th ." (เลขที่สัญญา ".$this->items->first()->real_contract.")");
        // $sheet->setCellValue("C7",$this->items->first()->due_date);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(17);
        $sheet->getColumnDimension('I')->setWidth(14);

        $sheet->getStyle("B8:I8")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
        for($col = 'B'; $col<= "I";$col++){
            $sheet->getStyle("{$col}8")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}8")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
         $total_amt = 0;
        $currentRow = 9;
        if($this->type != "7"){
        foreach($this->items as $bill)
        {
            $amt = $bill->p_unit * $bill->price_unit; 
            $sheet->getRowDimension($currentRow)->setRowHeight(25);
            $sheet->getStyle("B{$currentRow}:D{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->setCellValue("B{$currentRow}",$bill->unit);
            $sheet->setCellValue("C{$currentRow}",$bill->meter);
            $sheet->setCellValue("D{$currentRow}",$this->period);
            $sheet->setCellValue("E{$currentRow}",$bill->p_time);
            $sheet->setCellValue("F{$currentRow}",$bill->t_time);
            $sheet->setCellValue("G{$currentRow}",$bill->p_unit);
            $sheet->setCellValue("H{$currentRow}",$bill->price_unit);
            $sheet->setCellValue("I{$currentRow}",$amt);
            $sheet->getRowDimension($currentRow)->setRowHeight(20);
            $total_amt += $amt;
            $currentRow += 1;
        } 
        }
        else{
        $sheet->getColumnDimension('D')->setWidth(10);
            foreach($this->items as $bill){
                $minutes = $bill->p_unit;
                 $amt = round($bill->p_unit * ($bill->price_unit / 0.041666667),2);
                // $minutes_cal = round(($bill->p_unit * 24 - floor($bill->p_unit * 24)) * 60,0); // Calculate minutes
                // if ($minutes_cal <= 15) {
                //     $amt = round(floor($bill->p_unit * 24) * $bill->price_unit, 2);
                // } elseif ($minutes_cal >= 16 && $minutes_cal <= 45) {
                //     $amt = round((floor($bill->p_unit * 24) + 0.5) * $bill->price_unit, 2);
                // } else {
                //     $amt = round(ceil($bill->p_unit * 24) * $bill->price_unit, 2);
                // }
                $sheet->getStyle("B{$currentRow}:H{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->setCellValue("B{$currentRow}",Carbon::parse($bill->bill_tran_date)->format('d-m-Y'));
                $sheet->setCellValue("C{$currentRow}",$bill->unit);
                $sheet->setCellValue("D{$currentRow}",$bill->meter);
                $sheet->setCellValue("E{$currentRow}",$bill->bill_open);
                $sheet->setCellValue("F{$currentRow}",$bill->bill_close);
                $sheet->setCellValue("G{$currentRow}",$minutes);
                $sheet->getStyle("G{$currentRow}")->getNumberFormat()->setFormatCode('H:mm');
                $sheet->setCellValue("H{$currentRow}",$bill->price_unit);
                $sheet->setCellValue("I{$currentRow}",$amt);
                $sheet->getRowDimension($currentRow)->setRowHeight(20);
                $total_amt += $amt;
                $currentRow += 1;
            }
        }
        $vat_amt = ($total_amt * $this->vat) / 100;  
        $sheet->mergeCells("B".$currentRow.":H".$currentRow);
        $sheet->setCellValue("B{$currentRow}","Amount");
        $sheet->setCellValue("I{$currentRow}",$total_amt);
        $sheet->mergeCells("B".($currentRow + 1).":H".($currentRow + 1));
        $sheet->setCellValue("B".($currentRow + 1),"VAT ".$this->vat."%");
        $sheet->setCellValue("I".($currentRow + 1),$vat_amt);
        $sheet->setCellValue("B".($currentRow + 2),"Total Amount");
        $sheet->mergeCells("B".($currentRow + 2).":H".($currentRow + 2));
        $sheet->setCellValue("I".($currentRow + 2),$total_amt + $vat_amt);
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $sheet->getRowDimension($currentRow + 1)->setRowHeight(25);
        $sheet->mergeCells("B".($currentRow + 2).":H".($currentRow + 2));
        $sheet->setCellValue("I".($currentRow + 2),$total_amt + $vat_amt);
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $sheet->getRowDimension($currentRow + 1)->setRowHeight(25);
        $sheet->getRowDimension($currentRow + 2)->setRowHeight(25);
        $sheet->getStyle("B".($currentRow).":B".($currentRow + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("B".($currentRow). ":B".($currentRow + 2))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B".($currentRow).":I".($currentRow + 2))->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('I9:I'.($currentRow + 2))->getNumberFormat()->setFormatCode('#,##0.00');
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE // Applying format to column B
        ];
    } 
    public function registerEvents(): array
            {
                return[ 
                    AfterSheet::class => function(AfterSheet $event) {
                    // $event->sheet->getPageMargins()->setTop(1);
                    // $event->sheet->getPageMargins()->setBottom(1.9);
                    // $event->sheet->getPageMargins()->setLeft(0.8);
                    // $event->sheet->getPageMargins()->setRight(0.8);

                    $sheet = $event->sheet->getDelegate();
                    // Set print setup to fit to one page
                    $sheet->getPageSetup()->setFitToWidth(1);
                    $sheet->getPageSetup()->setFitToHeight(0); // 0 means it will scale based on width

                    // Optionally set the paper size, e.g., A4
                    $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);

                    // Set page margins (optional)
                    $sheet->getPageMargins()->setTop(1);
                    $sheet->getPageMargins()->setRight(0.75);
                    $sheet->getPageMargins()->setLeft(0.8);
                    $sheet->getPageMargins()->setBottom(1.9);
                 },
                    ];
            }
}
