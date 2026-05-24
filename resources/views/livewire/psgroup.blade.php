<div>
    <div class="flex justify-end">
        <button type="button"
            wire:click="exportExcelPsGroup"
            class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-3 me-2 mb-2 ml-3 dark:bg-green-500 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-300">
            Export Excel
        </button>
        <button type="button"
            wire:click="openCreatePs"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create Ps Group
        </button>
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
                                Group Name 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Begin date 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                End date 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Period 
                            </th>
                            <th scope="col" class="px-6 py-3 text-right">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($psgroups as $psgroup)
                         <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}  
                            </th>
                            <td class="px-6 py-4">
                                {{ $psgroup->ps_group }} 
                            </td>
                            <td class="px-6 py-4">
                                {{ $psgroup->ps_desc}} 
                            </td>
                            <td class="px-6 py-4">
                                {{ $psgroup->begin_date}} 
                            </td>
                            <td class="px-6 py-4">
                                {{ $psgroup->end_date}} 
                            </td>
                            <td class="px-6 py-4">
                                {{ $psgroup->ps_period}} 
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" wire:click="openEditPs({{ $psgroup->id }})" class="font-medium text-yellow-500 dark:text-yellow-500 hover:underline">Edit</a>
                            </td>
                        </tr>   
                        @endforeach
                        </tbody>
                </table>
            </div> 
        </div>
    </div>
     @if($showCreatePsGroup)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreatePs"></div>
    <form wire:submit.prevent="createPsGroup" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '550px', 'max-width' : '600px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Ps</div>
            <button wire:click="closeCreatePs" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 ml-3 w-full">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PS Group Name</label>
                    <input wire:model="groupName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    @error('groupName') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="m-3 mr-5 w-full">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <input  wire:model="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('description') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Begin Date</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="begin" required
                            class="bg-gray-50 border border-gray-300 w-full text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select day</option>
                                @foreach ($days as $day )
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                        </select>
                        @error('begin') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                </div> 
                 <div class="m-3 w-full">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select End date</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="end" required
                            class="bg-gray-50 border border-gray-300 w-full text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select day</option>
                            @foreach ($days as $day )
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('end') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                </div> 
                 <div class="m-3 w-full">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 w-full dark:text-white">Select Type</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="type" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full">
                            <option value="last">LAST</option>
                            <option value="present">PRESENT</option>
                            <option value="next">NEXT</option>
                        </select>
                        @error('type') 
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
    @if($showEditPsGroup)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditPs"></div>
    <form wire:submit.prevent="editPsGroup" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '550px', 'max-width' : '600px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Edit Ps</div>
            <button wire:click="closeEditPs" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 ml-3 w-full">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PS Group Name</label>
                    <input wire:model="groupName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </div>
                <div class="m-3 mr-5 w-full">
                    <label 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <input  wire:model="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('remark') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Begin Date</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="begin" required
                            class="bg-gray-50 border border-gray-300 w-full text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select day</option>
                                @foreach ($days as $day )
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                        </select>
                        @error('productId') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                </div> 
                 <div class="m-3 w-full">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select End date</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="end" required
                            class="bg-gray-50 border border-gray-300 w-full text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">select day</option>
                            @foreach ($days as $day )
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('productId') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                </div> 
                 <div class="m-3 w-full">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 w-full dark:text-white">Select Type</label>
                        <label class=" text-sm font-medium text-gray-900"></label>
                        <select wire:model="type" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full">
                            <option value="last">LAST</option>
                            <option value="present">PRESENT</option>
                            <option value="next">NEXT</option>
                        </select>
                        @error('productId') 
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
</div>
