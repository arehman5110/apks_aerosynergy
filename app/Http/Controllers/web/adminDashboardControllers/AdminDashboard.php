<?php

namespace App\Http\Controllers\web\adminDashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\Patroling;
use App\Models\Team;
use App\Models\ThirdPartyDiging;
use App\Models\User;
use App\Traits\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Controller
{
    use Filter;
    //


    public function index(Request $request){
        return view('admin-dashboard',['teams'=>Team::all()]);   
    }


    public function getAllCounts(Request $request)
    {
        try 
        {
            // $this->filter  is trait  this function taking 3 params (1) model query (2)column name (3) $request that contains  visit_date from-to date nad ba
            // traits return filtered orms and after filtered count

            $tables = [
                'substation' => 'tbl_substation',
                'feeder_pillar' => 'tbl_feeder_pillar',
                'tiang' => 'tbl_savr',
                'link_box' => 'tbl_link_box',
                'cable_bridge' => 'tbl_cable_bridge',
            ];
    
            $data = [];
    
            foreach ($tables as $key => $tableName) 
            {
                $query = DB::table($tableName);

                $column = $key == 'tiang' ? 'review_date' : 'visit_date';
                $query = $this->filter($query, $column, $request);
                
                $count   = clone $query;
                $accept  = clone $query;
                $defect  = clone $query;
                $pending = Clone $query;

                $data[$key.'_accept'] =$accept->where('qa_status','Accept')->count();

                $data[$key] = $count->count(); // Count records
            
                // Sum total_defects
                $data[$key . '_defect'] = $defect->where('total_defects', '>', 0)->sum('total_defects');
                $data[$key.'_pending'] = $pending->where('qa_status','pending')->count();
             
            }
       
                $data['total_km'] = $this->filterWithOutAccpet(Patroling::select(DB::raw('sum(km)')), 'vist_date', $request)->first()->sum;
                $data['total_notice'] = $this->filterWithOutAccpet(ThirdPartyDiging::where('notice', 'yes'), 'survey_date', $request)->count();
                $data['total_supervision'] = $this->filterWithOutAccpet(ThirdPartyDiging::where('supervision', 'yes'), 'survey_date', $request)->count();

                return $data;
 
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('third-party-digging.index', app()->getLocale());
        }
    }





    public function statsTable(Request $request)
    {
        $bas = [
            'RAWANG',
            'KUALA LUMPUR PUSAT',
            'KLANG',
            'KUALA SELANGOR',
            'PELABUHAN KLANG',
            'BANGI',
            'CHERAS',
            'BANTING',
            'PUTRAJAYA & CYBERJAYA',
            'PETALING JAYA',
            'SEPANG',
            'PUCHONG'
        ];

        $tables = [
            'substation' => 'tbl_substation',
            'feeder_pillar' => 'tbl_feeder_pillar',
            'tiang' => 'tbl_savr',
            'link_box' => 'tbl_link_box',
            'cable_bridge' => 'tbl_cable_bridge',
        ];

        if ( $request->ba_name != 'null' ) {
                $bas = [];
                $bas = [$request->ba_name];
        }
        
        $data = [];
        $sum = [];

        foreach ($bas as $ba) 
        {
            $request['ba'] = $ba;
            $count = [];
            $count['ba'] = $ba;
    
            foreach ($tables as $tableKey => $tableName) {
                $column = ($tableKey == 'tiang') ? 'review_date' : 'visit_date';
    
                // Clone the original query for each table
                $query = $this->filter(DB::table($tableName), $column, $request)->whereNotNull('qa_status');

                $accept = $query->count();
                $pending = $query->where('qa_status', '!=',  'pending')->count();
    
                // Initialize sum for the table if it's not set
                if (!isset($sum[$tableKey])) {
                    $sum[$tableKey] = [
                        'pending' => 0,
                        'surveyed' => 0,
                    ];
                }
    
                // Update sum for the table
                $sum[$tableKey]['pending'] += $pending;
                $sum[$tableKey]['surveyed'] += $accept;
    
                // Store count for the table
                $count[$tableKey] =  $pending. ' / ' .  $accept;
            }
    
                $patroling = $this->filterWithOutAccpet(DB::table('patroling') , 'vist_date' ,$request);

                
                $count['patroling'] = $patroling->sum('km');
                
                if (!isset($sum['patroling'])) {
                    $sum['patroling'] = 0;
                }

                $sum['patroling'] += $count['patroling'];
                $data[] = $count;
        }
        return response()->json(['data'=>$data , 'sum'=>$sum] );
    }


    public function getUsersByTeam(Request $req)
    {
        $user = User::where('id_team', $req->team)->whereNotIn('user_type', ['aerosynergy', 'tnb'])
        ->orWhere('users.user_type' , null);
        if ($req->filled('ba_name') && $req->ba_name != 'null') {
           $user->where('ba' , $req->ba_name);
        }
        
    $user = $user->select('id' , 'name')->get();

        return response()->json(['data'=>$user]);
    }



    // GET COUNTS BY USER NAME
    public function getStatsByUsers(Request $request) 
    {
         $users = User::join('tbl_team', 'users.id_team', '=', 'tbl_team.id')
        ->where('users.is_admin', false)
        ->whereNotIn('users.user_type', ['aerosynergy', 'tnb'])
        ->orWhere('users.user_type' , null);
        if ($request->filled('ba_name') && $request->ba_name != 'null') {
            $users->where('users.ba',$request->ba_name);
        }
        if ($request->filled('team') && $request->team != 'null') {
            $users->where('users.id_team',$request->team);
        }
        if ($request->filled('user') && $request->user != 'null') {
            $users->where('users.name',$request->user);
        }
       $users = $users->select('users.name', 'tbl_team.team_name as team_name')
       ->get();
   
    
        $bas = ['RAWANG', 'KUALA LUMPUR PUSAT', 'KLANG', 'KUALA SELANGOR', 'PELABUHAN KLANG', 'BANGI', 'CHERAS',
            'BANTING',
            'PUTRAJAYA & CYBERJAYA',
            'PETALING JAYA',
            'SEPANG',
            'PUCHONG'
        ];

        $tables = [
            'substation' => 'tbl_substation',
            'feeder_pillar' => 'tbl_feeder_pillar',
            'tiang' => 'tbl_savr',
            'link_box' => 'tbl_link_box',
            'cable_bridge' => 'tbl_cable_bridge',
        ];

 
        $sum = [];
 
        foreach($users as $user){
            // return $user;
        
            $arr = [];
            $arr['name'] =$user->name;
        
                foreach ($tables as $tableKey => $tableName) {
                    $column = ($tableKey == 'tiang') ? 'review_date' : 'visit_date';
        
                    // Clone the original query for each table
                    $query = $this->filter(DB::table($tableName), $column, $request)->whereNotNull('qa_status')->where('created_by' , $user->name);

                    $userCount = $query->count();
        
                    // Initialize sum for the table if it's not set
                    
                  
                    // Push the new key-value pair into the nested array
                    $arr[$tableKey] =  $userCount;
                    
                    
                
                    
                }
                
            
    
                $patroling = $this->filterWithOutAccpet(DB::table('patroling') , 'vist_date' ,$request)->where('created_by' , $user->name);

                
                $countPatroling = $patroling->sum('km');
                $arr['patroling'] = $countPatroling;
                $sum[] = $arr;
      
        }
        return response()->json(['data'=>$sum] );
 
    }



























































































































































    // function patrol_graph(Request $request)
    // {
    //     $ba = Auth::user()->ba;
    //     if ($ba == ''  && $request->ba != 'null') {
    //             $ba = $request->ba;
    //            // return $ba;
    //     }
    //     $tables = [
    //         'substation' => 'tbl_substation',
    //         'feeder_pillar' => 'tbl_feeder_pillar',
    //         'tiang' => 'tbl_savr',
    //         'link_box' => 'tbl_link_box',
    //         'cable_bridge' => 'tbl_cable_bridge',
    //     ];


    //      foreach ($tables as $key => $tableName) {

    //         $column = $key == 'tiang' ? 'review_date' : 'visit_date';

    //              $query = DB::table($tableName);
    
    //              $query = $this->filter($query, $column, $request)->whereNotNull('qa_status');


    
      
    //              $data[$key] = $query->groupBy('ba', DB::raw("$column::date"))->orderBy($column , 'desc')->get(); // Count records
    
    //              // Sum total_defects
    //              $data[$key . '_defect'] = $this->totalGraphCount($query , $column);
    
           
    //              $data[$key.'_pending'] = $query->where('qa_status','pending')->groupBy('ba', DB::raw("$column::date"))->orderBy($column , 'desc')->get();
    
    //          }

     

    //   return response()->json($data);


    // }



    //  private function totalGraphCount($query , $column){

    //         return  $query->select('ba', DB::raw("$column::date as visit_date"), DB::raw('sum(total_defects) as bar' ))
    //                         ->where('total_defects', '>', 0)
    //                         ->groupBy('ba', DB::raw("$column::date"))
    //                         ->orderBy($column , 'desc')
    //                         ->get();
    // }



}
