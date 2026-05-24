<?php

namespace App\Livewire;

use App\Exports\ServiceExcelExport;
use App\Models\PsGroup;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\ProductService as Service;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Productservice extends Component
{
    use WithPagination; 
    public $searchService;
    public $showCreateService = false;
    public $psCode;
    public $thName;
    public $enName;
    public $groupId;
    public $vat;
    public $whTax;
    public $govWhTax;
    public $showEditService = false;
    public $serviceId;

    public function openCreateService(){
        $this->showCreateService = true; 
    }

    public function createService(){
        $this->validate([
            'psCode' => ['required','max:10','unique:product_services,ps_code'],
            'thName' => ['required','max:150'],
            'enName' => ['required','max:150'],
            'groupId' =>['required'],
            'vat' => ['required','numeric'],
            'whTax' => ['required','numeric'],
            'govWhTax' => ['required','numeric'],
        ]);
        try{
            Service::create([
                'ps_code' => $this->psCode,
                'ps_name_th' => $this->thName,
                'ps_name_en' => $this->enName,
                'ps_group_id' => $this->groupId,
                'ps_vat' => $this->vat,
                'ps_whtax' => $this->whTax,
                'gov_whtax'=> $this->govWhTax,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
            session()->flash('success', ' Create service successful.'); 
        }catch(\Exception $e){
            session()->flash('error', ' Something when wrong.'); 
        }finally{
            $this->closeCreateService();
        }
    }
    public function closeCreateService(){
        $this->showCreateService = false;
        $this->reset('psCode','thName','enName','groupId','vat','whTax','govWhTax');
    }

    public function openEditService($id){
        $this->serviceId = $id;
        $service = Service::find($id);
        $this->psCode = $service->ps_code;
        $this->thName = $service->ps_name_th;
        $this->enName = $service->ps_name_en;
        $this->groupId = $service->ps_group_id;
        $this->vat = $service->ps_vat;
        $this->whTax = $service->ps_whtax;
        $this->govWhTax = $service->gov_whtax;
        $this->showEditService = true;
    }
    public function closeEditService(){
        $this->showEditService = false;
        $this->reset('serviceId','psCode','thName','enName','groupId','vat','whTax','govWhTax');
    }
    public function editService(){
           $this->validate([
            'psCode' => [
                'required',
                'max:10',
                'unique:product_services,ps_code,'.$this->serviceId,
            ], 
            'thName' => ['required','max:150'],
            'enName' => ['required','max:150'],
            'groupId' =>['required'],
            'vat' => ['required','numeric'],
            'whTax' => ['required','numeric'],
            'govWhTax' => ['required','numeric'],
        ]);
        try{
            Service::where('id',$this->serviceId)->update([
                'ps_code' => $this->psCode,
                'ps_name_th' => $this->thName,
                'ps_name_en' => $this->enName,
                'ps_group_id' => $this->groupId,
                'ps_vat' => $this->vat,
                'ps_whtax' => $this->whTax,
                'gov_whtax' => $this->govWhTax,
                'updated_by' => auth()->id(),
            ]);
            session()->flash('success', ' Update service successful.'); 
        }catch(\Exception $e){
            session()->flash('error', ' Fail to update service.'); 
        }finally{
            $this->closeEditService();
        }
    }

    public function exportExcelService(){
        $services =  Service::get();
        return Excel::download(new ServiceExcelExport($services), 'services.xlsx');
    } 
    public function render()
    {
        $psGroups = PsGroup::all();
        $services = Service::when($this->searchService !== "", function ($query) {
        $query->where(function ($subQuery) {
        $subQuery->where('ps_code', 'like', '%' . $this->searchService . '%')
                 ->orWhere('ps_name_th', 'like', '%' . $this->searchService . '%')
                 ->orWhere('ps_name_en', 'like', '%' . $this->searchService . '%');
            });
        })
        ->paginate(10);
        return view('livewire.productservice',compact('services','psGroups'));
    }
}
