<?php

namespace App\Livewire;

use App\Exports\GroupedByContractExport;
use App\Imports\BillImport;
use App\Models\Bill;
use App\Models\CustomerRental;
use App\Models\InvoiceHeader;
use App\Models\ProductService;
use App\Models\PsGroup;
use App\Services\periodPs;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class BillWE extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $type = 3 ;
    public $typeQuery = 5;
    public $bills;
    public $monthYear;
    public $reportType = 1;
    public $showImportModal = false;

    public $showGenerateInvoice = false;
    public $showDeleteBill = false;
    public $showExportBill = false;
    
    public function __construct(){
        $this->monthYear = Carbon::now('Asia/Bangkok')->format('Y-m');
    }
    public function bill()
    {
        sleep(10);
        // Validate the uploaded file
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt,xls,xlsx',
            'type' => 'required',
        ]);
        // Check if the file is set
        if (!$this->csvFile) {
            session()->flash('error', 'No file uploaded');
            return;
        }

        try {
        // Import the file
        Excel::import(new BillImport($this->type), $this->csvFile);
        
        // Provide feedback to the user
        session()->flash('success', 'File imported successfully!');
        } catch (\Exception $e) {
        // Handle exceptions and provide feedback
        session()->flash('error', 'Failed to import file: ' . $e->getMessage());
        }finally{
        $this->closeImport();
        }
         
        
    }
    public function openImport(){
        $this->showImportModal = true;
    }
    public function closeImport(){
        $this->showImportModal = false;
        $this->resetValidation();
        $this->reset(['csvFile']);
    }

    public function openGenInvoice()
    {
        $this->showGenerateInvoice = true;
    }

    public function closeGenInvoice(){
        $this->showGenerateInvoice = false;
    } 

    public function genInvoice(){
        $monthYear = $this->monthYear ?? Carbon::now('Asia/Bangkok')->format('Y-m');
        $totalSalesQuery = null;
        if($this->typeQuery == "7"){
            // $totalSalesQuery = DB::raw("
            //     SUM(
            //         CASE 
            //             -- Convert p_unit to hours (p_unit * 24) and extract fractional minutes
            //             WHEN ((p_unit * 24 - FLOOR(p_unit * 24)) * 60) <= 15 THEN 
            //                 FLOOR(p_unit * 24) * (price_unit)
                            
            //             WHEN ((p_unit * 24 - FLOOR(p_unit * 24)) * 60) BETWEEN 16 AND 45 THEN
            //                 (FLOOR(p_unit * 24) + 0.5) * (price_unit)
                            
            //             ELSE 
            //                 CEIL(p_unit * 24) * (price_unit)
            //         END
            //     ) as total_sales
            // "); 
            $totalSalesQuery = DB::raw('SUM(p_unit * (price_unit /  0.041666667)) as total_sales');
            
        } else {
            $totalSalesQuery = DB::raw('SUM(p_unit * price_unit) as total_sales');
        }
        $sumBill = Bill::when($monthYear, function ($query) use($monthYear) {
                $query->where('invoice_date', 'like', '%' . $monthYear . '%');
            })
            ->when($this->typeQuery, function ($query) {
                $query->where('type', $this->typeQuery);
            })
            ->where('status', 'Y')
            ->select(
                'contract_no',
                'invoice_date',
                'due_date',
                $totalSalesQuery
            )
            ->groupBy(
                'contract_no',
                'invoice_date',
                'due_date',
            )
            ->get(); 
        $prefix = 'IAS';
        $year = Carbon::parse($this->monthYear)->format('Y');
        $datePart = substr($year, -2) . Carbon::parse($this->monthYear)->format('m');

        $lastInvoice = InvoiceHeader::where('inv_no', 'like', $prefix . $datePart . '%')
            ->orderBy('inv_no', 'desc')->first();
        $generatedInvoices = [];

        if (is_null($lastInvoice)) {
            foreach($sumBill as $index => $bill){
                 $generatedInvoices[] = $prefix . $datePart . str_pad(1 + $index, 4, '0', STR_PAD_LEFT);
                }
            
        } else {
            foreach($sumBill as $index => $bill){
            $lastNumber = (int)substr($lastInvoice->inv_no, -4);
            $newNumber = str_pad($lastNumber + 1 + $index, 4, '0', STR_PAD_LEFT);
            $generatedInvoices[]= $prefix . $datePart . $newNumber;
            }
        }

        if($this->typeQuery == "5"){
            $product = ProductService::where('ps_code','2002')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
            $p_wh = $product->ps_whtax ?? 0;

        }
        elseif($this->typeQuery == "3"){
            $product = ProductService::where('ps_code','2001')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
            $p_wh = $product->ps_whtax ?? 0;
        }
        else{
            $product = ProductService::where('ps_code','3001')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
            $p_wh = $product->ps_whtax ?? 0;
        }
        try{
        foreach($sumBill as $index => $bill){
            $contractInfo = CustomerRental::where('custr_contract_no',$bill->contract_no)->first(); 
            $amt = round($bill->total_sales,2);
            $whtax = $p_wh;
            if($contractInfo->customer->cust_gov_flag === 1)
            {
                $whtax = 1;
            }
            if($contractInfo->customer->cust_gov_flag === 3)
            {
                $whtax = 0;
            }
            $vatamt = round(($amt * $product->ps_vat ?? 0)/100,2);
            $whamt = round(($amt * $whtax)/100,2);
            $netamt = $amt + $vatamt;
            $createInvoice = InvoiceHeader::create([
            'inv_no' => $generatedInvoices[$index],
            'customer_id' => $contractInfo->customer_id,
            'customer_rental_id' => $contractInfo->id,
            'inv_date' => $bill->invoice_date,
            'invd_duedate' => $bill->due_date,
            'ps_group_id' => $this->typeQuery, 
            'inv_status' => 'USE',
            'inv_unite' => $contractInfo->custr_unit ?? null, 
            'inv_tower' => 'A',
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
          $createInvoice->invoicedetail()->create([
                'invd_product_code' => $product->ps_code,
                'invd_product_name' => $product->ps_name_th,
                'invd_period' => $period,
                'invd_amt' => $amt,
                'invd_vat_percent' => $product->ps_vat ?? 0,
                'invd_vat_amt' => $vatamt,
                'invd_wh_tax_percent' => $whtax,
                'invd_wh_tax_amt' => $whamt,
                'invd_net_amt' => $netamt,
                'invd_receipt_flag' => "No",
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }
            session()->flash('success', ' Generate invoice successful.'); 
        }catch(\Exception $e){
            session()->flash('error', ' Something when wrong can not generate invoice.'); 
        }finally{
            $this->closeGenInvoice();
        }
    }

    public function exportGroupByContract()
    {
       $monthYear = $this->monthYear ?? Carbon::now('Asia/Bangkok')->format('Y-m');
       $data = Bill::join('customer_rentals', 'bill.contract_no', '=', 'customer_rentals.custr_contract_no')
            ->select(
                'bill.id',
                'bill.contract_no',
                'bill.unit', 
                'bill.meter',
                'bill.p_time',
                'bill.t_time',
                'bill.p_unit',
                'bill.price_unit',
                'bill.invoice_date', 
                'bill.due_date',
                'bill.bill_tran_date',
                'bill.bill_open',
                'bill.bill_close',
                'bill.bill_use',
                'customer_rentals.custr_contract_no_real as real_contract'  
            )
            ->when($monthYear, function ($query) use($monthYear) {
                $query->where('invoice_date', 'like', '%' . $monthYear . '%');
            })
            ->when($this->typeQuery, function ($query){
                $query->where('type',$this->typeQuery);
            })
            ->where('status','Y')
            ->get(); 
        if($this->typeQuery == "5"){
            $vat= ProductService::where('ps_code','2002')->pluck('ps_vat')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
        }
        elseif($this->typeQuery == "3"){
            $vat= ProductService::where('ps_code','2001')->pluck('ps_vat')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
        }
        else{
            $vat= ProductService::where('ps_code','3001')->pluck('ps_vat')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $period = "null";
            if($ps_group){
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
            }
        }
            return Excel::download(new GroupedByContractExport($data,$this->typeQuery,$period,$vat), 'bills_grouped_by_contract.xlsx');
    }

    public function openClear(){
        $this->showDeleteBill = true;
    }
    public function clearBill(){

        $monthYear = $this->monthYear ?? Carbon::now('Asia/Bangkok')->format('Y-m');
        try{
            Bill::when($monthYear, function($query) use($monthYear){
                $query->where('invoice_date','like','%'.$monthYear.'%');
                })
            ->when($this->typeQuery, function($query){
                $query->where('type',$this->typeQuery);
            })->delete();
            session()->flash('success', ' Clear Bill successful'); 
        }catch(\Exception $e){
            session()->flash('error', ' Error can not clear Bill'); 
        }finally{
            $this->closeClear();
        }
    }
    public function closeClear(){
        $this->showDeleteBill = false;
    }
    public function openShouldExport(){
        $this->showExportBill = true;
    }
    public function closeShouldExport(){
        $this->showExportBill = false;
    }
    public function shouldExportType(){
        if($this->reportType == "1"){
            return $this->reportPdfBill();
        }
        else{
            return $this->exportGroupByContract();
        }
    }
    
    protected function reportPdfBill(){
       $monthYear = $this->monthYear ?? Carbon::now('Asia/Bangkok')->format('Y-m');
       $data = Bill::join('customer_rentals', 'bill.contract_no', '=', 'customer_rentals.custr_contract_no')
            ->select(
                'bill.id',
                'bill.contract_no',
                'bill.unit', 
                'bill.meter',
                'bill.p_time',
                'bill.t_time',
                'bill.p_unit',
                'bill.price_unit',
                'bill.invoice_date', 
                'bill.due_date',
                'bill.bill_tran_date',
                'bill.bill_open',
                'bill.bill_close',
                'bill.bill_use',
                'customer_rentals.custr_contract_no_real as real_contract'  
            )
            ->when($monthYear, function ($query) use($monthYear) {
                $query->where('invoice_date', 'like', '%' . $monthYear . '%');
            })
            ->when($this->typeQuery, function ($query){
                $query->where('type',$this->typeQuery);
            })
            ->where('status','Y')
            ->get(); 
        if($this->typeQuery == "5"){
            $vat= ProductService::where('ps_code','2002')->pluck('ps_vat')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
        }
        elseif($this->typeQuery == "3"){
            $vat= ProductService::where('ps_code','2001')->pluck('ps_vat')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
        }
        else{
            $vat= ProductService::where('ps_code','3001')->pluck('ps_vat')->first();
            $ps_group = PsGroup::where('id',$this->typeQuery)->first();
            $period = "null";
            if($ps_group){
            $periodPs = new periodPs;
            $period = $periodPs->invoicePeriod($this->monthYear, $ps_group); 
            }
        }
        $combinedHtml = null;
        $uniqueContract = $data->unique('real_contract')->pluck('real_contract');
        foreach ($uniqueContract as $item) {
            $filteredItems = $data->where('real_contract', $item)->sortBy('bill_tran_date');
            
            
             if($this->typeQuery == "7"){
                $filteredItems = $filteredItems->map(function ($item){
                    $hours = floor($item->p_unit * 24);
                    $minutes = round(($item->p_unit * 24 - $hours) * 60);
                    if ($minutes == '60') {
                        $hours += 1;
                        $minutes = 0;
                    }
                    $item->amt = round($item->p_unit * ($item->price_unit / 0.041666667),2);
                    // $minutes_cal = round(($item->p_unit * 24 - floor($item->p_unit * 24)) * 60,0); // Calculate minutes
                    // if ($minutes_cal <= 15) {
                    //     $item->amt = round(floor($item->p_unit * 24) * $item->price_unit, 2);
                    // } elseif ($minutes_cal >= 16 && $minutes_cal <= 45) {
                    //     $item->amt = round((floor($item->p_unit * 24) + 0.5) * $item->price_unit, 2);
                    // } else {
                    //     $item->amt = round(ceil($item->p_unit * 24) * $item->price_unit, 2);
                    // }
                    $item->hourM =  $item->hourM = $hours . ":" . sprintf('%02d', $minutes); 
                    return $item;
                 });
                $total_amt = $filteredItems->sum('amt');
                $vat_amt = round(($filteredItems->sum('amt') * $vat) / 100,2);
            }else{
                $filteredItems = $filteredItems->map(function($item){
                    $item->amt = round($item->p_unit * $item->price_unit,2);
                    return $item;
                });
                $total_amt = $filteredItems->sum('amt');
                $vat_amt = round(($filteredItems->sum('amt') * $vat) / 100,2);
            }
            $chunkContracts = $filteredItems->chunk(25);
             $customerName = CustomerRental::where('custr_contract_no_real',$filteredItems->first()->real_contract)->first();
            $sumPage = count($chunkContracts);
           
            foreach($chunkContracts as $index => $bills){
                $Html = view('invoicepdf.air',[
                        'bills' => $bills,
                        'period' => $period,
                        'customerName' => $customerName,
                        'vat' => $vat,
                        'vat_amt' => $vat_amt,
                        'total_amt' => $total_amt,
                        'currentPage' => $index + 1,
                        'sumPage' => $sumPage,
                        'typeQuery' => $this->typeQuery,
                    ]
                )->render();
                $combinedHtml .= $Html;
            }

        }
        $pdf = PDF::loadHTML($combinedHtml);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        },  'pdfbill.pdf'); 
    }

    public function render()
    {   
       $monthYear = $this->monthYear ?? Carbon::now('Asia/Bangkok')->format('Y-m');
       $this->bills = Bill::when($monthYear, function ($query) use($monthYear)  {
       $query->where('invoice_date', 'like', '%' . $monthYear. '%');
       })
       ->when($this->typeQuery, function ($query){
        $query->where('type',$this->typeQuery);
       })
       ->where('status','Y')
       ->get();
 
        return view('livewire.bill-w-e',['bills'=> $this->bills]);
    }
}
