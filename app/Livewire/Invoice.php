<?php

namespace App\Livewire;

use App\Exports\InvoiceExport;
use App\Models\Customer;
use App\Models\CustomerRental;
use App\Models\InvoiceDetail;
use App\Models\InvoiceHeader;
use App\Models\ProductService;
use App\Models\PsGroup;
use App\Services\numberToBath;
use App\Services\periodPs;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Options;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Constraint\IsEmpty;

class Invoice extends Component
{
    use WithPagination;
    public $status = null;
    public $psGroup = null;
    public $customerName = null;
    public $customerCode = null;
    public $customerrents = null;
    public $rental = null;
    public $service = null;
    public $invoiceDate = null;
    public $invoiceDetails; 
    public $dueDate = null;
    public $tower = "A";
    public $showCreateInvoice = false;



    public $showEditInvoice = false;

    public $editInvoices = null;
    public $editInvoiceNumber = null;
    public $editInvoiceDetails = [];
    public $editPsGroup = null;
    public $editInvoiceDate = null;
    public $editDueDate = null;
    public $editCustomerCode = null;
    public $editRental = null;
    public $deleteItem;
    public $editcustomerrents = [];

    public $showDeleteInvoice = false;
    public $cancelInvoice;
    public $invRemark = null;
    public $startDate;
    public $endDate;
    public $customer;

    public $showGenrateInvoice= false;
    public $genInvDate;
    public $genDueDate;

    public $showExportInvoice = false;
    public $exFromDate;
    public $exToDate;

    public $reportType = '1';
   
    private function sanitizeNumericValue($value)
    {
        $sanitizedValue = preg_replace('/[^-?\d.]/', '', $value);

        return (float) $sanitizedValue;
    }

    public function mount(){
        $this->startDate = Carbon::now('Asia/Bangkok')->startOfMonth()->format('Y-m-d');
    }

    public function updatedCustomerCode(){
        $this->rental = null;
        $this->invoiceDetails = [];
          if (!is_null($this->customerCode)) {
            $this->customerrents = CustomerRental::where('customer_id',$this->customerCode)->where('custr_status',1)->get();
        } else {
            $this->customerrents = null;    
        }
        
    }

    public function updateInvoiceDetail($index, $field, $value)
    {
        if($this->invoiceDetails[$index][$field] == null){
            $this->invoiceDetails[$index][$field] = 0;
        }
        if (isset($this->invoiceDetails[$index]) && $this->invoiceDetails[$index]['amt'] != null) {
            $this->invoiceDetails[$index][$field] = $value;

            // Recalculate vatamt if amt or vat field is updated
            if ($field == 'amt' || $field == 'vat' || $field == 'whvat') {
                $amt = $this->invoiceDetails[$index]['amt'] ?? 0;
                $vat = $this->sanitizeNumericValue($this->invoiceDetails[$index]['vat'] ?? 0); // Sanitize vat value
                $whvat = $this->sanitizeNumericValue($this->invoiceDetails[$index]['whvat'] ?? 0);// Sanitize whvat value

                $vatamt = round(($amt * $vat) / 100 ?? 0,2);
                $whtaxamt = round(($amt * $whvat) / 100 ?? 0,2);
                $netamt = $vatamt + $amt;
                
                $this->invoiceDetails[$index]['vatamt'] = $vatamt;
                $this->invoiceDetails[$index]['whtaxamt'] = $whtaxamt;
                $this->invoiceDetails[$index]['netamt'] = $netamt; 
            }
        }
    }


    #[Computed()]
    public function activeCustomers(){
        return Customer::where('cust_status',1)->orderBy('cust_code')->get();
    }
    #[Computed()]
    public function customers(){
        return Customer::orderBy('cust_code')->get();
    }

    #[Computed()]
    public function psgroups(){
        return PsGroup::all();
    }

    #[Computed()]
    public function productservices(){
        return ProductService::all();
    }

    public function addline(){
       $this->validate([
            'invoiceDate' => ['required'],
            'customerCode'  => ['required'],
            'service' => ['required'],
            'psGroup' => ['required'],
            'dueDate' => ['required'],
       ]); 
        $check = True;
        $customer_rent= CustomerRental::where('customer_id',$this->customerCode)->where('id',$this->rental)->with('customer')->first();
        $product_service = ProductService::where('id',$this->service)->first();
        $ps_group = PsGroup::where('id',$this->psGroup)->first();
        $wh_tax = $product_service->ps_whtax;
        $periodPs = new periodPs;
        $period = $periodPs->invoicePeriod($this->invoiceDate, $ps_group); 
        
       if(Customer::where('id',$this->customerCode)->pluck('cust_gov_flag')->first() == 1){
            $wh_tax = $product_service->gov_whtax;
       } 
       if(Customer::where('id',$this->customerCode)->pluck('cust_gov_flag')->first() == 3){
            $wh_tax = 0;
       }
        if(($product_service->ps_code == "1001" || $product_service->ps_code == "1010") && !is_null($customer_rent)){
            $amt = round($customer_rent->custr_rental_fee * $customer_rent->custr_area_sqm,2);
            $vatamt = round(($amt * $product_service->ps_vat)/100,2);
            $whamt = round(($amt * $wh_tax)/100,2);
            $netamt = $amt + $vatamt ;
            $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period ?? 0
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>$wh_tax
            ,'whtaxamt' => $whamt 
            ,'netamt'=>$netamt 
            ,'remark'=>''];
            $check = false;
        }
        if($product_service->ps_code == '1020' && !is_null($customer_rent)){
            $amt = round($customer_rent->custr_area_sqm * $customer_rent->custr_service_fee,2);
            $vatamt = round(($amt * $product_service->ps_vat)/100,2);
            $whamt = round(($amt * $wh_tax)/100,2);
            $netamt = $amt + $vatamt; 
            $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>$wh_tax
            ,'whtaxamt' => $whamt 
            ,'netamt'=> $netamt 
            ,'remark'=>''];
            $check = false;
        }
        if($check){
             $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=> 0
            ,'vat'=> $product_service->ps_vat 
            ,'vatamt'=> 0
            ,'whvat'=>$wh_tax 
            ,'whtaxamt' => 0
            ,'netamt'=> 0
            ,'remark'=>''];
        }
    }
    public function removeItem($index){
       unset($this->invoiceDetails[$index]);
       $this->invoiceDetails = array_values($this->invoiceDetails);
    }
    public function createInvoice()
    {
        DB::beginTransaction(); // Start the transaction

        
            // Validate inputs
            $this->validate([
                'psGroup' => ['required'],
                'invoiceDate' => ['required'],
                'customerCode' => ['required'],
                'service' => ['required'],
                'dueDate' => ['required'],
                'invoiceDetails.*.remark' => ['max:80']
            ],
            [
                'invoiceDetails.*.remark.max' => 'Remark must not be greater than 80 characters.'
            ]);
        try {
            $prefix = 'I' . $this->tower . 'S';
            $year = Carbon::parse($this->invoiceDate)->format('Y');
            $datePart = substr($year, -2) . Carbon::parse($this->invoiceDate)->format('m');
            $unite = CustomerRental::where('id', $this->rental)->first();
            $lastInvoice = InvoiceHeader::where('inv_no', 'like', $prefix . $datePart . '%')->orderBy('inv_no', 'desc')->first();

            // Generate invoice number
            if (is_null($lastInvoice)) {
                $invNo = $prefix . $datePart . '0001';
            } else {
                $lastNumber = (int) substr($lastInvoice->inv_no, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                $invNo = $prefix . $datePart . $newNumber;
            }

            // Create InvoiceHeader
            $createInvoice = InvoiceHeader::create([
                'inv_no' => $invNo,
                'customer_id' => $this->customerCode,
                'customer_rental_id' => $this->rental,
                'inv_date' => $this->invoiceDate,
                'invd_duedate' => $this->dueDate,
                'ps_group_id' => $this->psGroup,
                'inv_status' => 'USE',
                'inv_unite' => $unite->custr_unit ?? null,
                'inv_tower' => $this->tower,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Create InvoiceDetails
            foreach ($this->invoiceDetails as $detail) {
                $createInvoice->invoicedetail()->create([
                    'invd_product_code' => $detail['pscode'],
                    'invd_product_name' => $detail['psname'],
                    'invd_period' => $detail['period'],
                    'invd_amt' => $detail['amt'],
                    'invd_vat_percent' => $detail['vat'],
                    'invd_vat_amt' => $detail['vatamt'],
                    'invd_wh_tax_percent' => $detail['whvat'],
                    'invd_wh_tax_amt' => $detail['whtaxamt'],
                    'invd_net_amt' => $detail['netamt'],
                    'invd_remake' => $detail['remark'],
                    'invd_receipt_flag' => "No",
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            }

            DB::commit(); // Commit the transaction if everything goes well
            $this->closeCreateInvoice();

            // Redirect to dashboard or another route
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction if an error occurs
            $this->closeCreateInvoice();
            // Log the error for debugging (optional)
            session()->flash('error','Invoice creation failed: ' . $e->getMessage());
        }
    }
    public function openCreateInvoice(){
        $this->showCreateInvoice = true;
    }
    public function closeCreateInvoice(){
        $this->showCreateInvoice = false;
        $this->invoiceDetails = []; 
        $this->reset(['psGroup','customerName','customerCode','customerrents','rental','service','invoiceDate','dueDate']);
        $this->resetValidation();
       
    }
    public function updatedEditCustomerCode()
    {
        $this->editRental = null; // Clear dependent data
    
        if (!is_null($this->editCustomerCode)) {
            $this->editcustomerrents = CustomerRental::where('customer_id', $this->editCustomerCode)->get();
        } else {
            $this->editcustomerrents = []; // Ensure the variable is an empty array or null as needed
        }
    }
     public function updateEditInvoiceDetail($index, $field, $value)
    {
        if($this->editInvoiceDetails[$index][$field] == null){
            $this->editInvoiceDetails[$index][$field] = 0;
        }
        if (isset($this->editInvoiceDetails[$index]) && $this->editInvoiceDetails[$index]['amt'] != null) {
            $this->editInvoiceDetails[$index][$field] = $value;

            // Recalculate vatamt if amt or vat field is updated
            if ($field == 'amt' || $field == 'vat' || $field == 'whvat') {
                $amt = $this->editInvoiceDetails[$index]['amt'] ?? 0;
                $vat = $this->sanitizeNumericValue($this->editInvoiceDetails[$index]['vat'] ?? 0); // Sanitize vat value
                $whvat = $this->sanitizeNumericValue($this->editInvoiceDetails[$index]['whvat'] ?? 0); // Sanitize whvat value

                $vatamt = round(($amt * $vat) / 100 ?? 0,2);
                $whtaxamt = round(($amt * $whvat) / 100 ?? 0,2);
                $netamt = $vatamt + $amt;

                $this->editInvoiceDetails[$index]['vatamt'] = $vatamt;
                $this->editInvoiceDetails[$index]['whtaxamt'] = $whtaxamt;
                $this->editInvoiceDetails[$index]['netamt'] = $netamt;
            }
        }
    }

    public function openEditInvoice($id)
    {
        $this->editInvoices = InvoiceHeader::with('invoicedetail')->where('id', $id)->first();
        if ($this->editInvoices) {
            $this->editPsGroup = $this->editInvoices->ps_group_id;
            $this->editInvoiceNumber = $this->editInvoices->inv_no;
            $this->editInvoiceDate = $this->editInvoices->inv_date;
            $this->editCustomerCode = $this->editInvoices->customer_id;
            $this->editcustomerrents = CustomerRental::where('customer_id', $this->editCustomerCode)->get();
            $this->editRental = $this->editInvoices->customer_rental_id;
            $this->editDueDate = $this->editInvoices->invd_duedate;
            foreach ($this->editInvoices->invoicedetail as $invoice) {
                $this->editInvoiceDetails[] = [
                    'id' => $invoice->id,
                    'pscode' => $invoice->invd_product_code,
                    'psname' => $invoice->invd_product_name,
                    'period' => $invoice->invd_period,
                    'amt' => $invoice->invd_amt,
                    'vat' => $invoice->invd_vat_percent,
                    'vatamt' => $invoice->invd_vat_amt,
                    'whvat' => $invoice->invd_wh_tax_percent,
                    'whtaxamt' => $invoice->invd_wh_tax_amt,
                    'netamt' => $invoice->invd_net_amt,
                    'remark' => $invoice->invd_remake,
                ];
            }
            $this->showEditInvoice = true;
        }
    }

     public function editRemove($index)
    {
        $deleteId = $this->editInvoiceDetails[$index]['id']; 
        if(!empty($deleteId)){
        $this->deleteItem[] = ['id'=>$deleteId];
        }
        unset($this->editItemDetails[$index]);
        $this->editInvoiceDetails = array_values($this->editItemDetails);
    }

    public function editAdd(){
        $this->validate([
            'editInvoiceDate' => ['required'],
            'editCustomerCode'  => ['required'],
            'service' => ['required'],
            'editPsGroup' => ['required'],
            'editDueDate' => ['required'],
       ]); 
        $check = True;
        $customer_rent= CustomerRental::where('customer_id',$this->editCustomerCode)->where('id',$this->editRental)->with('customer')->first();
        $product_service = ProductService::where('id',$this->service)->first();
        $ps_group = PsGroup::where('id',$this->editPsGroup)->first();
        $periodPs = new periodPs;
        $period = $periodPs->invoicePeriod($this->editInvoiceDate, $ps_group); 
        $wh_tax = $product_service->ps_whtax;
        
       if(Customer::where('id',$this->editCustomerCode)->pluck('cust_gov_flag')->first() == 1){
            $wh_tax = $product_service->gov_whtax;
       } 
        
        if(($product_service->ps_code == "1001" || $product_service->ps_code == "1010") && !is_null($customer_rent)){
            $amt = round($customer_rent->custr_rental_fee * $customer_rent->custr_area_sqm,2);
            $vatamt = round(($amt * $product_service->ps_vat)/100,2);
            $whamt = round(($amt * $wh_tax)/100,2);
            $netamt =$amt + $vatamt;
            $this->editInvoiceDetails[] = 
            [
            'id' => null,
            'pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period ?? 0
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>$wh_tax
            ,'whtaxamt' => $whamt 
            ,'netamt'=> $netamt  
            ,'remark'=>''];
            $check = false;
        }
        if($product_service->ps_code == '1020' && !is_null($customer_rent)){
            $amt = round($customer_rent->custr_area_sqm * $customer_rent->custr_service_fee,2);
            $vatamt = round(($amt * $product_service->ps_vat)/100,2);
            $whamt = round(($amt * $wh_tax)/100,2);
            $netamt =$amt + $vatamt ;
            $this->editInvoiceDetails[] = 
            [
            'id' => null,
            'pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>$wh_tax
            ,'whtaxamt' => $whamt 
            ,'netamt'=>$netamt   
            ,'remark'=>''];
            $check = false;
        }
        if($check){
             $this->editInvoiceDetails[] = 
            [
            'id' => null,    
            'pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=> 0
            ,'vat'=> $product_service->ps_vat 
            ,'vatamt'=> 0
             ,'whvat'=>$wh_tax 
            ,'whtaxamt' => 0
            ,'netamt'=> 0
            ,'remark'=>''];
        }
    }

    

    public function editRemoveDetail($index){
       unset($this->editInvoiceDetails[$index]);
       $this->editInvoiceDetails = array_values($this->editInvoiceDetails);
    }

    public function editInvoice()
    {
        DB::beginTransaction(); // Start the transaction

       
            $this->validate([
                'editInvoiceDate' => ['required'],
                'editCustomerCode' => ['required'],
                'editPsGroup' => ['required'],
                'editDueDate' => ['required'],
                'editInvoiceDetails.*.remark' => ['max:80']
            ],[
                'editInvoiceDetails.*.remark.max' => 'Remark must not be greater than 80 characters.'
            ]);
        try {
            // Update InvoiceHeader
            $header = InvoiceHeader::find($this->editInvoices->id); // Fetch the InvoiceHeader instance

            if (!$header) {
                // Handle case where InvoiceHeader is not found
                throw new \Exception('InvoiceHeader not found');
            }

            $header->update([
                'customer_id' => $this->editCustomerCode,
                'inv_no' => $this->editInvoiceNumber,
                'customer_rental_id' => !empty($this->editRental) ? $this->editRental : null,
                'inv_date' => $this->editInvoiceDate,
                'invd_duedate' => $this->editDueDate,
                'ps_group_id' => $this->editPsGroup,
                'inv_unite' => CustomerRental::where('id', $this->editRental)
                    ->pluck('custr_unit')->first() ?? null,
                'updated_by' => auth()->id(),
            ]);

            // Collect existing InvoiceDetail IDs
            $existingDetailIds = collect($this->editInvoiceDetails)->pluck('id')->filter();

            // Delete InvoiceDetails that are not in the updated list
            InvoiceDetail::where('invoice_header_id', $header->id)
                ->whereNotIn('id', $existingDetailIds->toArray())
                ->delete();

            // Update or Create InvoiceDetails
            foreach ($this->editInvoiceDetails as $detail) {
                if (isset($detail['id'])) {
                    // Update existing InvoiceDetail
                    InvoiceDetail::where('id', $detail['id'])->update([
                        'invd_product_code' => $detail['pscode'],
                        'invd_product_name' => $detail['psname'],
                        'invd_period' => $detail['period'],
                        'invd_amt' => $detail['amt'],
                        'invd_vat_percent' => $detail['vat'],
                        'invd_vat_amt' => $detail['vatamt'],
                        'invd_wh_tax_percent' => $detail['whvat'],
                        'invd_wh_tax_amt' => $detail['whtaxamt'],
                        'invd_net_amt' => $detail['netamt'],
                        'invd_remake' => $detail['remark'],
                        'invd_receipt_flag' => 'No',
                        'updated_by' => auth()->id(),
                    ]);
                } else {
                    // Create new InvoiceDetail with invoice_header_id
                    $newDetail = new InvoiceDetail([
                        'invoice_header_id' => $header->id,
                        'invd_product_code' => $detail['pscode'],
                        'invd_product_name' => $detail['psname'],
                        'invd_period' => $detail['period'],
                        'invd_amt' => $detail['amt'],
                        'invd_vat_percent' => $detail['vat'],
                        'invd_vat_amt' => $detail['vatamt'],
                        'invd_wh_tax_percent' => $detail['whvat'],
                        'invd_wh_tax_amt' => $detail['whtaxamt'],
                        'invd_net_amt' => $detail['netamt'],
                        'invd_remake' => $detail['remark'],
                        'invd_receipt_flag' => 'No',
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]);
                    $header->invoicedetail()->save($newDetail); // Save the new detail with relationship
                }
            }

            DB::commit(); // Commit the transaction if everything goes well
            $this->closeEditModal();

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction if an error occurs
            $this->closeEditModal();
            // Optionally, log the error or handle it
            session()->flash('error','Invoice edit failed: ' . $e->getMessage());
            // You can also re-throw the exception if you need to handle it elsewhere
        }
    } 

    public function closeEditModal(){
        $this->showEditInvoice = false;
            $this->reset(['editPsGroup','editCustomerCode','editcustomerrents','editRental','editInvoiceDate','editInvoiceDetails']);
            $this->resetValidation();
    }

    public function openCancelInvoice($id){
        $this->showDeleteInvoice = true;
        $this->cancelInvoice = $id;
    }
    public function cancelInvoiceModal(){
        try{
        InvoiceHeader::where('id',$this->cancelInvoice)->update([
            'inv_status' => 'CANCEL',
            'inv_remark' => $this->invRemark,
        ]);
        }catch(\Exception $e){
            session()->flash('error','The remark character is exceed 150 character'.$e->getMessage());
        }
        $this->closeCancelInvoice();
    }
    public function closeCancelInvoice(){
        $this->showDeleteInvoice = false;
        $this->reset(['cancelInvoice','invRemark']);
    }

    public function exportPdf($id){
        $number = new numberToBath;
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $invoice = InvoiceHeader::where('id',$id)->with(['invoicedetail','customerrental','customer'])->first();
        $bath = $number->baht_text($invoice->invoicedetail->sum('invd_net_amt'));
        $html1 = view('invoicepdf.invoice4', ['Invoices' => $invoice, 'bath' => $bath])->render();
        $html2 = view('invoicepdf.invoice3', ['Invoices' => $invoice, 'bath' => $bath])->render();
        
        // Combine the HTML and add a page break
        $combinedHtml = $html1 . $html2;
        $pdf = PDF::loadHTML($combinedHtml);
       return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $invoice->inv_no . '.pdf'); 
    } 
      public function exportEngPdf($id){
        $number = new numberToBath;
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $invoice = InvoiceHeader::where('id',$id)->with(['invoicedetail','customerrental','customer'])->first();
        $bath = $number->numberToWords($invoice->invoicedetail->sum('invd_net_amt'));
        $html1 = view('invoicepdf.invoiceengreal', ['Invoices' => $invoice, 'bath' => $bath])->render();
        $html2 = view('invoicepdf.invoiceengcopy', ['Invoices' => $invoice, 'bath' => $bath])->render();
        
        // Combine the HTML and add a page break
        $combinedHtml = $html1 . $html2;
        $pdf = PDF::loadHTML($combinedHtml);
       return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $invoice->inv_no . '.pdf'); 
    } 
    protected function exportReportPDF($invoices,$edFromDate,$exToDate){
        $countInvoice = $invoices->count();
        $exToDate = Carbon::parse($exToDate);
        $uniqueProducts = $invoices->flatMap(function ($invoice) {
            return $invoice->invoicedetail->pluck('invd_product_code');
        })->unique();
        $combinedHtml = null;
        foreach($uniqueProducts as $unique){
            $sumInvoice = collect(); 
            $invoiceFiltereds = $invoices->flatMap(function ($filter) use($unique){
                return $filter->invoicedetail->where('invd_product_code',$unique);
            }); 
            $forSum = $invoiceFiltereds->filter(function($query){
                return $query->invoiceheader->where('inv_status','USE');
            });
            $sumInvoice->amount =  $forSum->sum('invd_amt');
            $sumInvoice->vatAmt =  $forSum->sum('invd_vat_amt');
            $sumInvoice->whAmt =  $forSum->sum('invd_wh_tax_amt');
            $sumInvoice->netAmt =  $forSum->sum('invd_net_amt');
            $chunks = $invoiceFiltereds->chunk(30);
            foreach ($chunks as $index => $chunk) {
                $chunk = $chunk->map(function ($detail) use($exToDate){
                $lastReceipt = $detail->receiptdetail->sortByDesc('id')->first();
                if($detail->invd_receipt_flag == 'No'){
                $invoiceDate = $detail->invoiceheader->invd_duedate ? Carbon::parse($detail->invoiceheader->invd_duedate) : null;
                $receiptDate = $lastReceipt && $lastReceipt->receiptheader ? Carbon::parse($lastReceipt->receiptheader->rec_date) : null;
                $checkDate = $invoiceDate->diffInDays($exToDate);
                    if($checkDate > 0){
                        $detail->overdue = (int)$checkDate; 
                    }
                    else{
                        $detail->overdue = null;
                    }
                }
                else{
                    $detail->overdue = null;
                }
                return $detail;
            });
                if ($index < $chunks->count() - 1) {
                    $report = view('invoicepdf.reportinvoice', [
                    'startDate' => Carbon::parse($edFromDate)->format('d-m-Y'),
                    'filteredDetails' => $chunk, // Pass the chunked data
                    'uniqueProductCode' =>  $unique, 
                    'endDate' => $exToDate->format('d-m-Y'),
                    ])->render();
                }
                else{
                     $report = view('invoicepdf.reportinvoice', [
                    'startDate' => Carbon::parse($edFromDate)->format('d-m-Y'),
                    'filteredDetails' => $chunk, // Pass the chunked data
                    'uniqueProductCode' =>  $unique, 
                    'sumInvoice' => $sumInvoice,
                    'endDate' => $exToDate->format('d-m-Y'),
                    ])->render();
                }
                
                $combinedHtml .= $report;
            }

        }
        $sumAllInvoice = collect();
        $allDetails = $invoices->flatMap(function($invoice) {
            return $invoice->invoicedetail;
        });
        $forSum = $allDetails->filter(function($query){
            return $query->invoiceheader->inv_status == 'USE';
        });
        $sumAllInvoice->amount =  $forSum->sum('invd_amt');
        $sumAllInvoice->vatAmt =  $forSum->sum('invd_vat_amt');
        $sumAllInvoice->whAmt =  $forSum->sum('invd_wh_tax_amt');
        $sumAllInvoice->netAmt =  $forSum->sum('invd_net_amt');

        $chunks = $allDetails->chunk(30);
        foreach($chunks as $index => $chunk){
             if ($index < $chunks->count() - 1) {
                    $report = view('invoicepdf.reportinvoiceall', [
                    'filteredDetails' => $chunk, // Pass the chunked data
                   // 'uniqueProductCode' =>  $unique, 
                    'sumInvoice' => null 
                    ])->render();
                }
                else{
                     $report = view('invoicepdf.reportinvoiceall', [
                    'filteredDetails' => $chunk, // Pass the chunked data
                    // 'uniqueProductCode' =>  $unique, 
                    'sumInvoice' => $sumAllInvoice,
                    'countInvoice' => $countInvoice,
                    ])->render();
                }
                $combinedHtml .= $report;
        }
        $pdf = PDF::loadHTML($combinedHtml);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        },'invoice_report.pdf'); 
    }

    public function openGenMonth(){
        $this->showGenrateInvoice = true;
    }
    public function closeGenMonth(){
        $this->showGenrateInvoice = false;
        $this->reset('genInvDate','genDueDate');
        $this->resetValidation();
    }
    public function genMonthly()
    {
        DB::beginTransaction(); // Start a transaction

        try {
            $this->validate([
                'genInvDate' => 'required',
                'genDueDate' => 'required'
            ]);

            $carbon_date = Carbon::parse($this->genInvDate)->addMonth();
            $start = $carbon_date->copy()->startOfMonth()->format('d/m/Y');
            $end = $carbon_date->copy()->endOfMonth()->format('d/m/Y');
            $period = $start . " - " . $end;

            $availableContracts = CustomerRental::where(function ($query) use ($carbon_date) {
                $query->whereDate('custr_begin_date2', '<=', $carbon_date->endOfMonth())
                    ->whereDate('custr_end_date2', '>=', $carbon_date->startOfMonth());
            })
                ->where("custr_status", "!=", 0)
                ->whereHas("customer", function ($query) {
                    $query->where('cust_invauto', 'Y');
                })
                ->whereHas('listcust')
                ->with('listcust')
                ->get();

            if ($availableContracts) {
                $prefix = 'I' . $this->tower . 'S';
                $year = Carbon::parse($this->genInvDate)->format('Y');
                $datePart = substr($year, -2) . Carbon::parse($this->genInvDate)->format('m');
                $lastInvoice = InvoiceHeader::where('inv_no', 'like', $prefix . $datePart . '%')->orderBy('inv_no', 'desc')->first();

                if (is_null($lastInvoice)) {
                    foreach ($availableContracts as $index => $bill) {
                        $generatedInvoices[] = $prefix . $datePart . str_pad(1 + $index, 4, '0', STR_PAD_LEFT);
                    }
                } else {
                    foreach ($availableContracts as $index => $bill) {
                        $lastNumber = (int) substr($lastInvoice->inv_no, -4);
                        $newNumber = str_pad($lastNumber + 1 + $index, 4, '0', STR_PAD_LEFT);
                        $generatedInvoices[] = $prefix . $datePart . $newNumber;
                    }
                }

                // Creating the InvoiceHeader and InvoiceDetail for each contract
                foreach ($availableContracts as $index => $contract) {

                    $createInvoice = InvoiceHeader::create([
                        'inv_no' => $generatedInvoices[$index],
                        'customer_id' => $contract->customer_id,
                        'customer_rental_id' => $contract->id,
                        'inv_date' => $this->genInvDate,
                        'invd_duedate' => $this->genDueDate,
                        'ps_group_id' => 1,
                        'inv_status' => 'USE',
                        'inv_unite' => $contract->custr_unit ?? null,
                        'inv_tower' => $this->tower,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]);

                    $groupedMonth = $contract->listcust()
                        ->select(
                            'customer_rental_id',
                            'lcr_line',
                            'product_service_id',
                            DB::raw("GROUP_CONCAT(lcr_remark SEPARATOR ' ') as con_remark"),
                            DB::raw('SUM(lcr_rental_fee * lcr_area_sqm) as amt'),
                        )
                        ->groupBy(
                            'customer_rental_id',
                            'product_service_id',
                            'lcr_line',
                        )
                        ->orderBy('lcr_line')
                        ->get();

                    foreach ($groupedMonth as $list) {
                        $wh_tax = $list->productservice->ps_whtax;
                        if ($contract->customer->cust_gov_flag == 1) {
                            $wh_tax = $list->productservice->gov_whtax;
                        }
                        if ($contract->customer->cust_gov_flag == 3) {
                            $wh_tax = 0;
                        }
                        $amt = $list->amt;

                        // Adjust the amount based on the contract start and end dates
                        // if (Carbon::parse($contract->custr_begin_date2)->format('m-Y') == $carbon_date->format('m-Y')) {
                        //     $day = Carbon::parse($contract->custr_begin_date2);
                        //     $endMonth = $day->copy()->endOfMonth();
                        //     $daysRemaining = $day->diffInDays($endMonth) + 1;
                        //     $amt = round(($amt / 30) * $daysRemaining, 2);
                        // }
                        // if (Carbon::parse($contract->custr_end_date2)->format('m-Y') == $carbon_date->format('m-Y')) {
                        //     $day = Carbon::parse($contract->custr_end_date2)->day;
                        //     $amt = round(($amt / 30) * $day, 2);
                        // }

                        // Calculate VAT and withholding tax
                        $vatamt = round(($amt * $list->productservice->ps_vat) / 100, 2);
                        $whamt = round(($amt * $wh_tax) / 100, 2);
                        $netamt = $amt + $vatamt;

                        // Create InvoiceDetail for each product/service
                        $createInvoice->invoicedetail()->create([
                            'invd_product_code' => $list->productservice->ps_code,
                            'invd_product_name' => $list->productservice->ps_name_th,
                            'invd_period' => $period,
                            'invd_amt' => $amt,
                            'invd_vat_percent' => $list->productservice->ps_vat,
                            'invd_vat_amt' => $vatamt,
                            'invd_wh_tax_percent' => $wh_tax,
                            'invd_wh_tax_amt' => $whamt,
                            'invd_net_amt' => $netamt,
                            'invd_remake' => $list->con_remark,
                            'invd_receipt_flag' => "No",
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id(),
                        ]);
                    }
                }
            }

            DB::commit(); // Commit the transaction if everything goes well
            $this->closeGenMonth();
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction if something goes wrong
            $this->closeGenMonth();
            session()->flash('error','Monthly invoice generation failed: ' . $e->getMessage());
            // Log the error for debugging
        }
    } 
    public function openExportInvoice(){
        $this->showExportInvoice = true;

    }
    public function closeExportInvoice(){
        $this->showExportInvoice = false;
    }
    public function exportInvoice(){
        $this->validate([
            'exFromDate' => ['required','date'],
            'exToDate' => ['required','date','after:exFromDate'],
        ],
        [
            'exToDate.after' => "The TO DATE field must be a date after FROM DATE"
        ]);
         $invoice = InvoiceHeader::with('invoicedetail')
         ->when($this->exFromDate, function ($query) {
                $query->whereDate('inv_date','>=', $this->exFromDate);
            })
            ->when($this->exToDate, function($query){
                $query->whereDate('inv_date',"<=" ,$this->exToDate);
            })
            ->get();
        $this->closeExportInvoice(); 
        if($this->reportType === '1'){
            return $this->exportReportPDF($invoice,$this->exFromDate,$this->exToDate);
        }
        else{
            return Excel::download(new InvoiceExport($invoice,$this->exToDate),'report.xlsx');
        }
    }
    
    public function render()
    {
        $invoices = InvoiceHeader::with(['invoicedetail', 'customer'])
        ->when($this->startDate, function ($query) {
            $query->whereDate('inv_date','>=', $this->startDate);
        })
        ->when($this->endDate, function($query){
            $query->whereDate('inv_date',"<=" ,$this->endDate);
        })
        ->when($this->customer != "" ,function ($query){
            $query->where('customer_id',$this->customer);
        })
        ->when($this->status != "" && $this->status != "Cancel", function ($query) {
        $query->where('inv_status', '!=', 'CANCEL') // Exclude 'close' statuses
          ->whereHas('invoicedetail', function ($detailQuery) {
              $detailQuery->where('invd_receipt_flag', $this->status);
          }, '=', function ($subQuery) {
              $subQuery->selectRaw('COUNT(*)')
                       ->from('invoice_details')
                       ->whereColumn('invoice_details.invoice_header_id', 'invoice_headers.id');
          }); 
        }) 
        ->when($this->status == "Cancel", function($query){
            $query->where('inv_status' , $this->status);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('livewire.invoice',compact('invoices')); 
    }
}
