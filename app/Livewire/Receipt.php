<?php

namespace App\Livewire;

use App\Exports\ReceiptExport;
use App\Models\Customer;
use App\Models\InvoiceDetail;
use App\Models\InvoiceHeader;
use App\Models\ProductService;
use App\Models\ReceiptHeader;
use App\Models\ReciptDetail;
use App\Services\numberToBath;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Options;
use FontLib\TrueType\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Receipt extends Component
{
    use WithPagination;
    public $receiptDate ;
    public $customerCode = null;
    public $customerCodeNoInvoice = null;

    public $paymentType = "cash";

    public $cheque = ['bank' => "",'branch' => "",'chequeDate' => null,'no' => ""];
    public $receiptDetails;
    public $invoiceDetails;
    public $sumCheque = 0; 
    public $disable = true;
    public $tower = "A";
    public $sumWh = 0;

    public $showCreateReceipt = false;

    public $showCancelReceipt = false;
    public $cancelId;
    public $receiptCancelRemark;
    public $startDate;
    public $endDate;
    public $customer;
    public $receiptNumber;
    public $showEditReceipt = false;
    public $showEditReceiptNoInvoice = false;
    public $editId;
    public $showCreateNoInvoice = false;
    public $service;
    public $editCustomer;
    public $exFromDate;
    public $exToDate;
    public $showExportReceipt = false;
    public $descExceed;
    public $amountExceed;
    public $reportType = '1';

    #[Computed()]
    public function productservices(){
        return ProductService::all();
    } 

    #[Computed()]
    public function customers(){
        return Customer::orderBy('cust_code')->get();
    }

    #[Computed()]
    public function customerInvoices(){
        return Customer::whereHas('invoiceheader',function($query){
            return $query->where('inv_status','=','USE')
                ->whereHas('invoicedetail',function($detail){
                    return $detail->where('invd_receipt_flag','=','No')->orWhere('invd_receipt_flag','=','Partial'); 
            });
        })->get();
    }

     private function sanitizeNumericValue($value)
    {
        $sanitizedValue = preg_replace('/[^-?\d.]/', '', $value);

        return (float) $sanitizedValue;
    }
    public function updateReceiptDetail($index, $field, $value)
    {
        if($this->receiptDetails[$index][$field] == null){
            $this->receiptDetails[$index][$field] = 0;
        }
        if (isset($this->receiptDetails[$index]) && $this->receiptDetails[$index]['payamt'] != null) {
            $this->receiptDetails[$index][$field] = $value;

            // Recalculate vatamt if amt or vat field is updated
            if ($field == 'payamt' || $field == 'vat') {
                $this->sumCheque = 0;
                $amt = $this->receiptDetails[$index]['payamt'] ?? 0;
                $vat = $this->sanitizeNumericValue($this->receiptDetails[$index]['vat'] ?? 0); // Sanitize vat value
                $whvat = $this->sanitizeNumericValue($this->receiptDetails[$index]['whvat'] ?? 0);// Sanitize whvat value

                $rawamt = round(($amt /  (1 + $vat / 100)) ?? 0,2);
                $vatamt = round($amt - $rawamt,2); 
                $whtaxamt = round(($amt * $whvat) / 100 ?? 0,2);
                
                $this->receiptDetails[$index]['vatamt'] = $vatamt;
                $this->receiptDetails[$index]['rawamt'] = $rawamt;
                $this->receiptDetails[$index]['whtaxamt'] = $whtaxamt;
                foreach($this->receiptDetails as $detail){
                    $this->sumCheque += $detail['payamt'];
                }
            }
        }
    }
    public function addline(){
        $this->validate([
            'service' => 'required'
        ]);

        $productService =  ProductService::find($this->service);

        $this->receiptDetails[] = 
            ['pscode'=> $productService->ps_code
            ,'psname' =>$productService->ps_name_th 
            ,'payamt'=> 0
            ,'rawamt'=> 0
            ,'vat'=> $productService->ps_vat ?? 0 
            ,'vatamt'=> 0
            ,'whtaxamt' => 0
            ,'remark'=>''];
    }
     public function removeLine($index){
        unset($this->receiptDetails[$index]);
        $this->receiptDetails = array_values($this->receiptDetails);
        $this->sumCheque = 0;
        foreach($this->receiptDetails as $detail){
            $this->sumCheque += $detail['payamt'];
        }
    }

    public function mount(){
        $this->startDate = Carbon::now('Asia/Bangkok')->startOfMonth()->format('Y-m-d');
        // $this->genMontly();
    }

  public function updateCheque($field)
    {
        if ($this->paymentType !== "cheq") {
            $this->cheque[$field] = null;
        }
    } 

    public function updateInvoiceDetails($index,$field){
        
        if ($this->invoiceDetails[$index][$field] == "") {
            $this->invoiceDetails[$index][$field] = 0;
        }
        if($field == 'paid'){
        $this->sumCheque = 0;    
        foreach ($this->invoiceDetails as $detail) {
            $this->sumCheque += $detail['paid'] ?? 0;
        }
        $this->sumCheque = round($this->sumCheque,2);
        }
        else{
            $this->sumWh = 0;
            foreach($this->invoiceDetails as $detail){
                $this->sumWh += $detail[$field] ?? 0;
            }
            $this->sumWh = round($this->sumWh,2);
        }
         
    }


     public function updatedPaymentType()
    {
        if ($this->paymentType!== 'cheq') {
            foreach ($this->cheque as $key => $value) {
                $this->cheque[$key] = null;
            }
        }
    }

    public function updatedCustomerCode() {
        $this->invoiceDetails = null;
        if(!is_null($this->customerCode)){
            $this->sumCheque = 0;
            $detail_invoices = InvoiceDetail::with('invoiceheader')->whereNot('invd_receipt_flag','Yes')
            ->whereHas('invoiceheader',function($query){
                $query->where('inv_status','USE')->where('customer_id',$this->customerCode);
            })->get();

            if(!is_null($detail_invoices)){
                foreach($detail_invoices as $detail){
                        $amt = round($detail->invd_net_amt - $detail->invd_receipt_amt,2) ?? 0;
                        $whamount = round($detail->invd_wh_tax_amt - ReciptDetail::where('invoice_detail_id',$detail->id)
                        ->whereHas('receiptheader',function ($query){
                            $query->where('rec_status','!=' ,'Cancel');
                        })->sum('whpay') ?? 0,2);
                    $this->invoiceDetails[] = 
                    [
                    'id' => $detail->id,
                    'invdnumber'=> $detail->invoiceheader->inv_no,
                    'contact' => $detail->invoiceheader->customerrental->custr_contract_no ?? null,
                    'procode'=> $detail->invd_product_code,
                    'proname'=> $detail->invd_product_name,
                    'perwh' =>  $detail->invd_wh_tax_percent,
                    'netamt' => $amt,
                    'whtax' => $whamount,
                    'tax' => $detail->invd_vat_amt,
                    'receiptamt' => $detail->invd_receipt_amt ?? 0,
                    'paid' => $amt, 
                    'whpay' =>$whamount, 
                    ];
                    $this->sumCheque +=  $amt;
                    $this->sumWh += $whamount;
                }
                $this->sumWh = round($this->sumWh,2);
                $this->sumCheque = round($this->sumCheque,2);
            
            }
        }
    }

    public function removeItem($index)
    {
        unset($this->invoiceDetails[$index]);

        $this->invoiceDetails = array_values($this->invoiceDetails);

        $this->sumCheque = 0;
        $this->sumWh = 0;
        foreach ($this->invoiceDetails as $detail) {
            $this->sumCheque += $detail['paid'] ?? 0;
            $this->sumWh += $detail['whpay'] ?? 0;
        }
        $this->sumWh = round($this->sumWh,2);
        $this->sumCheque = round($this->sumCheque,2);
    } 

    public function createReceipt()
    {
        DB::beginTransaction(); // Start a transaction

       
            $this->validate([
                'receiptDate' => ['required', 'date'],
                'customerCode' => ['required'],
                'sumCheque' => ['required', 'numeric', 'min:0'],
                'paymentType' => ['required'],
                'invoiceDetails' => ['required', 'array'],
                'cheque.bank' => ['required_if:paymentType,cheq'],
                'cheque.branch' => ['required_if:paymentType,cheq'],
                'cheque.no' => ['required_if:paymentType,cheq'],
                'cheque.chequeDate' => ['required_if:paymentType,cheq', 'nullable', 'date'],
                'amountExceed' => ['required_with:descExceed'],
                'descExceed' => ['required_with:amountExceed','max:180'],
            ],
            [
                'descExceed.max' => 'Remark must not be greater than 180 characters.',
                'cheque.bank.required_if' => 'Bank is required.',
                'cheque.no.required_if' => 'Bank No. is required.',
                'cheque.chequeDate.required_if' => 'Cheque Date is required.',
                'cheque.branch.required_if' => 'Branch is required.'
            ]);
        try {
            // Receipt number generation logic
            $prefix = 'R' . $this->tower . 'S';
            $year = Carbon::parse($this->receiptDate)->format("Y");
            $datePart = substr($year, -2) . Carbon::parse($this->receiptDate)->format('m');
            $lastReceipt = ReceiptHeader::where('rec_no', 'like', $prefix . $datePart . '%')->orderBy('rec_no', 'desc')->first();

            if (is_null($lastReceipt)) {
                $recNo = $prefix . $datePart . '0001';
            } else {
                $lastNumber = (int)substr($lastReceipt->rec_no, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                $recNo = $prefix . $datePart . $newNumber;
            }

            // Create the receipt header
            $create_receipt = ReceiptHeader::create([
                'rec_no' => $recNo,
                'customer_id' => $this->customerCode,
                'rec_date' => $this->receiptDate,
                'rec_status' => "Yes",
                'rec_payment_amt' => $this->sumCheque,
                'rec_payment_type' => $this->paymentType,
                'rec_bank' => $this->cheque['bank'] ?? null,
                'rec_branch' => $this->cheque['branch'] ?? null,
                'rec_cheque_no' => $this->cheque['no'] ?? null,
                'rec_cheque_date' => $this->cheque['chequeDate'] ?? null,
                'rec_exceed_desc' => $this->descExceed ?? null,
                'rec_exceed_amount' => $this->amountExceed ?? null,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Process each invoice detail
            foreach ($this->invoiceDetails as $detail) {
                // Determine receipt flag (Paid or Partial)
                $flag = ($detail['netamt'] <= $detail['paid'] + $detail['receiptamt']) ? "Yes" : "Partial";

                // Update invoice details with the receipt flag and receipt amount
                InvoiceDetail::where('id', $detail['id'])->update([
                    "invd_receipt_flag" => $flag,
                    "invd_receipt_amt" => round($detail['receiptamt'] + $detail['paid'], 2),
                ]);

                // Create the receipt detail
                $create_receipt->receiptdetail()->create([
                    'invoice_detail_id' => $detail['id'],
                    'rec_pay' => $detail['paid'],
                    'whpay' => $detail['whpay'],
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            }

            // Commit the transaction after all operations are successful
            DB::commit();
            
            // Close receipt creation process
            $this->closeCreateReceipt();

            // Redirect to receipt page
            return redirect()->route('receipt');

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            $this->closeCreateReceipt();

            // Log the error for debugging
            session()->flash('error','Receipt creation failed: ' . $e->getMessage());
        } 
    }

    public function openCreateReceipt(){
        $this->showCreateReceipt = true;
    }

     public function closeCreateReceipt(){
        $this->showCreateReceipt = false;
        $this->receiptDate = null;
        $this->customerCode = null;
        $this->paymentType = "cash";
        $this->cheque = ['bank' => "", 'branch' => "", 'chequeDate' => null, 'no' => ""];
        $this->invoiceDetails = [];
        $this->sumCheque = 0;
        $this->resetValidation();
       
    }
    public function openEditReceipt($id){
        $this->editId = $id;
        $receiptHeader = ReceiptHeader::find($id);
        $this->receiptNumber = $receiptHeader->rec_no;
        $this->receiptDate = $receiptHeader->rec_date;

        if($receiptHeader->rec_have_inv_flag === 0){
            $this->editCustomer = $receiptHeader->customer_id;
            $this->showEditReceiptNoInvoice = true;

        }else{
            $this->showEditReceipt = true;
        }
    }
    public function editReceipt(){
        $this->validate([
            'receiptDate' => ['required'],
        ]);
        try{
            ReceiptHeader::where('id',$this->editId)->update([
                'rec_date' => $this->receiptDate,
                'rec_no' => $this->receiptNumber,
            ]);
             session()->flash('success', 'Updated successful.'); 
        }catch(\Exception $e){
             session()->flash('error', 'Failed to update receipt.'); 
        }
        finally{
            $this->closeEditReceipt();
        }
    }
     public function editReceiptNoInvioce(){
        $this->validate([
            'receiptDate' => ['required'],
            'editCustomer' => ['required'],
        ]);
        try{
            ReceiptHeader::where('id',$this->editId)->update([
                'rec_date' => $this->receiptDate,
                'rec_no' => $this->receiptNumber,
                'customer_id' => $this->editCustomer,
            ]);
             session()->flash('success', 'Updated successful.'); 
        }catch(\Exception $e){
             session()->flash('error', 'Failed to update receipt.'); 
        }
        finally{
            $this->closeEditReceipt();
        }
    }
    public function closeEditReceipt(){
        $this->showEditReceipt = false;
        $this->showEditReceiptNoInvoice = false;
        $this->receiptDate = null;
        $this->reset('receiptNumber','editId','editCustomer');
    }
    public function exportPdf($id){
        $number = new numberToBath;
        $sum = 0; 
        $receipt= ReceiptHeader::where('id',$id)->with(['receiptdetail','customer'])->first();
        if($receipt->rec_have_inv_flag == '0'){
            $receiptDetails = $receipt->receiptdetail;
            $realAmount = round($receipt->rec_payment_amt - $receiptDetails->sum('whpay') ?? 0,2); 
            $bath = $number->baht_text($receipt->rec_payment_amt );
            $chunkReceipts = $receiptDetails->chunk(7);
            $countPage = count($chunkReceipts);
            $combinedHtml = null;
            foreach($chunkReceipts as $index => $chunkReceipt ){
            $html1 = view('invoicepdf.invoice1', 
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html1;
        }
        foreach($chunkReceipts as $index => $chunkReceipt ){
            $html2 = view('invoicepdf.invoice2',
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html2;
            }
        }
        else{
        $receiptDetails = $receipt->receiptdetail->map(function ($detail){
        $detail->gross = round($detail->rec_pay * (100 / (100 + $detail->invoicedetail->invd_vat_percent)),2);
        $detail->calculated_vat = round($detail->rec_pay - $detail->gross,2);
        $detail->whtax = round(($detail->rec_pay * $detail->invoicedetail->invd_wh_tax_percent) / 100 , 2);
        return $detail;
        });
        $realAmount = round($receipt->rec_payment_amt - ($receiptDetails->sum('whpay') ?? 0) + ($receipt->rec_exceed_amount ?? 0),2);
        $bath = $number->baht_text($receipt->rec_payment_amt + ($receipt->rec_exceed_amount ?? 0));
          $chunkReceipts = $receiptDetails->chunk(7);
        // dd($chunkReceipts);
        $countPage = count($chunkReceipts);
        $combinedHtml = null;
        foreach($chunkReceipts as $index => $chunkReceipt ){
            $html1 = view('invoicepdf.invoice1', 
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html1;
        }
        foreach($chunkReceipts as $index => $chunkReceipt ){
            $html2 = view('invoicepdf.invoice2',
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html2;
            }
            }
        $pdf = PDF::loadHTML($combinedHtml);
       return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $receipt->rec_no . '.pdf'); 
    } 

     public function exportEngPdf($id){
        $number = new numberToBath;
        $sum = 0; 
        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isRemoteEnabled', true);
        $receipt= ReceiptHeader::where('id',$id)->with(['receiptdetail','customer'])->first();
        if($receipt->rec_have_inv_flag == '0'){
            $receiptDetails = $receipt->receiptdetail;
            $realAmount = round($receipt->rec_payment_amt - $receiptDetails->sum('whpay'),2); 
            $bath = $number->numberToWords($receipt->rec_payment_amt);
            $chunkReceipts = $receiptDetails->chunk(7);
            $countPage = count($chunkReceipts);
            $combinedHtml = null;
            foreach($chunkReceipts as $index => $chunkReceipt ){
            $html1 = view('invoicepdf.receipteng1', 
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html1;
        }
        foreach($chunkReceipts as $index => $chunkReceipt ){
            $html2 = view('invoicepdf.receipteng2',
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html2;
            }
        }
        else{
            $receiptDetails = $receipt->receiptdetail->map(function ($detail){
            $detail->gross = round($detail->rec_pay * (100 / (100 + $detail->invoicedetail->invd_vat_percent)),2);
            $detail->calculated_vat = round($detail->rec_pay - $detail->gross,2);
            $detail->whtax = round(($detail->rec_pay * $detail->invoicedetail->invd_wh_tax_percent) / 100 , 2);
            return $detail;
            });
            $realAmount = round($receipt->rec_payment_amt - ($receiptDetails->sum('whpay') ?? 0) + ($receipt->rec_exceed_amount ?? 0),2);
            $bath = $number->numberToWords($receipt->rec_payment_amt+ ($receipt->rec_exceed_amount ?? 0));
            $chunkReceipts = $receiptDetails->chunk(7);
            $countPage = count($chunkReceipts);
            $combinedHtml = null;
        foreach($chunkReceipts as $index => $chunkReceipt ){
            $html1 = view('invoicepdf.receipteng1', 
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html1;
        }
        foreach($chunkReceipts as $index => $chunkReceipt ){
            $html2 = view('invoicepdf.receipteng2',
                ['Receipt' => $receipt,
                'receiptdetails' => $chunkReceipt,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath,
                'real' => $realAmount])->render();
                $combinedHtml .=  $html2;
            }
        }
       $pdf = PDF::loadHTML($combinedHtml);
       return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $receipt->rec_no . '.pdf'); 
    } 

    public function openCancelReceipt($id){
        $this->cancelId = $id;
        $this->showCancelReceipt = true;
    }

    public function cancelReceipt(){
        DB::beginTransaction();
        try{

            $receipt = ReceiptHeader::find($this->cancelId);
            if($receipt->rec_status != "Cancel"){
            if($receipt->rec_have_inv_flag != '0'){
            foreach($receipt->receiptdetail as $detail){
                $unpaid = max($detail->invoicedetail->invd_receipt_amt - $detail->rec_pay,0);
                $receiptFlag = ($unpaid == 0) ? "No" : "Partial";
                InvoiceDetail::where('id',$detail->invoice_detail_id)->update([
                    "invd_receipt_flag" => $receiptFlag,
                    "invd_receipt_amt" =>$unpaid,
                ]);
                }
            }
                $receipt->update([
                'rec_status' => "Cancel",
                'rec_remark' => $this->receiptCancelRemark
                ]);
            } 
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            session()->flash('error','something wrong while trying to cancel receipt: '.$e->getMessage());
        }finally{
            $this->closeCancelReceipt();
        }
    }

    public function closeCancelReceipt(){
        $this->showCancelReceipt = false;
        $this->reset('cancelId');
    }

    public function openCreateNoInvoice(){
        $this->showCreateNoInvoice = true;
    }
    public function createReceiptNoInvoice(){
        $this->validate([
            'receiptDate' => ['required'],
            'customerCodeNoInvoice' => ['required'],
            'paymentType' => ['required'],
            'receiptDetails' => ['required', 'array'],
            'cheque.bank' => ['required_if:paymentType,cheq'],
            'cheque.branch' => ['required_if:paymentType,cheq'],
            'cheque.no' => ['required_if:paymentType,cheq'],
            'cheque.chequeDate' => ['required_if:paymentType,cheq', 'nullable', 'date'],
            'receiptDetails.*.remark' => ['max:80']
        ],
        [
            'receiptDetails.*.remark.max' => 'Remark must not be greater than 80 characters.',
            'customerCodeNoInvoice.required' => "The customer code field is required.",
            'cheque.bank.required_if' => 'Bank is required.',
            'cheque.no.required_if' => 'Bank No. is required.',
            'cheque.chequeDate.required_if' => 'Cheque Date is required.',
            'cheque.branch.required_if' => 'branch is required.'
        ]);

        $prefix = 'R'.$this->tower.'S';
        $year = Carbon::parse($this->receiptDate)->format("Y");
        $datePart = substr($year,-2) . Carbon::parse($this->receiptDate)->format('m');

        $lastReceipt= ReceiptHeader::where('rec_no', 'like', $prefix . $datePart . '%')->orderBy('rec_no', 'desc')->first();

        if (is_null($lastReceipt)) {
            $recNo = $prefix . $datePart . '0001';
        } else {
            $lastNumber = (int)substr($lastReceipt->rec_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $recNo = $prefix . $datePart . $newNumber;
        }
        try{
        DB::beginTransaction(); 
        $create_receipt = ReceiptHeader::create([
            'rec_no' => $recNo,
            'customer_id' => $this->customerCodeNoInvoice,
            'rec_date' => $this->receiptDate,
            'rec_status' => "Yes",
            'rec_payment_amt' => $this->sumCheque,
            'rec_payment_type' => $this->paymentType,
            'rec_bank' => $this->cheque['bank'] ?? null,
            'rec_branch' => $this->cheque['branch'] ?? null,
            'rec_cheque_no' => $this->cheque['no'] ?? null,
            'rec_cheque_date' => $this->cheque['chequeDate'] ?? null,
            'rec_have_inv_flag' => false,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        foreach($this->receiptDetails as $detail){
            $create_receipt->receiptdetail()->create([
                'recd_product_code' => $detail['pscode'],
                'recd_product_name' => $detail['psname'],
                'recd_amt' => $detail['rawamt'],
                'recd_vat_percent' => $detail['vat'],
                'recd_vat_amt' => $detail['vatamt'], 
                'whpay' => $detail['whtaxamt'],
                'rec_pay' => $detail['payamt'],
                'recd_remark' => $detail['remark'], 
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
            DB::commit();
            session()->flash('success', ' Create receipt successful.'); 
        }
        }catch(\Exception $e){
            DB::rollBack();
            session()->flash('error', " Something went wrong can't create receipt.".$e->getMessage()); 

        }finally{
            $this->closeCreateNoInvoice();
        }
    }
    public function closeCreateNoInvoice(){
        $this->showCreateNoInvoice= false;
        $this->receiptDate = null;
        $this->customerCodeNoInvoice = null;
        $this->paymentType = "cash";
        $this->cheque = ['bank' => "", 'branch' => "", 'chequeDate' => null, 'no' => ""];
        $this->receiptDetails = [];
        $this->sumCheque = 0;
        $this->resetValidation(); 
    }
    public function openReport(){
        $this->showExportReceipt = true;
    }
    public function closeReport(){
        $this->showExportReceipt = false;
    }
    public function reportReceipt(){
         $this->validate([
            'exFromDate' => ['required','date'],
            'exToDate' => ['required','date','after:exFromDate'],
        ],
        [
            'exToDate.after' => "The TO DATE field must be a date after FROM DATE"
        ]); 
        $receipt = ReciptDetail::whereHas('receiptheader', function ($query) {
            $query->whereDate('rec_date', '>=', $this->exFromDate)
                  ->whereDate('rec_date', '<=', $this->exToDate);
            })
            ->with([
                'invoicedetail',
                'receiptheader',
                'invoicedetail.invoiceheader',
                'invoicedetail.invoiceheader.customerrental'
            ])->get();

        // Sum of rec_pay where rec_status is 'Yes'
        $sumValidReceipt = $receipt->filter(function($detail) {
            return $detail->receiptheader->rec_status === 'Yes';
        })->sum('rec_pay');
         $sumExceed= $receipt->filter(function($detail) {
            return $detail->receiptheader->rec_status === 'Yes';
        })->sum('rec_exceed_amount');
        $sumCancelReceipt = $receipt->filter(function($detail) {
            return $detail->receiptheader->rec_status === 'Cancel';
        })->sum('rec_pay');

        if($this->reportType== '1'){

            $combineHtml = null;
            $countPage = 0;
            $chunks = $receipt->chunk(30);
            $count = count($chunks);
            foreach($chunks as $index => $chunk){
                $report = view('invoicepdf.receiptreport',[
                    'startDate' => Carbon::parse($this->exFromDate)->format('d-m-Y'),
                    'endDate' => Carbon::parse($this->exToDate)->format('d-m-Y'),
                    'filteredDetails' => $chunk,
                    'sumPage' => $count,
                    'currentPage' => $index + 1,
                    'sumValidReceipt' => $sumValidReceipt,
                    'sumCancelReceipt' => $sumCancelReceipt,
                    'sumExceed' => $sumExceed,
                ]);
                $combineHtml .= $report;
                }
            $excessOrLacks = ReceiptHeader::whereDate('rec_date', '>=', $this->exFromDate)
                ->whereDate('rec_date', '<=', $this->exToDate)
                ->whereNotNull('rec_exceed_amount')
                ->get();
            if($excessOrLacks->count() > 0){
                $report = view('invoicepdf.receiptreport2',[
                    'startDate' => Carbon::parse($this->exFromDate)->format('d-m-Y'),
                    'endDate' => Carbon::parse($this->exToDate)->format('d-m-Y'),
                    'excessOrLacks' => $excessOrLacks,
                ]);
                $combineHtml .= $report;
            }
            $pdf = PDF::loadHTML($combineHtml);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            },'receipt_report.pdf'); 
        }else{

            return Excel::download(new ReceiptExport($receipt),'report.xlsx');
        }
    }

    public function render()
    {
        $receipt = ReceiptHeader::with(['customer','receiptdetail'])
        ->when($this->startDate, function ($query) {
            $query->whereDate('rec_date','>=', $this->startDate);
        })
        ->when($this->endDate, function($query){
            $query->whereDate('rec_date',"<=" ,$this->endDate);
        })
        ->when($this->customer ,function ($query){
            $query->where('customer_id',$this->customer);
        })
        ->orderBy('rec_no','desc')
        ->paginate(10);
        return view('livewire.receipt', compact('receipt'));
    }
}
