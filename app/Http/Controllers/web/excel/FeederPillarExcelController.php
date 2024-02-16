<?php

namespace App\Http\Controllers\web\excel;

use App\Http\Controllers\Controller;
use App\Models\FeederPillar;
use App\Traits\Filter;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeederPillarExcelController extends Controller
{
    use Filter;
    //
    public function generateFeederPillarExcel(Request $req)
    {
        try{
            if ($req->filled('defects')) {

                $getIds = DB::table('feeder_pillar_all_defects');
        
                foreach($req->defects as $res){
        
                    $getIds->orWhere($res,'Yes');
               }
        
                $ids = $getIds->pluck('id');
            }

            $result = FeederPillar::query();

            if ($req->filled('defects')) {
                $result->whereIn('id',$ids);
            }
            $result = $this->filter($result , 'visit_date',$req);



            $result = $result->select('*', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();


            if ($result) {
                $excelFile = public_path('assets/excel-template/feeder-pillar.xlsx');

                $spreadsheet = IOFactory::load($excelFile);

                $worksheet = $spreadsheet->getActiveSheet();

                $i = 3;
                foreach ($result as $rec) 
                {
                    $worksheet->setCellValue('A' . $i, $rec->id);
                    $worksheet->setCellValue('B' . $i, $rec->zone);
                    $worksheet->setCellValue('C' . $i, $rec->ba);
                    $worksheet->setCellValue('D' . $i, $rec->team);
                    $worksheet->setCellValue('E' . $i, date('Y-m-d', strtotime($rec->visit_date)) );
                    $worksheet->setCellValue('F' . $i, date('H:i:s', strtotime($rec->patrol_time)));
                    $worksheet->setCellValue('G' . $i, $rec->feeder_involved);
                    $worksheet->setCellValue('H' . $i, $rec->area);
                    $worksheet->setCellValue('I' . $i, $rec->size);
                    $worksheet->setCellValue('J' . $i, $rec->coordinate);
                    // $worksheet->setCellValue('K' . $i, $rec->paint_status);
                    $worksheet->setCellValue('L' . $i, $rec->guard_status);

                    if ($rec->gate_status) {
                        $gate_status = json_decode($rec->gate_status);
                        $worksheet->setCellValue('M' . $i, substaionCheckBox('unlocked', $gate_status ) == 'checked' ? 'yes' : 'no' );
                        $worksheet->setCellValue('N' . $i, substaionCheckBox('demaged', $gate_status ) == 'checked' ? 'yes' : 'no' );
                        $worksheet->setCellValue('O' . $i, substaionCheckBox('other', $gate_status ) == 'checked' ? 'yes' : 'no' );


                    }
                    // $worksheet->setCellValue('K' . $i, $rec->gate_status);
                    $worksheet->setCellValue('P' . $i, $rec->vandalism_status);
                    $worksheet->setCellValue('Q' . $i, $rec->leaning_staus);
                    $worksheet->setCellValue('R' . $i, $rec->rust_status);
                    $worksheet->setCellValue('S' . $i, $rec->paint_status);
                    $worksheet->setCellValue('T' . $i, $rec->advertise_poster_status);

                    $worksheet->setCellValue('U' . $i, 'http://121.121.232.53:8090/'.$rec->feeder_pillar_image_1
                    .' , http://121.121.232.53:8090/'.$rec->feeder_pillar_image_2
                    .' , http://121.121.232.53:8090/'.$rec->image_name_plate
                    .' , http://121.121.232.53:8090/'.$rec->image_gate
                    .' , http://121.121.232.53:8090/'.$rec->image_gate_2
                    .' , http://121.121.232.53:8090/'.$rec->image_vandalism
                    .' , http://121.121.232.53:8090/'.$rec->image_vandalism_2
                    .' , http://121.121.232.53:8090/'.$rec->image_leaning
                    .' , http://121.121.232.53:8090/'.$rec->image_leaning_2
                    .' , http://121.121.232.53:8090/'.$rec->image_rust
                    .' , http://121.121.232.53:8090/'.$rec->image_rust_2
                    .' , http://121.121.232.53:8090/'.$rec->images_advertise_poster
                    .' , http://121.121.232.53:8090/'.$rec->images_advertise_poster_2
                    .' , http://121.121.232.53:8090/'.$rec->image_advertisement_after_1
                    .' , http://121.121.232.53:8090/'.$rec->image_advertisement_after_2
                    .' , http://121.121.232.53:8090/'.$rec->other_image);
                    
                    $i++;
                }
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            $writer->save(public_path('assets/updated-excels/') . 'qr-feeder-pillar.xlsx');
           // ob_end_clean();
            return response()->download(public_path('assets/updated-excels/'). 'qr-feeder-pillar.xlsx');
            } else {
                return redirect()
                    ->back()
                    ->with('failed', 'No records found ');
            }
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('failed', 'Request Failed');
        }
    }
}
