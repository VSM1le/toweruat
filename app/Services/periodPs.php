<?php

namespace App\Services;
use App\Models\PsGroup;
use Carbon\Carbon;

class periodPs{

    public function invoicePeriod($date ,PsGroup $psGroup){
        if($psGroup->ps_period == "last"){
            $carbonDate = Carbon::parse($date);
            $start = $carbonDate->copy()->subMonth()->day($psGroup->begin_date)->format('d/m/Y');
            if($psGroup->end_date == "31"){
                $end = $carbonDate->copy()->endOfMonth()->format('d/m/Y');
            }
            else{
                $end = $carbonDate->copy()->day($psGroup->end_date)->format('d/m/Y');
            }
            $period = $start . " - " . $end;
        } 
        elseif($psGroup->ps_period == "present"){
            $carbonDate = Carbon::parse($date);
            $start = $carbonDate->copy()->day($psGroup->begin_date)->format('d/m/Y');
            if($psGroup->end_date == "31"){
                $end = $carbonDate->copy()->endOfMonth()->format('d/m/Y');
            }
            else{
                $end = $carbonDate->copy()->day($psGroup->end_date)->format('d/m/Y');
            }
            $period = $start . " - " . $end;
        }
        else{
            $carbonDate = Carbon::parse($date);
            $start = $carbonDate->copy()->addMonth()->day($psGroup->begin_date)->format('d/m/Y');
            if($psGroup->end_date == "31"){
                $end = $carbonDate->copy()->addMonth()->endOfMonth()->format('d/m/Y');
            }
            else{
                $end = $carbonDate->copy()->addMonth()->day($psGroup->end_date)->format('d/m/Y');
            }
            $period = $start . " - " . $end;
        }
        return $period;
    }
} 