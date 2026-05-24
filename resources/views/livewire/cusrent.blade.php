<div>
     <div class="flex justify-end">
            <button type="button"
                        wire:click="exportContract"
                        class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-3 me-2 mb-2 ml-3 dark:bg-green-500 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-300">
                        Export Excel
            </button>
            <button type="button"
            wire:click = "openCreateContract"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create Contract</button>
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
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-2 flex justify-between">
            <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="searchContract" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for items">
                </div>
                <div>
                    <div class="mr-5">
                            <label class=" text-sm font-medium text-gray-900"></label>
                            <select id= "status" wire:model.live="contractStatus"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24  p-2.5 ">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                    </div> 
                </div>
            </div>
             <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Customer Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Customer Name 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Custumer Contact 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Customer Unit 
                            </th>
                             <th scope="col" class="px-6 py-3">
                                Begin - End 
                            </th>
                             <th scope="col" class="px-6 py-3">
                                Year
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentals as $rental)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$rental->customer->cust_code}}  
                            </th>
                            <td class="px-6 py-4">
                               {{ $rental->customer->cust_name_th}} 
                            </td>
                            <td class="px-6 py-4">
                               {{ $rental->custr_contract_no}} 
                            </td>
                            <td class="px-6 py-4">
                               {{$rental->custr_unit }} 
                            </td>
                            <td class="px-6 py-4">
                                {{ $rental->custr_begin_date2}} - {{$rental->custr_end_date2}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rental->custr_contract_year }}
                            </td>
                            <td class="px-6 py-4">
                                @if($rental->custr_status === 1)
                                <button wire:click="inactiveCustomerRent({{$rental->id}})" class="font-medium text-green-600 dark:text-green-600 hover:underline">Active</button>
                                @else
                                <button wire:click="activeCustomerRent({{$rental->id}})" class="font-medium text-red-500 dark:text-red-500 hover:underline">Inactive</button>
                                @endif
                                <button wire:click="openEditContract({{ $rental->id }})" class="font-medium text-yellow-500 dark:text-yellow-500 hover:underline">Edit</button>
                                 <button  onclick="window.location.href='{{ route('custlist', ['id' => $rental->id]) }}'" class="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline">Add</button>
                            </td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
        <div class="m-3">
            {{ $rentals->links() }}
        </div>
    </div>

 @if($showEditContract)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditContract"></div>
    <form wire:submit.prevent="editContract" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '550px', 'max-width' : '600px' }">
        <div class="bg-yellow-500 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Edit Contract</div>
            <button wire:click="closeEditContract" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 ml-5">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Customer</label>
                        <label class="w-52 text-sm font-medium text-gray-900"></label>
                        <select wire:model="customerId" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-60 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select customer</option>
                            @foreach ($this->customers as $customer )
                               <option value="{{ $customer->id }}">{{ $customer->cust_code }} : {{ $customer->cust_name_th }}</option> 
                            @endforeach 
                        </select>
                </div>
                <div class="m-3 mr-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contract number</label>
                    <input  wire:model="contractNumber"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
            <div class="flex justify-start w-full">
               <div class="m-3 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contract real number</label>
                    <input  wire:model="contractRNumber"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div> 
                <div class="m-3 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">start date</label>
                    <input  wire:model="startDate" type="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <div class="m-3 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">end date</label>
                    <input  wire:model="endDate" type="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
             <div class="flex justify-start w-full">
                <div class="m-3 w-24 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year</label>
                    <input  wire:model="year"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div> 
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm w-full font-medium text-gray-900 dark:text-white">Unit</label>
                    <input wire:model="unit" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
            <div class="flex justify-start">
                <div class="m-3 w-full ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area sqm</label>
                    <input wire:model="areaSqm" step="0.01" type="number" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rental fee</label>
                    <input wire:model="rentalFee" step="0.01"  type="number"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full ">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service fee</label>
                    <input type="number"  wire:model="serviceFee" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                 <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Equipment fee</label>
                    <input type="number"  wire:model="equipFee" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
              <div class="flex justify-start w-full">
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เงินประกันค่าเช่า</label>
                    <input type="number"  wire:model="insuranceRental" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เงินประกันค่าบริการ</label>
                    <input type="number"  wire:model="insuranceService" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                    <!-- <textarea class="m-3 w-full mr-5" -->
                    <textarea rows="6" wire:model="noteContract"
                        class="bg-gray-50 border border-gray-300 text-gray-900 
                            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
            </div>
            <div>
         <button type="submit" 
        class="text-white bg-yellow-500 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
            </div>
        </div>
    </form>
    </div>
    @endif 

    @if($showCreateContract)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateContract"></div>
    <form wire:submit.prevent="createContract" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '550px', 'max-width' : '600px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Contract</div>
            <button wire:click="closeCreateContract" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 ml-5">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Customer</label>
                        <label class="w-52 text-sm font-medium text-gray-900"></label>
                        <select wire:model="customerId" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-60 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select customer</option>
                            @foreach ($this->customers as $customer )
                               <option value="{{ $customer->id }}">{{ $customer->cust_code }} : {{ $customer->cust_name_th }}</option> 
                            @endforeach 
                        </select>
                </div>
                <div class="m-3 mr-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contract number</label>
                    <input  wire:model="contractNumber"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
            <div class="flex justify-start w-full">
               <div class="m-3 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contract real number</label>
                    <input  wire:model="contractRNumber"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div> 
                <div class="m-3 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">start date</label>
                    <input  wire:model="startDate" type="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <div class="m-3 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">end date</label>
                    <input  wire:model="endDate" type="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
             <div class="flex justify-start w-full">
                <div class="m-3 w-24 ml-5">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year</label>
                    <input  wire:model="year"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div> 
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm w-full font-medium text-gray-900 dark:text-white">Unit</label>
                    <input wire:model="unit" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
            <div class="flex justify-start">
                <div class="m-3 w-full ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area sqm</label>
                    <input wire:model="areaSqm" step="0.01" type="number" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rental fee</label>
                    <input wire:model="rentalFee" step="0.01"  type="number"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full ">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service fee</label>
                    <input type="number"  wire:model="serviceFee" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                 <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Equipment fee</label>
                    <input type="number"  wire:model="equipFee" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เงินประกันค่าเช่า</label>
                    <input type="number"  wire:model="insuranceRental" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เงินประกันค่าบริการ</label>
                    <input type="number"  wire:model="insuranceService" step="0.01" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                    <!-- <textarea class="m-3 w-full mr-5" -->
                    <textarea rows="6" wire:model="noteContract"
                        class="bg-gray-50 border border-gray-300 text-gray-900 
                            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
            </div>
            <div>
            <button type="submit" 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
            </div>
        </div>
    </form>
    </div>
    @endif 
    </div>
