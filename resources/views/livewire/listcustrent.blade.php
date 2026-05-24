<div>
     <div class="flex justify-between">
            <div class="flex items-center">
                <button type="button"  onclick="window.location.href='{{ route('contract') }}'"  class="focus:outline-none text-black bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                   <- Back 
                </button>
                <p class="text-2xl dark:text-white mb-2">{{ $contractInfo->custr_contract_no}} : {{ $contractInfo->customer->cust_name_th }}</p>
            </div>
            <button type="button"
            wire:click = "openCreateList"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create List</button>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
             <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                              No. 
                            </th>
                             <th scope="col" class="px-6 py-3">
                              Line 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Th Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Area sqm
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Rental fee 
                            </th>
                             <th scope="col" class="px-6 py-3">
                                Room Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentLists as $rent)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$loop->iteration}}
                            </th>
                             <td class="px-6 py-4">
                                {{ $rent->lcr_line }}
                            </td>
                            <td class="px-6 py-4">
                               {{ $rent->productservice->ps_code}} : {{ $rent->productservice->ps_name_th }} {{ $rent->lcr_remark }} 
                            </td>
                          
                            <td class="px-6 py-4">
                                {{ $rent->lcr_area_sqm }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rent->lcr_rental_fee }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rent->lcr_room_number}}
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="openEditList({{$rent->id}})" class="font-medium text-yellow-500 dark:text-yellow-500 hover:underline">Edit</button>
                                <button wire:click="openDeleteList({{$rent->id}})" class="font-medium ml-2 text-red-500 dark:text-blue-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($showCreateList)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateList"></div>
    <form wire:submit.prevent="createList" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '550px', 'max-width' : '600px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create List</div>
            <button wire:click="closeCreateList" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 ml-3 w-16">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Line</label>
                    <input  wire:model="line" type="number"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('line')
                        border-red-500     
                    @enderror" >
                </div>
                <div class="m-3 w-60">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Product</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="productId" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select product</option>
                            @foreach ($products as $product)
                               <option value="{{ $product->id }}">{{ $product->ps_code }} : {{ $product->ps_name_th }}</option> 
                            @endforeach 
                        </select>
                        @error('productId') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                </div>
                <div class="m-3 mr-5 w-48">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                    <input  wire:model="remark"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('remark') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-48 ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area sqm</label>
                    <input wire:model="areaSqm" step="0.01" type="number" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    @error('areaSqm') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="m-3 w-48">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rental fee</label>
                    <input wire:model="rentalFee" step="0.01"  type="number"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('rentalFee') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            <div class="flex w-full">
                <div class="m-3 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room Name</label>
                    <input wire:model="roomNumber"  
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('roomNumber') 
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
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
            </div>
        </div>
    </form>
    </div>
    @endif  
    @if($showEditList)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditList"></div>
    <form wire:submit.prevent="editList" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '550px', 'max-width' : '600px' }">
        <div class="bg-yellow-500 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create List</div>
            <button wire:click="closeEditList" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 ml-3 w-16">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Line</label>
                    <input  wire:model="line" type="number"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('line')
                        border-red-500     
                    @enderror" />
                   
                </div>
                <div class="m-3 w-60">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Product</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="productId" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select product</option>
                            @foreach ($products as $product)
                               <option value="{{ $product->id }}">{{ $product->ps_code }} : {{ $product->ps_name_th }}</option> 
                            @endforeach 
                        </select>
                        @error('productId') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                </div>
                <div class="m-3 mr-5 w-48">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                    <input  wire:model="remark"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('remark') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div> 
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-48 ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area sqm</label>
                    <input wire:model="areaSqm" step="0.01" type="number" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    @error('areaSqm') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="m-3 w-48">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rental fee</label>
                    <input wire:model="rentalFee" step="0.01"  type="number"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('rentalFee') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
             <div class="flex w-full">
                <div class="m-3 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room Name</label>
                    <input wire:model="roomNumber"  
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('roomNumber') 
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
            class="text-white bg-yellow-500 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
            </div>
        </div>
    </form>
    </div>
    @endif  
    @if($showDeleteList)
<div class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
 <div class="fixed inset-0 bg-gray-300 opacity-40" wire:click="closeDeleteList"></div>
   <div class="w-full max-w-md bg-white shadow-lg rounded-md p-6 relative">
     <svg wire:click="closeDeleteList" xmlns="http://www.w3.org/2000/svg"
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
    <h4 class="text-xl font-semibold text-center">Do you want to Delete this list</h4>
     <div class="flex flex-col space-y-2">
       <button wire:click="deleteList" type="button"
         class="px-6 py-2.5 rounded-md text-white text-sm font-semibold border-none outline-none bg-red-500 hover:bg-red-600 active:bg-red-500">Delete List</button>
       <button wire:click="closeDeleteList" type="button"
         class="px-6 py-2.5 rounded-md text-black text-sm font-semibold border-none outline-none bg-gray-200 hover:bg-gray-300 active:bg-gray-200">Cancel</button>
     </div>
   </div>
 </div>
 @endif
</div>
