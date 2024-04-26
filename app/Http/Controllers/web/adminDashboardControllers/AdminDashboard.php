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

        if ( $request->filled('ba_name') && $request->ba_name != 'null'   ) {
                $bas = [];
                $bas = [$request->ba_name];
        }

        $data = [];
        $sum = [];
        $allPending = 0;
        $allSurvey = 0;

        foreach ($bas as $ba)
        {
            $request['ba'] = $ba;
            $count = [];
            $count['ba'] = $ba;
            $totalPending = 0;
            $totalsurvey = 0;

            foreach ($tables as $tableKey => $tableName) {
                $column = ($tableKey == 'tiang') ? 'review_date' : 'visit_date';

                // Clone the original query for each table
                $query = $this->filter(DB::table($tableName), $column, $request)->whereNotNull('qa_status');

                $total   = clone $query;
                $pending  = clone $query;
                $total = $total->count();
                $pending = $pending->where('qa_status', '!=',  'pending')->count();

                // Initialize sum for the table if it's not set
                if (!isset($sum[$tableKey])) {
                    $sum[$tableKey] = [
                        'pending' => 0,
                        'surveyed' => 0,
                    ];
                }

                // Update sum for the table
                $sum[$tableKey]['pending'] += $pending;
                $sum[$tableKey]['surveyed'] += $total;

                $totalPending += $pending;
                $totalsurvey += $total;
                $allPending += $pending;
                $allSurvey += $total;

                // Store count for the table
                $count[$tableKey] =  $pending. ' / ' .  $total;
            }
                $count[$ba."_total"] = $totalPending. ' / ' . $totalsurvey;
                $patroling = $this->filterWithOutAccpet(DB::table('patroling') , 'vist_date' ,$request);


                $count['patroling'] = $patroling->sum('km');

                if (!isset($sum['patroling'])) {
                    $sum['patroling'] = 0;
                }

                $sum['patroling'] += $count['patroling'];
                $data[] = $count;
        }
        $sum['total'] = $allSurvey;
        $sum['pending'] = $allPending;


        return response()->json(['data'=>$data , 'sum'=>$sum] );
    }


    public function getUsersByTeam(Request $req)
    {
        $user = User::where('id_team', $req->team)->whereNotIn('user_type', ['aerosynergy', 'tnb', 'TeamLead'])
        ->orWhere('user_type' , null)->where('id_team', $req->team);
        if ($req->filled('ba_name') && $req->ba_name != 'null') {
           $user->where('ba' , $req->ba_name);
        }

        $user = $user->select('id' , 'name')->get();

        return response()->json(['data'=>$user]);
    }

//     public function getStatsByUsers(Request $request)
// {
//     // Define tables and their respective columns for filtering
//     $tables = [
//         'substations' => 'created_by',
//         'feederPillar' => 'created_by',
//         // Define other tables and their filtering columns here
//     ];

//     // Retrieve users with eager loading of necessary data
//     $usersQuery = User::where('is_admin', false)
//                       ->whereHas('userType', function($query) use ($request) {
//                           $query->whereNotIn('user_type', ['aerosynergy', 'tnb', 'TeamLead'])
//                                 ->orWhereNull('user_type');
//                       })
//                       ->withCount(array_map(function($column) {
//                           return function ($query) use ($column) {
//                               $query->where($column, '=', DB::raw('users.name')); // Filter by user name
//                               // Apply additional filters if needed
//                               // Example: $query->where('visit_date', $request->visit_date);
//                           };
//                       }, $tables));

//     if ($request->filled('user') && $request->user != 'null') {
//         $usersQuery->where('name', $request->user);
//     }

//     if ($request->filled('ba_name') && $request->ba_name != 'null') {
//         $usersQuery->where('ba', $request->ba_name);
//     }

//     if ($request->filled('team') && $request->team != 'null') {
//         $usersQuery->where('id_team', $request->team);
//     }

//     $users = $usersQuery->select('name')->get();

//     // Calculate total counts for each table
//     $tableTotals = [];

//     foreach ($users as $user) {
//         $tableCounts = [];

//         foreach ($tables as $table => $column) {
//             $tableCounts[$table] = $user->{$table.'_count'} ?? 0;
//         }

//         $tableTotals[$user->name] = $tableCounts;
//     }

//     return $tableTotals;
// }



    public function getStatsByUsers(Request $request)
    {
        $users = User::where('is_admin', false);

        if ($request->filled('user') && $request->user != 'null') {

            $users->where('name',$request->user);
        }else{
            $users->whereNotIn('user_type', ['aerosynergy', 'tnb', 'TeamLead'])->orWhere('user_type' , null);
            if ($request->filled('ba_name') && $request->ba_name != 'null') {
                $users->where('ba',$request->ba_name);
            }
            if ($request->filled('team') && $request->team != 'null') {
                $users->where('id_team',$request->team);
            }
        }

        $users = $users->select('name')->get();

        $tables = [
                    'substation' => 'tbl_substation',
                    'feeder_pillar' => 'tbl_feeder_pillar',
                    'tiang' => 'tbl_savr',
                    'link_box' => 'tbl_link_box',
                    'cable_bridge' => 'tbl_cable_bridge',
                ];

        $sum = [];
        $tableTotal = [];
        $tableTotalCount = [];

        foreach ($tables as $tableKey => $tableName) {


            $column = ($tableKey == 'tiang') ? 'review_date' : 'visit_date';
            $query = '';
            $query = $this->filter(DB::table($tableName), $column, $request)->whereNotNull('qa_status');

            $count   = clone $query;
            $accept   = clone $query;

            $sum[$tableKey] = $count->select(DB::raw('count(*) as total') , 'created_by')->groupBy('created_by')->get();
            $sum['accept_'.$tableKey] = $accept->where('qa_status' , 'Accept')->select(DB::raw('count(*) as total') , 'created_by')->groupBy('created_by')->get();


        }

        $patroling = $this->filterWithOutAccpet(DB::table('patroling') , 'vist_date' ,$request)->select(DB::raw('sum(km) as total') , 'created_by')->groupBy('created_by')->get();




        $columnCount = [];
        $columnTotal = [];



        foreach ($users as $user) {


            $arr = [];
            $arr['name'] = $user->name;

            // Initialize arrays to hold the total counts for each table

            $columnCount['accept'] = 0;
            $columnCount['total'] = 0;

            foreach ($tables as $tableKey => $tableName) {
                $sumSubstation = $sum[$tableKey]->where('created_by', $user->name)->first();
                $sumAcceptSubstation = $sum['accept_'.$tableKey]->where('created_by', $user->name)->first();

                $substationTotal = $sumSubstation ? $sumSubstation->total : 0;
                $acceptSubstationTotal = $sumAcceptSubstation ? $sumAcceptSubstation->total : 0;

                $arr[$tableKey] = $acceptSubstationTotal . '/' .  $substationTotal;

                $columnCount['accept'] +=$acceptSubstationTotal;
                $columnCount['total'] += $substationTotal;

                if (!isset($columnTotal[$tableKey])) {
                    $columnTotal[$tableKey] = 0;
                    $columnTotal[$tableKey.'_accept'] = 0;
                }

                $columnTotal[$tableKey] += $substationTotal;
                $columnTotal[$tableKey.'_accept'] += $acceptSubstationTotal;


            }

            $patrolSum = $patroling->where('created_by', $user->name)->first();
            $patrolTotal = $patrolSum ? $patrolSum->total : 0;

            $arr['patroling'] = $patrolTotal;
            if (!isset($columnTotal['patroling'])) {
                $columnTotal['patroling'] = 0;
            }

            $columnTotal['patroling'] += (float)$patrolTotal;


            // Add sums from other tables to the $arr
            $arr['total'] = $columnCount['accept'] . '/' . $columnCount['total'];

            $tableTotal[] = $arr;
        }
        // $tableTotal['tableTotal'] = $columnTotal;

        return response()->json(['data'=>$tableTotal , 'tableTotal'=>$columnTotal] );

        return $tableTotal;



        return $tableTotal;


    }


    // GET COUNTS BY USER NAME
    public function getStatssByUsers(Request $request)
    {
         $users = User::where('is_admin', false);


        if ($request->filled('user') && $request->user != 'null') {

        $users ->where('name',$request->user);
        }else{
            $users->whereNotIn('user_type', ['aerosynergy', 'tnb', 'TeamLead'])->orWhere('user_type' , null);
            if ($request->filled('ba_name') && $request->ba_name != 'null') {
                $users->where('ba',$request->ba_name);
            }
            if ($request->filled('team') && $request->team != 'null') {
                $users->where('id_team',$request->team);
            }

        }
       $users = $users->select('name')
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
        $tableTotal = [];
        $tableTotalCount = [];



        foreach($users as $user){
            // return $user;

            $arr = [];
            $arr['name'] =$user->name;
            $rowcount = ['accept' => 0 , 'total'=>0];

                foreach ($tables as $tableKey => $tableName) {
                    $column = ($tableKey == 'tiang') ? 'review_date' : 'visit_date';

                    // Clone the original query for each table
                    $query = $this->filter(DB::table($tableName), $column, $request)->whereNotNull('qa_status')->where('created_by' , $user->name);

                    $count   = clone $query;
                    $accept   = clone $query;

                    $accept = $accept->where('qa_status' ,'!=' , 'pending')->count();
                    $userCount = $count->count();

                    // Initialize sum for the table if it's not set


                    // Push the new key-value pair into the nested array
                    $arr[$tableKey] = $accept . '/' .   $userCount;
                    if (!isset($tableTotal[$tableKey])) {
                        $tableTotal[$tableKey] = 0;
                        $tableTotal[$tableKey.'_accept'] = 0;
                    }

                    $rowcount['accept'] += $accept ;
                    $rowcount['total'] += $userCount ;

                    $tableTotal[$tableKey] += $userCount;
                    $tableTotal[$tableKey.'_accept'] += $accept;



                }
                $arr['total'] = $rowcount['accept'].' / '.$rowcount['total'];




                $patroling = $this->filterWithOutAccpet(DB::table('patroling') , 'vist_date' ,$request)->where('created_by' , $user->name);


                $countPatroling = $patroling->sum('km');
                $arr['patroling'] = $countPatroling;
                $sum[] = $arr;
                if (!isset($tableTotal['patroling'])) {
                    $tableTotal['patroling'] = 0;

                }
                $tableTotal['patroling'] += $countPatroling;
        }
        return response()->json(['data'=>$sum , 'tableTotal'=>$tableTotal] );

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
