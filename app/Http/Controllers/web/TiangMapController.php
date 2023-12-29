<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Tiang;
use Illuminate\Http\Request;
use App\Repositories\TiangRepository;
use Illuminate\Support\Facades\Auth;

class TiangMapController extends Controller
{
    //
    private $tiangRepository;

    public function __construct(TiangRepository $tiaRepository)
    {
        $this->tiangRepository = $tiaRepository;
    }
    public function editMap($lang, $id)
    {
        // return $id;
        $data = $this->tiangRepository->getRecoreds($id);
        // return $data->jenis_tiang;

        return $data ? view('Tiang.edit-form', ['data' => $data,'disabled' => true]) : abort(404);
    }


    public function editMapStore(Request $request, $language,  $id)
    {
        //
        try {
            //  return $request->abc_span;
            //code...
            $destinationPath = 'assets/images/tiang/';
            $data = Tiang::find($id);
            foreach ($request->all() as $mainkey => $mainvalue) {
                if (is_array($mainvalue)) {
                    $json = json_decode($data[$mainkey], true) ?? []; // Decode existing JSON or create an empty array if not exists

                    foreach ($mainvalue as $key => $file) {
                        if (is_a($file, 'Illuminate\Http\UploadedFile') && $file->isValid()) {
                            $uploadedFile = $file;
                            $img_ext = $uploadedFile->getClientOriginalExtension();
                            $filename = $key . '-' . strtotime(now()) . '.' . $img_ext;
                            $uploadedFile->move($destinationPath, $filename);
                            $json[$key] = $destinationPath . $filename;
                        }
                    }

                    $data[$mainkey] = json_encode($json);
                } else {
                    if (is_a($mainvalue, 'Illuminate\Http\UploadedFile') && $mainvalue->isValid()) {
                        $uploadedFile = $mainvalue;
                        $img_ext = $uploadedFile->getClientOriginalExtension();
                        $filename = $mainkey . '-' . strtotime(now()) . '.' . $img_ext;
                        $uploadedFile->move($destinationPath, $filename);
                        $data[$mainkey] = $destinationPath . $filename;
                    }
                }
            }

            $data->ba = $request->ba;
            $data->fp_name = $request->fp_name;
            $user = Auth::user()->id;
            if ($data->qa_status == '') {
                $data->qa_status = 'pending';
            }
            $data->updated_by = $user;
            $data->fp_road = $request->fp_road;
            $data->section_from = $request->section_from;
            $data->section_to = $request->section_to;
            $data->tiang_no = $request->tiang_no;
            $data->talian_utama = $request->talian_utama;
            $data->talian_utama_connection = $request->talian_utama_connection;
            $data->size_tiang = $request->size_tiang;
            $data->jenis_tiang = $request->jenis_tiang;
            $data->abc_span = $request->has('abc_span') ? json_encode($request->abc_span) : null;
            $data->pvc_span = $request->has('pvc_span') ? json_encode($request->pvc_span) : null;
            $data->bare_span = $request->has('bare_span') ? json_encode($request->bare_span) : null;

            $defectsKeys = [];
            $defectsKeys['tiang_defect'] = ['cracked', 'leaning', 'dim', 'creepers', 'other'];
            $defectsKeys['talian_defect'] = ['joint', 'need_rentis', 'ground', 'other'];
            $defectsKeys['umbang_defect'] = ['breaking', 'creepers', 'cracked', 'stay_palte', 'other'];
            $defectsKeys['ipc_defect'] = ['burn', 'other'];
            $defectsKeys['blackbox_defect'] = ['cracked', 'other'];
            $defectsKeys['jumper'] = ['sleeve', 'burn', 'other'];
            $defectsKeys['kilat_defect'] = ['broken', 'other'];
            $defectsKeys['servis_defect'] = ['roof', 'won_piece', 'other'];
            $defectsKeys['pembumian_defect'] = ['netural', 'other'];
            $defectsKeys['bekalan_dua_defect'] = ['damage', 'other'];
            $defectsKeys['kaki_lima_defect'] = ['date_wire', 'burn', 'other'];
            $defectsKeys['tapak_condition'] = ['road', 'side_walk', 'vehicle_entry'];
            $defectsKeys['kawasan'] = ['road', 'bend', 'forest', 'other'];

            $total_defects = 0;
            foreach ($defectsKeys as $key => $defect) {
                $def = [];
                $arr = [];

                foreach ($defect as $item) {
                    if ($request->has("$key.$item")) {
                        $def[$item] = true;
                        $total_defects++;
                    } else {
                        $def[$item] = false;
                    }
                }


                if ($key != 'tapak_condition') {
                    $def['other_input'] = $request->{"$key.other_input"};
                }
                $data->{$key} = json_encode($def);

            }

            $request->arus_pada_tiang == 'Yes' ? $total_defects++ : '';

            $data->total_defects = $total_defects;
            // return $data;
            $data->jarak_kelegaan = $request->jarak_kelegaan;

            $data->talian_spec = $request->talian_spec;

            $data->arus_pada_tiang = $request->arus_pada_tiang;

            $data->update();

            return view('components.map-messages',['id'=>$id,'success'=>true , 'url'=>'tiang-talian-vt-and-vr'])
                ->with('success', 'Form Update');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return view('components.map-messages',['id'=>$id,'success'=>false , 'url'=>'tiang-talian-vt-and-vr'])

                ->with('failed', 'Form Update Failed');
        }
    }

    public function seacrh($lang ,  $q)
    {

        $ba = \Illuminate\Support\Facades\Auth::user()->ba;

        $data = Tiang::where('ba', 'LIKE', '%' . $ba . '%')->where('tiang_no' , 'LIKE' , '%' . $q . '%')->select('tiang_no')->limit(10)->get();

        return response()->json($data, 200);
    }

    public function seacrhCoordinated($lang , $name)
    {
        $name = urldecode($name);
        $data = Tiang::where('tiang_no' ,$name )->select('tiang_no', \DB::raw('ST_X(geom) as x'),\DB::raw('ST_Y(geom) as y'),)->first();

        return response()->json($data, 200);
    }
}
