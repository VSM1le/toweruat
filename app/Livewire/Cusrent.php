<?php

namespace App\Livewire;

use App\Exports\ContractExcel;
use App\Models\Customer;
use App\Models\CustomerRental;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Cusrent extends Component
{
    use WithPagination;
    public $searchContract;

    public $customerId;
    public $contractNumber;
    public $contractRNumber;
    public $startDate;
    public $endDate;
    public $year;
    public $unit;
    public $areaSqm;
    public $rentalFee;
    public $serviceFee;
    public $equipFee;
    public $insuranceService; 
    public $insuranceRental; 
    public $noteContract; 
    public $contractStatus;
    public $tower = "A";

    public $showCreateContract = false;

    public $showEditContract = false;
    public $editId;

     #[Computed()]
    public function customers(){
        return Customer::all();
    }
    public function openCreateContract(){
        $this->showCreateContract = true;
    }
    public function createContract(){
        CustomerRental::create([
            'customer_id' => $this->customerId,
            'custr_no' => 1,
            'custr_contract_no' => $this->contractNumber,
            'custr_contract_no_real' => $this->contractRNumber,
            'custr_tower' => $this->tower,
            'custr_unit' => $this->unit,
            'custr_area_sqm' => $this->areaSqm,
            'custr_rental_fee' => $this->rentalFee,
            'custr_service_fee' => $this->serviceFee,
            'custr_equipment_fee' => $this->equipFee,
            'custr_begin_date2' => $this->startDate,
            'custr_end_date2' => $this->endDate,
            'custr_contract_year' => $this->year,
            'insurance_rental' => $this->insuranceRental,
            'insurance_service' => $this->insuranceService,
            'contract_note' => $this->noteContract,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
        $this->closeCreateContract();
    }
    public function activeCustomerRent($id){
        try{
            CustomerRental::where('id',$id)->update([
                'custr_status' => true
            ]);
            session()->flash('success','Update status customer rental successful');
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong'.$e->getMessage());
        }
    }
    public function inactiveCustomerRent($id){
        // dd('test');
        try{
            CustomerRental::where('id',$id)->update([
                'custr_status' => false 
            ]);
            session()->flash('success','Update status customer rental successful');
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong'.$e->getMessage());
        }
    }
    public function closeCreateContract(){
        $this->showCreateContract = false;
        $this->reset(['insuranceRental','insuranceService','noteContract','contractNumber','contractRNumber','customerId','unit','areaSqm','rentalFee','serviceFee','equipFee','startDate','endDate','year']);
    }
    public function exportContract(){
        $contracts = CustomerRental::with('customer')->when($this->contractStatus != "", function($query){
            $query->where('custr_status', $this->contractStatus);
        }) ->get();
        return Excel::download(new ContractExcel($contracts), 'contracts.xlsx');
    }
    public function openEditContract($id){
     
        $this->editId = $id;
        $contract = CustomerRental::where('id',$id)->first();
        $this->customerId = $contract->customer_id;
        $this->contractNumber = $contract->custr_contract_no;
        $this->contractRNumber = $contract->custr_contract_no_real; 
        $this->unit = $contract->custr_unit;
        $this->areaSqm = $contract->custr_area_sqm;
        $this->rentalFee = $contract->custr_rental_fee;
        $this->serviceFee = $contract->custr_service_fee;
        $this->equipFee = $contract->custr_equipment_fee;
        $this->startDate = $contract->custr_begin_date2;
        $this->endDate = $contract->custr_end_date2;
        $this->year = $contract->custr_contract_year;
        $this->insuranceRental = $contract->insurance_rental;
        $this->insuranceService = $contract->insurance_service;
        $this->noteContract = $contract->contract_note;
        $this->showEditContract = true;
    } 

    public function editContract(){
        CustomerRental::where('id',$this->editId)->update([
            'customer_id' => $this->customerId,
            'custr_contract_no' => $this->contractNumber,
            'custr_contract_no_real' => $this->contractRNumber,
            'custr_tower' => $this->tower,
            'custr_unit' => $this->unit,
            'custr_area_sqm' => $this->areaSqm,
            'custr_rental_fee' => $this->rentalFee,
            'custr_service_fee' => $this->serviceFee,
            'custr_equipment_fee' => $this->equipFee,
            'custr_begin_date2' => $this->startDate,
            'custr_end_date2' => $this->endDate,
            'custr_contract_year' => $this->year,
            'insurance_rental' => $this->insuranceRental,
            'insurance_service' => $this->insuranceService,
            'contract_note' => $this->noteContract,
            'updated_by' => auth()->id(),
        ]);
        $this->closeEditContract();
    }

    public function closeEditContract(){
        $this->reset(['insuranceRental','insuranceService','noteContract','contractNumber','contractRNumber','customerId','unit','areaSqm','rentalFee','serviceFee','equipFee','startDate','endDate','year','editId']);
        $this->showEditContract = false;
    }

    public function render()
    {
        $rentals = CustomerRental::whereHas('customer',function($query){
            $query->orderBy('cust_code');
        })
        ->when($this->searchContract,function($query){
            $query->where('custr_contract_no','like','%'.$this->searchContract.'%')
                ->orWhereHas('customer',function($subquery){
                    $subquery->where('cust_name_th','like','%'.$this->searchContract.'%')
                        ->orWhere('cust_code','like','%'.$this->searchContract.'%');
                });
        })->when($this->contractStatus != "", function($query){
            $query->where('custr_status', $this->contractStatus);
        }) 
        ->paginate(10);
        return view('livewire.cusrent',compact('rentals'));
    }
}
