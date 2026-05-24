<div>
    <div class="flex justify-end">
        <div class="flex">
            <button type="button"
                wire:click = "openExportCreditNote"  
                class="text-white bg-teal-400 hover:bg-teal-500 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-teal-400 dark:hover:bg-teal-500 focus:outline-none dark:focus:ring-teal-300">
                Export Credit Note 
            </button> 
            <button type="button"
                wire:click = "openCreateCreditNoteNoReceipt"  
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Create  Credit Note 
            </button>
        </div>
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
         <div class="flex mt-4 justify-between">
                    <div class="flex">
                    <div class="w-48 ml-5">
                        <label for="datefrom" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">From date</label>
                        <input id="datefrom" wire:model.live="startDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                    <div class="w-48 ml-5">
                        <label for="datefrom" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">To date</label>
                        <input id="datefrom" wire:model.live="endDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    </div>
                    </div>
                    <div>
                        <div class="mr-5">
                    <label for="statusCredit" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Status</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select id= "statusCredit" wire:model.live="statusCredit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24  p-2.5 ">
                            <option value="">All</option>
                            <option value="1">Use</option>
                            <option value="0">Cancel</option>

                        </select>
                    </div> 
                    </div>
                </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
                @foreach ($creditNotes as $index => $creditNote)
                    <div wire:key="items-{{ $index }}" class="wrapper relative ">
                        <div x-data="{ isOpen: false }" @click="isOpen = !isOpen" class="tab px-5 py-2 border-2   
                            bg-slate-100 shadow-lg relative mb-4 rounded-md cursor-pointer @if ($creditNote->credit_status === 0 ) border-red-500 @endif  ">
                            <div 
                                class="flex justify-between items-center font-semibold text-lg after:absolute after:right-5 after:text-2xl after:text-gray-400 hover:after:text-gray-950 peer-checked:after:transform peer-checked:after:rotate-45">
                                <div class="flex">
                                    <h2 class="w-8 h-8 bg-sky-300 text-white flex justify-center items-center rounded-sm mr-3">{{ $index + 1 }}</h2>
                                    <h3>{{ $creditNote->credit_no }} {{ $creditNote->credit_receipt_num }} {{ $creditNote->customer->cust_name_th}} {{ $creditNote->customerrental->custr_contract_no ?? null}}</h3>
                                    <h3 class="ml-1"></h3>
                                </div>
                                <div class="flex">
                                     <button wire:click.stop="exportCreditNote({{$creditNote->id}})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       PDF ENG
                                    </button>
                                    <button wire:click.stop="exportCreditNoteTH({{$creditNote->id}})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       PDF TH
                                    </button>
                                    
                                    @if ($creditNote->credit_status === 1)
                                     <button wire:click.stop="openEditCreditNote({{$creditNote->id}})"  class="text-white bg-yellow-500 hover:bg-yellow-800  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                        Edit
                                    </button>
                                    <button wire:click.stop="showCancelCreditNote({{ $creditNote->id }})"  class="text-white bg-red-500 hover:bg-red-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       CANCEL 
                                    </button> 
                                     @endif
                                </div>
                            </div>
                            {{-- Accordion content --}}
                            <div x-show="isOpen" class="answer justify-center mt-5 h-full mr-9"> 
                                <div  @click.stop class="overflow-x-auto"> 
                                <table  class="m-6 w-full overflow-x-auto  text-sm text-left rtl:text-right text-gray-500 ">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                No.
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Code 
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Name
                                            </th>
                                           <th scope="col" class="px-6 py-3">
                                                Credit Amount
                                            </th>
                                           <th scope="col" class="px-6 py-3">
                                                Credit vat amount
                                            </th>
                                           <th scope="col" class="px-6 py-3">
                                                Credit whtax amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Credit net amount
                                            </th>
                                        </tr>
                                    </thead>
                                     @foreach ($creditNote->creditdetail as $detail)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ $loop->iteration }}
                                            </th>
                                            
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $detail->crd_service_code }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $detail->crd_service_name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $detail->crd_amt }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $detail->crd_tax_amt }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $detail->crd_wh_amt }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $detail->crd_net_amt }}
                                            </td>
                                    @endforeach 
                                </table>
                                 </div>
                            </div>
                            {{-- End Accordion content --}}
                        </div>    
                    </div>
                @endforeach
        </div>
        <div class="m-3">
            {{ $creditNotes->links() }}
        </div>
    </div>
    {{-- Create modal --}}
    @if($showCreateCredit)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateCreditNoteNoReceipt"></div>
    <form wire:submit.prevent="createCreditnoteNoReceipt" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" :style="{ 'max-height': '800px', 'max-width' : '1500px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Credit</div>
            <button wire:click="closeCreateCreditNoteNoReceipt" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
                <div class="w-48">
                    <label for="creditDate" class="text-xs">Credit date</label>
                    <input id="creditDate" wire:model="creditDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('creditDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-80 ml-5">
                    <label for="customercode" class="text-xs">Customer code</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model.live="customerCode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option>Select Customer</option>
                        @foreach ($this->customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->cust_code}} : {{$customer->cust_name_th}}</option>
                        @endforeach
                        </select>
                          @error('customerCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
               
                 <div class="w-48 ml-5">
                    <label for="rental" class="text-xs">Contact</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "rental" wire:model.live="rental"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">Select Contact</option>
                             @if (!is_null($customerCode))
                            @foreach ( $customerrents as $rental )
                                <option value="{{ $rental->id}}">{{ $rental->custr_contract_no}} : {{ $rental->custr_unit }}</option>
                            @endforeach 
                            @endif
                        </select>
                    @error('rental') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div> 
                <div class="w-48 ml-5">
                    <label for="receipt" class="text-xs">Receipt Number</label>
                    <input id="receipt" wire:model="receiptNumber" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('receiptNumber') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="receiptDate" class="text-xs">Receipt Date</label>
                    <input id="receiptDate" wire:model="receiptDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('receiptDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
            </div>
        </div> 
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div>
                {{-- @if($duplicateInput)
                <h3 class="text-red-500 text-xs">There is a duplicate input value in issue field.</h3>
                @endif --}}
                @if (!is_null($creditDetails))
                <table class="mt-4 max-w-8xl text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Service Code</th>
                            <th scope="col" class="px-2 py-3">Product/Services</th>
                            <th scope="col" class="px-2 py-3">AMT</th>
                            <th scope="col" class="px-2 py-3">VAT AMT</th>
                            <th scope="col" class="px-2 py-3">WH TAX AMT</th>
                            <th scope="col" class="px-2 py-3">Net AMT</th>
                            <th scope="col" class="px-2 py-3">REMARK</th>
                            <th scope="col" class="px-2 py-3">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($creditDetails as $index => $row)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.pscode" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                   
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.psname" type="text" class="w-44 p-2 border border-gray-300 text-xs rounded" disabled  />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.amt" 
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded" 
                                         />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.vatamt" 
                                        type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01"/>
                                    </td>
                                  <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.whtaxamt" 
                                        type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01" />
                                    </td> 
                                    <td scope="row" class="px-2py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.netamt" type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01"/>     
                                    </td>
                                     <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.remark" type="text" class="w-full p-2 border border-gray-300 text-xs rounded" />     
                                        @error('creditDetails.'.$index.'.remark') 
                                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                                        @enderror 
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
                @endif
            </div> 
            <div class="w-80 mt-4">
                <label class="w-40 text-sm font-medium text-gray-900"></label>
                <select id= "customercode" wire:model.live="service"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option value="">Select Product Service</option>
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
        {{-- <button type="button" wire:click="" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5">Clear</button>
            <form>   
                <input class="ml-2 block w-full text-sm text-slate-500
                file:mr-4 file:py-2.5 file:px-5 file:rounded-md
                file:border-0 file:text-sm file:font-semibold
                file:bg-pink-200 file:text-pink-700
                hover:file:bg-pink-300" type="file" wire:model="">
                <button type="button" wire:click="" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5">Import</button>
            </form> 
            <button type="button" wire:click="" class="ml-2 text-white bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-orange-200 font-medium rounded-lg text-sm px-5 py-2.5">Check</button> --}}
        </div>
        
        <div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
        </div>
    </div>
</form>
</div>
@endif  
@if($showDeleteCreditNote)
<div class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
 <div class="fixed inset-0 bg-gray-300 opacity-40" wire:click="closeCancelCreditNote"></div>
   <form wire:submit.prevent="cancelCreditNote" class="w-full max-w-md bg-white shadow-lg rounded-md p-6 relative">
     <svg wire:click="closeCancelCreditNote" xmlns="http://www.w3.org/2000/svg"
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
    <h4 class="text-xl font-semibold text-center">Do you want to cancel this credit note</h4>
    <input wire:model="creditRemark" 
    class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="REMARK go here" />
     <div class="flex flex-col space-y-2">
       <button type="submit"
         class="px-6 py-2.5 rounded-md text-white text-sm font-semibold border-none outline-none bg-red-500 hover:bg-red-600 active:bg-red-500">Cancel credit note</button>
       <button wire:click="closeCancelCreditNote" type="button"
         class="px-6 py-2.5 rounded-md text-black text-sm font-semibold border-none outline-none bg-gray-200 hover:bg-gray-300 active:bg-gray-200">Cancel</button>
     </div>
    </form>
 </div>
 @endif
    @if($showExportCreditNote)
        <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeExportCreditNote"></div>
        <form wire:submit.prevent="exportCreditNoteReport" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
        :style="{ 'max-height': '300px', 'max-width' : '500px' }">
            <div class="bg-teal-400 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
                <div class="text-xl font-bold">Export credit Note</div>
                <button wire:click="closeExportCreditNote" type="button" class="focus:outline-none">
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
     @if($showEditCredit)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditCreditNoteNoReceipt"></div>
    <form wire:submit.prevent="editCredit" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" :style="{ 'max-height': '800px', 'max-width' : '1500px' }">
        <div class="bg-yellow-500 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Edit Credit</div>
            <button wire:click="closeEditCreditNoteNoReceipt" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
                <div class="w-48">
                    <label for="creditDate" class="text-xs">Credit date</label>
                    <input id="creditDate" wire:model="creditDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('creditDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-80 ml-5">
                    <label for="customercode" class="text-xs">Customer code</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model.live="customerCode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option>Select Customer</option>
                        @foreach ($this->customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->cust_code}} : {{$customer->cust_name_th}}</option>
                        @endforeach
                        </select>
                          @error('customerCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
               
                 <div class="w-48 ml-5">
                    <label for="rental" class="text-xs">Contact</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "rental" wire:model.live="rental"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">Select Contact</option>
                             @if (!is_null($customerCode))
                            @foreach ( $customerrents as $rental )
                                <option value="{{ $rental->id}}">{{ $rental->custr_contract_no}} : {{ $rental->custr_unit }}</option>
                            @endforeach 
                            @endif
                        </select>
                    @error('rental') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div> 
                <div class="w-48 ml-5">
                    <label for="receipt" class="text-xs">Receipt Number</label>
                    <input id="receipt" wire:model="receiptNumber" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('receiptNumber') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="receiptDate" class="text-xs">Receipt Date</label>
                    <input id="receiptDate" wire:model="receiptDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('receiptDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
            </div>
        </div> 
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div>
                {{-- @if($duplicateInput)
                <h3 class="text-red-500 text-xs">There is a duplicate input value in issue field.</h3>
                @endif --}}
                @if (!is_null($creditDetails))
                <table class="mt-4 max-w-8xl text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Service Code</th>
                            <th scope="col" class="px-2 py-3">Product/Services</th>
                            <th scope="col" class="px-2 py-3">AMT</th>
                            <th scope="col" class="px-2 py-3">VAT AMT</th>
                            <th scope="col" class="px-2 py-3">WH TAX AMT</th>
                            <th scope="col" class="px-2 py-3">Net AMT</th>
                            <th scope="col" class="px-2 py-3">REMARK</th>
                            <th scope="col" class="px-2 py-3">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($creditDetails as $index => $row)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.pscode" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                   
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.psname" type="text" class="w-44 p-2 border border-gray-300 text-xs rounded" disabled  />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.amt" 
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded" 
                                         />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.vatamt" 
                                        type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01"/>
                                    </td>
                                  <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.whtaxamt" 
                                        type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01" />
                                    </td> 
                                    <td scope="row" class="px-2py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.netamt" type="number" class="w-full p-2 border border-gray-300 text-xs rounded" 
                                        step="0.01"/>     
                                    </td>
                                     <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="creditDetails.{{ $index }}.remark" type="text" class="w-full p-2 border border-gray-300 text-xs rounded" />     
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
                @endif
            </div> 
            <div class="w-80 mt-4">
                <label class="w-40 text-sm font-medium text-gray-900"></label>
                <select id= "customercode" wire:model.live="service"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option value="">Select Product Service</option>
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
        {{-- <button type="button" wire:click="" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5">Clear</button>
            <form>   
                <input class="ml-2 block w-full text-sm text-slate-500
                file:mr-4 file:py-2.5 file:px-5 file:rounded-md
                file:border-0 file:text-sm file:font-semibold
                file:bg-pink-200 file:text-pink-700
                hover:file:bg-pink-300" type="file" wire:model="">
                <button type="button" wire:click="" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5">Import</button>
            </form> 
            <button type="button" wire:click="" class="ml-2 text-white bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-orange-200 font-medium rounded-lg text-sm px-5 py-2.5">Check</button> --}}
        </div>
        
        <div>
        <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
        </div>
    </div>
</form>
</div>
@endif 
</div>
