<?php

namespace App\Http\Controllers\web\adminDashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\Patroling;
use App\Models\ThirdPartyDiging;
use App\Traits\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GraphCounts extends Controller
{
    //
    use Filter;

    
    function patrol_graph(Request $request)
    {
        $ba = Auth::user()->ba;
        if ($ba == ''  && $request->ba != 'null') {
                $ba = $request->ba;
               // return $ba;
        }

      $data['patrolling']       = $this->getGraphCount('patroling' , 'vist_date' , 'km' , $ba , $request );
      $data['substation']       = $this->getGraphCount('tbl_substation' , 'visit_date' , 'total_defects' , $ba, $request);
      $data['feeder_pillar']    = $this->getGraphCount('tbl_feeder_pillar' , 'visit_date' , 'total_defects' , $ba, $request );
      $data['link_box']         = $this->getGraphCount('tbl_link_box' , 'visit_date' , 'total_defects', $ba , $request );
      $data['cable_bridge']     = $this->getGraphCount('tbl_cable_bridge' , 'visit_date' , 'total_defects', $ba , $request );
      $data['tiang']            = $this->getGraphCount('tbl_savr' , 'review_date' , 'total_defects', $ba , $request);

      $data['suryed_substation']       = $this->totalGraphCount('tbl_substation' , $ba ,'visit_date' , $request);
      $data['suryed_feeder_pillar']    = $this->totalGraphCount('tbl_feeder_pillar' , $ba ,'visit_date' , $request );
      $data['suryed_link_box']         = $this->totalGraphCount('tbl_link_box', $ba ,'visit_date' , $request );
      $data['suryed_cable_bridge']     = $this->totalGraphCount('tbl_cable_bridge' , $ba ,'visit_date' , $request);
      $data['suryed_tiang']            = $this->totalGraphCount('tbl_savr' , $ba ,'review_date' , $request);


      $data['pending_substation']       = $this->getPendingCounts('tbl_substation' , $ba ,'visit_date' , $request);
      $data['pending_feeder_pillar']    = $this->getPendingCounts('tbl_feeder_pillar' , $ba ,'visit_date' , $request );
      $data['pending_link_box']         = $this->getPendingCounts('tbl_link_box', $ba ,'visit_date' , $request );
      $data['pending_cable_bridge']     = $this->getPendingCounts('tbl_cable_bridge' , $ba ,'visit_date' , $request);
      $data['pending_tiang']            = $this->getPendingCounts('tbl_savr' , $ba ,'review_date' , $request);


      return response()->json($data);


    }





   
    
    private function getGraphCount($table , $date , $bar , $ba , $request ){


        if ($bar != 'km') {
           $sbar = DB::raw('sum(total_defects) as bar' );
        }else{
            $sbar = "km as bar";
        }

        // $from_date  = $request->from_date;
        // $to_date    = $request->to_date;
        $query      = DB::table($table)->select('ba', DB::raw("$date::date as visit_date"), $sbar)->whereNotNull($date)
                        ->whereNotNull($bar)
                        ->where($bar, '<>', 0);

        $query =  $this->filter($query , $date , $request);

        if ($bar != 'km') {
            $query->whereNotNull('qa_status') ->where('qa_status', '!=', '') ->where('qa_status', '!=', 'Reject')->groupBy('ba', DB::raw("$date::date"));
        }

        $query->orderBy($date , 'desc');

        return $query->get();
    }

    private function totalGraphCount($table , $ba , $date, $request){


         $from_date  = $request->from_date;
         $to_date    = $request->to_date;
         $query      = DB::table($table)
                         ->select('ba', DB::raw("$date::date as visit_date"), DB::raw('count(*) as bar' ))
                         ->whereNotNull($date)
                         ->whereNotNull('total_defects')
                         ->where('qa_status', '!=', '')
                         ->where('qa_status', '!=', 'Reject')
                         ->whereNotNull('qa_status');

                         $query =  $this->filter($query , $date , $request);

                        //  if ($ba) {
                        //      $query->where('ba', $ba);
                        //  }

                        //  if ($from_date) {
                        //      $query->where($date, '>=', $from_date);
                        //  }

                        //  if ($to_date) {
                        //      $query->where($date, '<=' , $to_date);
                        //  }
                        //  if (Auth::user()->ba == '') {
                        //    $query->where('qa_status','Accept');
                        //  }


                             $query->groupBy('ba', DB::raw("$date::date"))
                             ->orderBy($date , 'desc');

             return $query->get();


    }


    private function getPendingCounts($table , $ba , $date, $request){

        // $from_date  = $request->from_date;
        // $to_date    = $request->to_date;
        $query      = DB::table($table)
                        ->select('ba', DB::raw("$date::date as visit_date"), DB::raw('count(*) as bar' ))
                        ->whereNotNull($date)
                        ->where('qa_status', '!=', '')
                        ->where('qa_status', '!=', 'Reject')

                        ->whereNotNull('total_defects');

                       $query =  $this->filter($query , $date , $request);


                        // if ($ba) {
                        //     $query->where('ba', $ba);
                        // }

                        // if ($from_date) {
                        //     $query->where($date, '>=', $from_date);
                        // }

                        // if ($to_date) {
                        //     $query->where($date, '<=' , $to_date);
                        // }
                        
                          $query->where('qa_status','pending');
                        


                            $query->groupBy('ba', DB::raw("$date::date"))
                            ->orderBy($date , 'desc');

            return $query->get();

        
    }

}
