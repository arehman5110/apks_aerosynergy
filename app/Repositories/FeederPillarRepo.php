<?php

namespace App\Repositories;

use App\Models\Substation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class FeederPillarRepo
{
    
    public function store($data, $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $combinedDateTime = $currentDate . ' ' . $request->patrol_time;

      

            $defects = [];
            $defects =['leaning_staus','vandalism_status','advertise_poster_status','rust_status'];

            if ($data->qa_status == '') {
                $data->qa_status = 'pending';
            }
            $total_defects =0;
 
            $data->zone = $request->zone;
            $data->ba = $request->ba;
            $data->team = $request->team;
            $data->visit_date = $request->visit_date;
            $data->patrol_time = $combinedDateTime;

            $data->size = $request->size;
            
            $data->leaning_angle = $request->leaning_angle;

            $gate = [ 'unlocked' => 'false', 'demaged' => 'false', 'other'=>'false'];

            if ($request->has('gate_status')) {
                $gateStatus = $request->gate_status;

                foreach ($gate as $key => $value) {

                    if (array_key_exists($key, $gateStatus)) {
                        $gate[$key] = true;
                        $total_defects++;
                    }else{
                        $gate[$key] = false;
                    }

                }
                $gate['other_value'] = $request->gate_status['other_value'];
            }
            $data->gate_status = json_encode($gate) ;
            foreach ($defects as  $value) {
                $data->{$value} = $request->{$value};
               $request->has($value)&& $request->{$value} == 'Yes' ? $total_defects++ : '';
            }
            $data->total_defects = $total_defects;


            $destinationPath = 'assets/images/cable-bridge/';

            foreach ($request->all() as $key => $file) {
                // Check if the input is a file and it is valid
                if ($request->hasFile($key) && $request->file($key)->isValid()) {
                    $uploadedFile = $request->file($key);
                    $img_ext = $uploadedFile->getClientOriginalExtension();
                    $filename = $key . '-' . strtotime(now()) . '.' . $img_ext;
                    $uploadedFile->move($destinationPath, $filename);
                    $data->{$key} = $destinationPath . $filename;
                }
            }


            $data->save();

        return $data;
    }

public function getSubstation($id )  {
    

    $data = Substation::find($id);
    if ($data) {
        $data->gate_status = json_decode($data->gate_status);
        $data->building_status = json_decode($data->building_status);
      
        return $data;
    }
    return '';
}
}
