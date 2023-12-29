<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\CableBridge;
use App\Models\Team;
use App\Traits\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CableBridgeController extends Controller
{
    use Filter;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $ba = $request->filled('ba') ? $request->ba : Auth::user()->ba;
            $result = CableBridge::query();

           $result = $this->filter($result , 'visit_date',$request);

            $result->when(true, function ($query) {
                return $query->select('id', 'ba', 'zone', 'team', 'visit_date', 'total_defects', 'qa_status','qa_status' , 'reject_remarks');
            });

            return datatables()
                ->of($result->get())
                ->addColumn('cable_bridge_id', function ($row) {
                    return 'CB-' . $row->id;
                })
                // ->addColumn('qa_status_action', function ($row) {
                    
                //     if ($row->visit_date != '' && $row->cable_bridge_image_1 != '') {
                //         return "SDfsdfsd";
                //         if ($row->qa_status === 'Accept' || $row->qa_status === 'Reject') {
                //             if ($row->qa_status == 'Accept') {
                //                 return "<span class='badge bg-success'>Accept</span>";
                //             }
                //             return "<span class='badge bg-danger'>Reject</span>";
                //         } else {
                //             return "<div class='d-flex text-center' id='status-$row->id'>
                //                         <a type='button' class='btn btn-sm btn-success' onclick='updateQaStatus('Accept',$row->id)'>Accept</a>/
                //                         <a type='button' class='btn btn-sm btn-danger ' onclick='updateQaStatus('Reject',$row->id)'> Reject </a>
                //                     </div>";
                //         }
                //     }
                //     return '';
                // })
                ->make(true);
        }
        return view('cable-bridge.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $team_id = auth()->user()->id_team;
        $team = Team::find($team_id)->team_name;
        return view('cable-bridge.create', ['team' => $team]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $defects = [];
            $defects = ['pipe_staus', 'vandalism_status', 'collapsed_status', 'rust_status', 'bushes_status'];

            $currentDate = Carbon::now()->toDateString();
            $combinedDateTime = $currentDate . ' ' . $request->patrol_time;
            $total_defects = 0;

            $data = new CableBridge();
            $data->zone = $request->zone;
            $data->ba = $request->ba;
            $data->team = $request->team;
            $data->visit_date = $request->visit_date;
            $data->patrol_time = $combinedDateTime;
            $data->feeder_involved = $request->feeder_involved;

            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->qa_status = 'pending';
            $user = Auth::user()->id;

            $data->created_by = $user;
            $data->voltage = $request->voltage;
            $data->coordinate = $request->coordinate;

            foreach ($defects as $value) {
                $data->{$value} = $request->{$value};
                $request->has($value) && $request->{$value} == 'Yes' ? $total_defects++ : '';
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

            $data->geom = DB::raw("ST_GeomFromText('POINT(" . $request->log . ' ' . $request->lat . ")',4326)");

            $data->save();

            return redirect()
                ->route('cable-bridge.index', app()->getLocale())
                ->with('success', 'Form Intserted');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()
                ->route('cable-bridge.index', app()->getLocale())
                ->with('failed', 'Form Intserted Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $id)
    {
        //
        $data = CableBridge::find($id);
        return $data ? view('cable-bridge.show', ['data' => $data, 'disabled' => true]) : abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $id)
    {
        //
        $data = CableBridge::find($id);
        return $data ? view('cable-bridge.edit', ['data' => $data, 'disabled' => false]) : abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $language, $id)
    {
        //

        try {
            $defects = [];
            $defects = ['pipe_staus', 'vandalism_status', 'collapsed_status', 'rust_status', 'bushes_status'];
            $total_defects = 0;
            $currentDate = Carbon::now()->toDateString();
            $combinedDateTime = $currentDate . ' ' . $request->patrol_time;

            $data = CableBridge::find($id);
            $data->zone = $request->zone;
            $data->ba = $request->ba;
            $user = Auth::user()->id;
            if ($data->qa_status == '') {
                $data->qa_status = 'pending';
            }
            $data->updated_by = $user;
            $data->visit_date = $request->visit_date;
            $data->patrol_time = $combinedDateTime;
            $data->feeder_involved = $request->feeder_involved;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->voltage = $request->voltage;
            foreach ($defects as $value) {
                $data->{$value} = $request->{$value};
                $request->has($value) && $request->{$value} == 'Yes' ? $total_defects++ : '';
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

            return redirect()
                ->route('cable-bridge.index', app()->getLocale())
                ->with('success', 'Form Update');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()
                ->route('cable-bridge.index', app()->getLocale())
                ->with('failed', 'Form Intserted Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $id)
    {
        try {
            CableBridge::find($id)->delete();

            return redirect()
                ->route('cable-bridge.index', app()->getLocale())
                ->with('success', 'Recored Removed');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()
                ->route('cable-bridge.index', app()->getLocale())
                ->with('failed', 'Request Failed');
        }
    }

    public function updateQAStatus(Request $req)
    {
        try {
            $qa_data = CableBridge::find($req->id);
            $qa_data->qa_status = $req->status;
            if ($req->status == 'Reject') {
                $qa_data->reject_remarks = $req->reject_remakrs;
            }
            $user = Auth::user()->id;

            $qa_data->updated_by = $user;
            $qa_data->update();

            return redirect()->back();
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Request failed']);
        }
    }
}
