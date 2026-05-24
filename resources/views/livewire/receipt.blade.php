<div>
     <div class="flex justify-end">
          <button type="button"
            wire:click = "openReport"  
            class="text-white bg-teal-400 hover:bg-teal-500 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-teal-400 dark:hover:bg-teal-500 focus:outline-none dark:focus:ring-teal-300">
            Export Receipt</button>
            <button type="button"
            wire:click = "openCreateNoInvoice"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            No Invoice</button>
            <button type="button"
            wire:click = "openCreateReceipt"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create Receipt</button>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> 
        @if (session()->has('success'))
            <div class="flex items-center p-4  text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 mb-1" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  <span class="font-medium">Success alert! </span> {{ session('success') }}
                </div>
              </div>
        @endif
        @if (session()->has('error'))
              <div class="flex items-center p-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800 mb-1" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  <span class="font-medium">Warning alert! </span>{{ session('error') }}
                </div>
              </div>
        @endif
         <div class="flex mt-4 justify-start">
                    <div class="flex">
                    <div class="w-48 ml-5">
                        <label for="datefrom" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">From date</label>
                        <input id="datefrom" wire:model.live="startDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                    <div class="w-48 ml-5">
                        <label for="datefrom" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">To date</label>
                        <input id="datefrom" wire:model.live="endDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                     <div class="w-80 ml-5">
                    <label for="customercode" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Customer code</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model.live="customer"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">Select Customer</option>
                        @foreach ($this->customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->cust_code}} : {{$customer->cust_name_th}}</option>
                        @endforeach
                        </select>
                    </div>
                    </div>
                    {{-- <div>
                        <div class="mr-5">
                    <label for="customercode" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Status</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model.live="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24  p-2.5 ">
                            <option value="">All</option>
                            <option value="Yes">Paid</option>
                            <option value="No">UnPaid</option>

                        </select>
                    </div> 
                    </div> --}}
                </div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                   @foreach ($receipt as $index => $pland)
                    <div wire:key="items-{{ $index }}" class="wrapper relative ">
                        <div x-data="{ isOpen: false }" @click="isOpen = !isOpen" class="tab px-5 py-2 border-2   
                            bg-slate-100 shadow-lg relative mb-4 rounded-md cursor-pointer
                            @if ($pland->rec_status== 'Cancel') border-red-500 @endif">
                            <div 
                                class="flex justify-between items-center font-semibold text-lg after:absolute after:right-5 after:text-2xl after:text-gray-400 hover:after:text-gray-950 peer-checked:after:transform peer-checked:after:rotate-45">
                                <div class="flex">
                                    <h2 class="w-8 h-8 bg-sky-300 text-white flex justify-center items-center rounded-sm mr-3">{{ $index + 1 }}</h2>
                                    <h3>{{ $pland->rec_no}} {{ $pland->customer->cust_name_th ?? null}} {{ strtoupper($pland->rec_payment_type)}} 
                                        WH: {{$pland->receiptdetail->sum('whpay') ?? 0}}</h3>
                                    <h3 class="ml-1"></h3>
                                </div>
                                <div class="flex">
                                     <button wire:click.stop="exportEngPdf({{ $pland->id }})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       PDF ENG
                                    </button>
                                    <button wire:click.stop="exportPdf({{ $pland->id }})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       PDF TH
                                    </button>
                                    @if ($pland->rec_status != "Cancel")
                                      <button wire:click.stop="openEditReceipt({{ $pland->id }})"  class="text-white bg-yellow-500 hover:bg-yellow-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       EDIT 
                                    </button> 
                                     <button wire:click.stop="openCancelReceipt({{ $pland->id }})"  class="text-white bg-red-500 hover:bg-red-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       CANCEL 
                                    </button> 
                                    @endif
                                    {{-- <button wire:click.stop="openEditInvoice({{ $pland->id }})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       EDIT 
                                    </button> --}}
                                </div>
                            </div>
                            {{-- Accordion content --}}
                            <div x-show="isOpen" class="answer justify-center mt-5 h-full mr-9"> 
                                <div  @click.stop class="overflow-x-auto"> 
                            @if ($pland->rec_have_inv_flag == '0')
                                    <table  class="m-6 w-full overflow-x-auto  text-sm text-left rtl:text-right text-gray-500 ">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                No.
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Code 
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                vat percent
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                vat amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                whtax amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Paid amount 
                                            </th>
                                        </tr>
                                    </thead>
                                     @foreach ($pland->receiptdetail as $listitem)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row"    
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $loop->iteration }}
                                            </th>
                                            
                                            <td class="px-6 py-4">
                                                {{ $listitem->recd_product_name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->recd_product_code }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->recd_amt}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->recd_vat_percent}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$listitem->recd_vat_amt}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->whpay}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->rec_pay}}
                                            </td>
                                        </tr>   
                                    @endforeach 
                                    </table>
                                @else
                                <table  class="m-6 w-full overflow-x-auto  text-sm text-left rtl:text-right text-gray-500 ">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                No.
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invoice Number
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Code 
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd Amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd vat percent
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd vat amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd whtax percent
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd whtax amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Paid amount 
                                            </th>
                                        </tr>
                                    </thead>
                                     @foreach ($pland->receiptdetail as $listitem)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ $loop->iteration }}
                                            </th>
                                            
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $listitem->invoicedetail->invoiceheader->inv_no}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_product_name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_product_code }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_amt}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_vat_percent}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$listitem->invoicedetail->invd_vat_amt}}
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                {{$listitem->invoicedetail->invd_wh_tax_percent}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_wh_tax_amt}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->rec_pay}}
                                            </td>
                                        </tr>   
                                    @endforeach 
                                </table>
                                @endif
                                </div>
                            </div>
                            {{-- End Accordion content --}}
                        </div>    
                    </div>
                @endforeach
                </div>
                <div class="m-3">
                    {{ $receipt->links() }}
                </div>  
    </div>

     @if($showCreateReceipt)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateReceipt"></div>
    <form wire:submit.prevent="" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" :style="{ 'max-height': '800px', 'max-width' : '1500px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Receipt</div>
            <button wire:click="closeCreateReceipt" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
                <div class="w-48">
                    <label for="vdate" class="text-xs">Receipt date</label>
                    <input id="vdate" wire:model="receiptDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('receiptDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
              
                <div class="w-80 ml-5">
                    <label for="customercode" class="text-xs">Customer code</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model.live="customerCode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option>Select Customer</option>
                        @foreach ($this->customerInvoices as $customer)
                            <option value="{{$customer->id}}">{{$customer->cust_code}} : {{$customer->cust_name_th}}</option>
                        @endforeach
                        </select>
                          @error('customerCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
                <div class="flex content-center ml-5 border border-slate-500 bg-white rounded">
                    <div class="flex items-center pl-5">
                        <input id="default-radio-1" type="radio" value="cash" wire:model.live="paymentType"  name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash</label>
                    </div>
                    <div class="flex items-center ml-5">
                        <input id="default-radio-2" type="radio" value="tran" wire:model.live="paymentType" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Transfer money</label>
                    </div>
                     <div class="flex items-center ml-5 pr-5">
                        <input id="default-radio-3" type="radio" value="cheq" wire:model.live="paymentType" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cheque</label>
                    </div>
                </div>
            </div>
        </div> 
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div>
                {{-- @if($duplicateInput)
                <h3 class="text-red-500 text-xs">There is a duplicate input value in issue field.</h3>
                @endif --}}
                @if (!is_null($invoiceDetails))
                <table class="mt-4 max-w-8xl text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Invoice number</th>
                            <th scope="col" class="px-2 py-3">Contract</th>
                            <th scope="col" class="px-2 py-3">Product code</th>
                            <th scope="col" class="px-2 py-3">Product name</th>
                            <th scope="col" class="px-2 py-3">Percent Wh</th>
                            <th scope="col" class="px-2 py-3">Wh Tax</th>
                            <th scope="col" class="px-2 py-3">Net Amt</th>
                            <th scope="col" class="px-2 py-3">Paid Amt</th>
                            <th scope="col" class="px-2 py-3">Pay</th>
                            <th scope="col" class="px-2 py-3">Wh Pay</th>
                            <th scope="col" class="px-2 py-3">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoiceDetails as $index => $row)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.invdnumber" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.contact" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                   
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.procode" type="text" class="w-20 p-2 border border-gray-300 text-xs rounded" disabled  />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.proname" type="text" class="w-48 p-2 border border-gray-300 text-xs rounded" disabled/>
                                    </td>
                                     <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.perwh" 
                                        type="number" 
                                        class="w-14 p-2 border border-gray-300 text-xs rounded" 
                                        disabled />     
                                    </td>
                                     <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.whtax" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right" 
                                         disabled
                                         />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.netamt" 
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right" 
                                         disabled
                                         />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.receiptamt" 
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right" disabled/>     
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.paid" 
                                        wire:change="updateInvoiceDetails({{ $index}},'paid')"
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right"/>     
                                    </td>
                                      <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.whpay" 
                                        wire:change="updateInvoiceDetails({{ $index}},'whpay')"
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right"/>     
                                    </td>
                                
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex mt-2 justify-center">
                    <div class="w-52">
                        <label for="vdate" class="text-xs">Description</label>
                        <input id="vdate" wire:model="descExceed"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                        @error('descExceed') 
                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror 
                    </div>
                    <div class="w-48 ml-2">
                        <label for="vdate" class="text-xs">Amount</label>
                        <input id="vdate" wire:model="amountExceed" type=number  step="0.01" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                        @error('amountExceed') 
                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror 
                    </div>
                </div>
                @endif
            </div> 
         
        </div>
   
    <div class="bg-gray-100 w-full flex justify-between p-4">
        <div class="flex">
            <div class="flex">
                <div class="w-48">
                    <label  class="text-xs">Cheque Bank</label>
                    <input  
                        wire:model="cheque.bank"  class="w-full p-2 border border-gray-300 text-sm rounded" 
                        wire:change="updateCheque('bank')"
                    /> 

                    @error('cheque.bank') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">Branch</label>
                    <input id="vdate" wire:model="cheque.branch"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.branch') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">NO.</label>
                    <input id="vdate" wire:model="cheque.no"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.no') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">Date</label>
                    <input id="vdate" wire:model="cheque.chequeDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.chequeDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
            </div>
        </div>
        
        <div class="w-48 ml-5">
            <label for="vdate" class="text-xs">Total Amount</label>
            <input id="vdate" wire:model.live="sumCheque"  class="w-full p-2 border border-gray-300 text-sm rounded text-right" 
            type="number"
            step="0.01"
            disabled /> 
        </div>
         <div class="w-48 ml-5">
            <label for="vdate" class="text-xs">Wh amount</label>
            <input id="vdate" wire:model.live="sumWh"  class="w-full p-2 border border-gray-300 text-sm rounded text-right" 
            type="number"
            step="0.01"
            disabled /> 
        </div>

        <div class="content-center ">
        <button  
        wire:click="createReceipt"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
        Save
        </button>
        </div>
    </div>
</form>
</div>
@endif 
@if($showEditReceipt)
        <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditReceipt"></div>
        <form wire:submit.prevent="editReceipt" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
        :style="{ 'max-height': '400px', 'max-width' : '500px' }">
            <div class="bg-orange-500 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
                <div class="text-xl font-bold">Edit Receipt  : {{ $receiptNumber }} </div>
                <button wire:click="closeEditReceipt" type="button" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
                <div class="flex justify-start w-full">
                   <div class="w-48 ml-5 m-3">
                        <label for="editDate" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Invoice Date</label>
                        <input id="editDate" wire:model="receiptDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                     <div class="w-48 ml-5 m-3">
                        <label for="editReceiptNum" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Receipt Number</label>
                        <input id="editReceiptNum" wire:model="receiptNumber"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 w-full flex justify-between p-4">
                <div class="flex">
                    
                </div>
                <div>
                 <button type="submit" 
        class="text-white bg-orange-500 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-600 font-medium rounded-lg text-sm px-5 py-2.5">save</button>
                </div>
            </div>
        </form>
        </div>
@endif 
@if($showEditReceiptNoInvoice)
        <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditReceipt"></div>
        <form wire:submit.prevent="editReceiptNoInvioce" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
        :style="{ 'max-height': '400px', 'max-width' : '500px' }">
            <div class="bg-orange-500 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
                <div class="text-xl font-bold">Edit Receipt  : {{ $receiptNumber }} </div>
                <button wire:click="closeEditReceipt" type="button" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
                <div class="flex justify-start w-full">
                   <div class="w-48 ml-5 m-3">
                        <label for="editDate" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Invoice Date</label>
                        <input id="editDate" wire:model="receiptDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                     <div class="w-48 ml-5 m-3">
                        <label for="editReceiptNum" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Receipt Number</label>
                        <input id="editReceiptNum" wire:model="receiptNumber"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                </div>
                   <div class="">
                    <label for="customercode" class="text-xs">Customer code</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model="editCustomer"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option>Select Customer</option>
                        @foreach ($this->customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->cust_code}} : {{$customer->cust_name_th}}</option>
                        @endforeach
                        </select>
                          @error('editCustomer') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div> 
            </div>
            <div class="bg-gray-100 w-full flex justify-end p-4">
                <div>
                    <button type="submit" 
                    class="text-white bg-orange-500 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-600 font-medium rounded-lg text-sm px-5 py-2.5">save</button>
                </div>
            </div>
        </form>
        </div>
@endif 
@if($showCancelReceipt)
<div class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
 <div class="fixed inset-0 bg-gray-300 opacity-40" wire:click="closeCancelReceipt"></div>
   <form wire:submit.prevent="cancelReceipt" class="w-full max-w-md bg-white shadow-lg rounded-md p-6 relative">
     <svg wire:click="closeCancelReceipt" xmlns="http://www.w3.org/2000/svg"
       class="w-3.5 cursor-pointer shrink-0 fill-black hover:fill-red-500 float-right" viewBox="0 0 320.591 320.591">
       <path
         d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
         data-original="#000000"></path>
       <path
         d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
         data-original="#000000"></path>
     </svg>
     <div class="my-8 text-center flex align-middle justify-center">
    <svg width="149px" height="149px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M512 128C300.8 128 128 300.8 128 512s172.8 384 384 384 384-172.8 384-384S723.2 128 512 128z m0 85.333333c66.133333 0 128 23.466667 179.2 59.733334L273.066667 691.2C236.8 640 213.333333 578.133333 213.333333 512c0-164.266667 134.4-298.666667 298.666667-298.666667z m0 597.333334c-66.133333 0-128-23.466667-179.2-59.733334l418.133333-418.133333C787.2 384 810.666667 445.866667 810.666667 512c0 164.266667-134.4 298.666667-298.666667 298.666667z" fill="#ef4444"></path></g></svg> 
     </div> 
    <h4 class="text-xl font-semibold text-center">Do you want to cancel this Receipt</h4>
    <input wire:model="receiptCancelRemark" 
    class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="REMARK go here" />
     <div class="flex flex-col space-y-2">
       <button  type="submit"
         class="px-6 py-2.5 rounded-md text-white text-sm font-semibold border-none outline-none bg-red-500 hover:bg-red-600 active:bg-red-500">Cancel Receipt</button>
       <button wire:click="closeCancelInvoice" type="button"
         class="px-6 py-2.5 rounded-md text-black text-sm font-semibold border-none outline-none bg-gray-200 hover:bg-gray-300 active:bg-gray-200">Cancel</button>
     </div>
    </form>
 </div>
 @endif

 {{-- Create modal --}}
    @if($showCreateNoInvoice)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateNoInvoice"></div>
    <form wire:submit.prevent="createReceiptNoInvoice" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" :style="{ 'max-height': '800px', 'max-width' : '1500px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Receipt No Invoice</div>
            <button wire:click="closeCreateNoInvoice" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
                <div class="w-48">
                    <label for="vdate" class="text-xs">Receipt date</label>
                    <input id="vdate" wire:model="receiptDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('receiptDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-80 ml-5">
                    <label for="customercode" class="text-xs">Customer code</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model="customerCodeNoInvoice"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option>Select Customer</option>
                        @foreach ($this->customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->cust_code}} : {{$customer->cust_name_th}}</option>
                        @endforeach
                        </select>
                          @error('customerCodeNoInvoice') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
                 <div class="flex content-center ml-5 border border-slate-500 bg-white rounded">
                    <div class="flex items-center pl-5">
                        <input id="default-radio-1" type="radio" value="cash" wire:model.live="paymentType"  name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash</label>
                    </div>
                    <div class="flex items-center ml-5">
                        <input id="default-radio-2" type="radio" value="tran" wire:model.live="paymentType" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Transfer money</label>
                    </div>
                     <div class="flex items-center ml-5 pr-5">
                        <input id="default-radio-3" type="radio" value="cheq" wire:model.live="paymentType" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cheque</label>
                    </div>
                </div>
            </div>
        </div> 
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div>
                {{-- @if($duplicateInput)
                <h3 class="text-red-500 text-xs">There is a duplicate input value in issue field.</h3>
                @endif --}}
                @if (!is_null($receiptDetails))
                <table class="mt-4 max-w-8xl text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Service Code</th>
                            <th scope="col" class="px-2 py-3">Product/Services</th>
                            <th scope="col" class="px-2 py-3">Pay Amt + wh Amt</th>
                            <th scope="col" class="px-2 py-3">Amt</th>
                            <th scope="col" class="px-2 py-3">VAT</th>
                            <th scope="col" class="px-2 py-3">VAT AMT</th>
                            <th scope="col" class="px-2 py-3">WH TAX AMT</th>
                            <th scope="col" class="px-2 py-3">REMARK</th>
                            <th scope="col" class="px-2 py-3">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receiptDetails as $index => $row)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.pscode" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                   
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.psname" type="text" class="w-44 p-2 border border-gray-300 text-xs rounded" disabled  />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.payamt" 
                                        wire:change="updateReceiptDetail({{ $index }}, 'payamt', $event.target.value)" 
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        />
                                    </td>
                                     <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.rawamt" 
                                        type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01" disabled/>
                                    </td> 
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.vat" 
                                        wire:change="updateReceiptDetail({{ $index }}, 'vat', $event.target.value)" 
                                        type="number" 
                                         
                                        class="w-12 p-2 border border-gray-300 text-xs rounded" 
                                        
                                        />     
                                         @if ($errors->has('receiptDetails.' . $index . '.vat'))
                                            <div class="text-red-500 text-xs mt-1">{{ $errors->first('receiptDetails.' . $index . '.vat') }}</div>
                                        @endif 
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.vatamt" 
                                        type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01" disabled />
                                    </td>
                                  <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.whtaxamt" 
                                        type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01"/>
                                    </td> 
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="receiptDetails.{{ $index }}.remark" type="text" class="w-full p-2 border border-gray-300 text-xs rounded" />     
                                         @error('receiptDetails.'.$index.'.remark') 
                                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                                        @enderror 
                                    </td>
                                
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="removeLine({{ $index }})" class="text-red-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div> 
            <div class="w-80 mt-4">
                <label class="w-40 text-sm font-medium text-gray-900"></label>
                <select id= "customercode" wire:model="service"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option value="">Select Product</option>
                    @foreach ($this->productservices as $productservice)
                        <option value="{{$productservice->id}}">{{$productservice->ps_code}} : {{$productservice->ps_name_th}}</option>
                    @endforeach
                </select>
            </div>  
            <div class="mt-4">
                <button type="button" 
                wire:click='addline' 
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
               Add
                </button>
            </div>     
        </div>
   
    <div class="bg-gray-100 w-full flex justify-between p-4">
        <div class="flex">
             <div class="flex">
            <div class="flex">
                <div class="w-48">
                    <label  class="text-xs">Cheque Bank</label>
                    <input  
                    wire:model="cheque.bank"  class="w-full p-2 border border-gray-300 text-sm rounded" 
                    wire:change="updateCheque('bank')"
                    /> 
                    @error('cheque.bank') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">Branch</label>
                    <input id="vdate" wire:model="cheque.branch"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.branch') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">NO.</label>
                    <input id="vdate" wire:model="cheque.no"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.no') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">Date</label>
                    <input id="vdate" wire:model="cheque.chequeDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.chequeDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
            </div>
        </div>
        </div>
            <div class="w-48 ml-5">
                <label for="vdate" class="text-xs">Total Amount</label>
                <input id="vdate" wire:model.live="sumCheque"  class="w-full p-2 border border-gray-300 text-sm rounded text-right" 
                type="number"
                step="0.01"
                disabled /> 
            </div>
            <div class="content-end">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
            </div>
    </div>
</form>
</div>
@endif 
  @if($showExportReceipt)
        <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeReport"></div>
        <form wire:submit.prevent="reportReceipt" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
        :style="{ 'max-height': '300px', 'max-width' : '500px' }">
            <div class="bg-teal-400 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
                <div class="text-xl font-bold">Export Receipt</div>
                <button wire:click="closeReport" type="button" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
                <div class="flex justify-start w-full">
                   <div class="w-full ml-5 m-3">
                        <label for="exFromDate" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">From Date</label>
                        <input id="exFronDate" wire:model="exFromDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                        @error('exFromDate')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full mr-5 m-3">
                        <label for="exToDate" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">To Date</label>
                        <input id="exToDate" wire:model="exToDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                        @error('exToDate')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-full pr-5 pl-5">
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "reportType" wire:model="reportType"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="1">PDF Report</option>  
                            <option value="2">Excel Report</option>  
                        </select>
                          @error('editCustomerCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
            </div>
            <div class="bg-gray-100 w-full flex justify-between p-4">
                <div class="flex">
                    
                </div>
                <div>
                 <button type="submit" 
        class="text-white bg-teal-400 hover:bg-teal-400 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5">Export</button>
                </div>
            </div>
        </form>
        </div>
    @endif  
</div>
