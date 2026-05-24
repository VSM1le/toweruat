<?php

namespace App\Livewire;

use App\Exports\PsGroupExcelExport;
use Livewire\Component;
use App\Models\PsGroup as mPsGroup;
use Maatwebsite\Excel\Facades\Excel;

class Psgroup extends Component
{
    public $showCreatePsGroup = false;
    public $showEditPsGroup = false;
    public $days = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 31];
    public $groupName;
    public $description;
    public $begin;
    public $end;
    public $type = "last";
    public $psGroupId;
    public function openCreatePs(){
        $this->showCreatePsGroup = true;
    }
    public function createPsGroup(){
        // dd('test');
        $this->validate([
            'groupName' => ["required","max:5"],
            'description' => ["required","max:30"],
            'begin' => ["required"],
            'end' => ["required"],
            'type' => ["required"],
        ]);
       try {
            mPsGroup::create([
                'ps_group' => $this->groupName,
                'ps_desc' => $this->description,
                'begin_date' => $this->begin,
                'end_date' => $this->end,
                'ps_period' => $this->type,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

       }catch (\Exception $e) {
            \Log::error('Failed to create PS Group: ' . $e->getMessage());
            session()->flash('error', 'Failed to create PS Group. Please try again.');

        }finally {
            $this->closeCreatePs(); 
        } 
    }
    public function closeCreatePs(){
        $this->showCreatePsGroup = false;
        $this->reset('groupName','description','begin','end','type');
    }
    public function openEditPs($id){
        $psGroup = mPsGroup::find($id);
        $this->psGroupId = $id;
        $this->groupName = $psGroup->ps_group;
        $this->description = $psGroup->ps_desc;
        $this->begin = $psGroup->begin_date;
        $this->end = $psGroup->end_date;
        $this->type = $psGroup->ps_period;

        $this->showEditPsGroup = true;
    }
    public function editPsGroup(){
         $this->validate([
            'groupName' => ["required","max:5"],
            'description' => ["required","max:30"],
            'begin' => ["required"],
            'end' => ["required"],
            'type' => ["required","max:15"],
        ]);
        try{
            mPsGroup::where('id',$this->psGroupId)->update([
                'ps_group' => $this->groupName,
                'ps_desc' => $this->description,
                'begin_date' => $this->begin,
                'end_date' => $this->end,
                'ps_period' => $this->type,
                'updated_by' => auth()->id(),
            ]);            
        }catch(\Exception $e){

        }finally{
            $this->closeEditPs();
        }
    }
    public function closeEditPs(){
        $this->showEditPsGroup = false;
        $this->reset('psGroupId','groupName','description','begin','end','type');
    }

    public function exportExcelPsGroup(){
        $psGroups = mPsGroup::get();
        return Excel::download(new PsGroupExcelExport($psGroups), 'productGroup.xlsx');
    }
    public function render()
    {
        $psgroups = mPsGroup::all();
        return view('livewire.psgroup',compact('psgroups'));
    }
}
