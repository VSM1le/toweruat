<div>
    <div class="flex justify-end">
        <button type="button"
                    wire:click="exportExcelService"
                    class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-3 me-2 mb-2 ml-3 dark:bg-green-500 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-300">
                    Export Excel
        </button>
        <button type="button"
            wire:click="openCreateService"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create Service</button>
    </div>
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
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-2">
             <label for="table-search" class="sr-only">Search</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" wire:model.live="searchService" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for items">
                        </div>
            </div>
             <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No. 
                            </th>
                             <th scope="col" class="px-6 py-3">
                                Ps code
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Service Name th 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Service Name  en
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ps Group
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Vat
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Whtax 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Gov WhTax
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$loop->iteration}}
                            </th>
                             <td class="px-6 py-4">
                                {{ $service->ps_code}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->ps_name_th }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->ps_name_en }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->psgroup->ps_group ?? null}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->ps_vat}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->ps_whtax}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->gov_whtax}}
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="openEditService({{$service->id}})" class="font-medium text-yellow-500 dark:text-yellow-500 hover:underline">Edit</button>
                            </td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
                <div class="m-3">
                    {{ $services->links() }}
                </div>
        </div>
    </div>
    @if($showCreateService)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateService"></div>
    <form wire:submit.prevent="createService" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '700px', 'max-width' : '600px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Service</div>
            <button wire:click="closeCreateService" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ps Code</label>
                    <input wire:model="psCode" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    @error('psCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Th Name</label>
                    <input wire:model="thName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    @error('thName') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
             <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Eng Name</label>
                    <input wire:model="enName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    @error('enName') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
               <div class="flex justify-start w-full">
                 <div class="m-3 w-full mx-5">
                    <label for="groupId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Ps Group
                    </label>
                        {{-- <label class="w-40 text-sm font-medium text-gray-900"></label> --}}
                        <select id= "groudId" wire:model="groupId"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">Select PsGroup</option>  
                            @foreach ($psGroups as $psGroup )
                            <option value="{{ $psGroup->id }}">{{ $psGroup->ps_group }}</option>  
                            @endforeach
                        </select>
                        @error('groupId') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                    </div>
                </div>
            <div class="flex justify-start">
                <div class="m-3 w-full ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">vat</label>
                    <input wire:model="vat"  type="number" step="0.1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('vat') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="m-3 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">WhTax</label>
                    <input wire:model="whTax" type="number"  step="0.1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('whTax') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gov WhTax</label>
                    <input type="number"  wire:model="govWhTax" step="0.1" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('govWhTax') 
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
    @if($showEditService)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditService"></div>
    <form wire:submit.prevent="editService" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '700px', 'max-width' : '600px' }">
        <div class="bg-yellow-500 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Edit Service</div>
            <button wire:click="closeEditService" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ps Code</label>
                    <input wire:model="psCode" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    @error('psCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Th Name</label>
                    <input wire:model="thName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    @error('thName') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
             <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Eng Name</label>
                    <input wire:model="enName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    @error('enName') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
               <div class="flex justify-start w-full">
                 <div class="m-3 w-full mx-5">
                    <label for="groupId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Ps Group
                    </label>
                        {{-- <label class="w-40 text-sm font-medium text-gray-900"></label> --}}
                        <select id= "groudId" wire:model="groupId"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">Select PsGroup</option>  
                            @foreach ($psGroups as $psGroup )
                            <option value="{{ $psGroup->id }}">{{ $psGroup->ps_group }}</option>  
                            @endforeach
                        </select>
                        @error('groupId') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                    </div>
                </div>
            <div class="flex justify-start">
                <div class="m-3 w-full ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">vat</label>
                    <input wire:model="vat"  type="number" step="0.1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('vat') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="m-3 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">WhTax</label>
                    <input wire:model="whTax" type="number"  step="0.1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('whTax') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gov WhTax</label>
                    <input type="number"  wire:model="govWhTax" step="0.1" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('govWhTax') 
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
</div>
