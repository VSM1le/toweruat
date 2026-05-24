<?php

use App\Livewire\Listcustrent;
use App\Models\InvoiceHeader;
use App\Models\ReceiptHeader;
use App\Services\numberToBath;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('',fn () =>to_route('dashboard'));

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('receipt', 'receipt')
    ->middleware(['auth', 'verified'])
    ->name('receipt');
Route::view('customer', 'customer')
    ->middleware(['auth', 'verified'])
    ->name('customer');

Route::view('contract' ,'custrent')
    ->middleware(['auth'])
    ->name('contract');
Route::view('psgroup' ,'psgroup')
    ->middleware(['auth'])
    ->name('psgroup');


Route::view('bill', 'waterelectric')
    ->middleware(['auth'])
    ->name('bill');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('air', 'invoicepdf.air')
    ->name('air');

Route::view('service', 'productservice')
    ->middleware(['auth'])
    ->name('service');

Route::view('credit-note', 'creditnote')
    ->middleware(['auth'])
    ->name('creditnote');


Route::view('contract/{id}','custconlist')->middleware(['auth'])->name('custlist');
// Route::view('invoice3', 'invoicepdf.invoice3')
//     ->middleware(['auth'])
//     ->name('invoice');


Route::get('invoice3/{id}', function ($id) {
    $number = new numberToBath;
    $receipt= ReceiptHeader::where('id',$id)->with(['receiptdetail','customer'])->first();
   $bath = $number->baht_text(round($receipt->receiptdetail->pluck('invoicedetail.invd_net_amt')
                        ->sum(),2)); 

    $receiptDetails = $receipt->receiptdetail->map(function ($detail){
        $detail->calculated_vat = round(($detail->rec_pay * $detail->invoicedetail->invd_vat_percent) / 100,2);
        $detail->gross = round($detail->rec_pay - ($detail->rec_pay * $detail->invoicedetail->invd_vat_percent / 100),2);
        $detail->whtax = round(($detail->rec_pay * $detail->invoicedetail->invd_wh_tax_percent) / 100 , 2);
        return $detail;
    });
    return view('invoicepdf.invoice1', [
        'Receipt' => $receipt,
        'receiptdetails' => $receiptDetails,
        'bath' => $bath,
    ]);})->middleware(['auth'])->name('invoice');    

Route::get('invoice/{id}', function ($id) {
    $number = new numberToBath;
     $invoice = InvoiceHeader::where('id',$id)->with(['invoicedetail','customerrental','customer'])->first();
 $bath = $number->numberToWords($invoice->invoicedetail->sum('invd_net_amt'));
    return view('invoicepdf.invoice4', [
        'Invoices' => $invoice,
        'bath' => $bath,
    ]);})->middleware(['auth'])->name('invoice');   

require __DIR__.'/auth.php';
