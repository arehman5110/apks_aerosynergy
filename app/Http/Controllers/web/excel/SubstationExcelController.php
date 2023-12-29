<?php

namespace App\Http\Controllers\web\excel;

use App\Http\Controllers\Controller;
use App\Models\Substation;
use App\Traits\Filter;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubstationExcelController extends Controller
{
    //
    use Filter;


    public function generateSubstationExcel(Request $req)
    {
        // return $req;


        try {
 
//  return $req;
            $result = Substation::query();

            $result = $this->filter($result , 'visit_date',$req);



            $result = $result->whereNotNull('visit_date')->select('*', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
 
                // return $result; 
            if ($result) {
                $excelFile = public_path('assets/excel-template/substation.xlsx');

                $spreadsheet = IOFactory::load($excelFile);

                $worksheet = $spreadsheet->getActiveSheet();

                $i = 3;
                foreach ($result as $rec) {

                    $worksheet->setCellValue('A' . $i, $i - 2);
                    $worksheet->setCellValue('B' . $i, $rec->zone);
                    $worksheet->setCellValue('C' . $i, $rec->ba);
                    $worksheet->setCellValue('D' . $i, $rec->team);
                    $worksheet->setCellValue('E' . $i,  $rec->visit_date != '' ?date('Y-m-d', strtotime($rec->visit_date)) : '');
                    $worksheet->setCellValue('F' . $i,  $rec->patrol_time != '' ?date('H:i:s', strtotime($rec->patrol_time)) : '');
                    $worksheet->setCellValue('G' . $i, $rec->fl);
                    $worksheet->setCellValue('H' . $i, $rec->voltage);
                    $worksheet->setCellValue('I' . $i, $rec->name);
                    $worksheet->setCellValue('J' . $i, $rec->type);
                    $worksheet->setCellValue('K' . $i, number_format( $rec->y, 2) .",". number_format( $rec->x , 2));
                    if ($rec->gate_status) {
                        $gate_status = json_decode($rec->gate_status);
                        $worksheet->setCellValue('L' . $i, substaionCheckBox('unlocked', $gate_status ) == 'checked' ? 'yes' : 'no' );
                        $worksheet->setCellValue('M' . $i, substaionCheckBox('demaged', $gate_status ) == 'checked' ? 'yes' : 'no' );
                        $worksheet->setCellValue('N' . $i, substaionCheckBox('other', $gate_status ) == 'checked' ? 'yes' : 'no' );


                    }
                    $worksheet->setCellValue('O' . $i, $rec->grass_status);
                    $worksheet->setCellValue('P' . $i, $rec->tree_branches_status);


                    if ($rec->building_status) {
                        $building_status = json_decode($rec->building_status);
                        $worksheet->setCellValue('Q' . $i, substaionCheckBox('broken_roof', $building_status ) == 'checked' ? 'yes' : 'no' );
                          $worksheet->setCellValue('R' . $i, substaionCheckBox('broken_gutter', $building_status ) == 'checked' ? 'yes' : 'no' );
                         $worksheet->setCellValue('S' . $i,  substaionCheckBox('broken_base', $building_status ) == 'checked' ? 'yes' : 'no' );
                         $worksheet->setCellValue('T' . $i,  substaionCheckBox('other', $building_status ) == 'checked' ? 'yes' : 'no' );



                    }
                    // $worksheet->setCellValue('O' . $i, $rec->building_status);
                    $worksheet->setCellValue('U' . $i, $rec->advertise_poster_status);
                    $worksheet->setCellValue('V' . $i, $rec->total_defects);


                    $i++;


                }

                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

                $writer->save(public_path('assets/updated-excels/') . 'substation.xlsx');
                //  ob_end_clean();
                return response()->download(public_path('assets/updated-excels/') . 'substation.xlsx');
            } else {
                return redirect()
                    ->back()
                    ->with('failed', 'No records found ');
            }
        } catch (\Throwable $th) {
            //   return $th->getMessage();
            return redirect()
                ->back()
                ->with('failed', 'Request Failed '. $th->getMessage());
        }
    }
}
