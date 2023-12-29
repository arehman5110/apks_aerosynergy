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

            $result = FeederPillar::query();

            $result = $this->filter($result , 'visit_date',$req);



            $result = $result->whereNotNull('visit_date')->select('*', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();


            if ($result) {
                $excelFile = public_path('assets/excel-template/feeder-pillar.xlsx');

                $spreadsheet = IOFactory::load($excelFile);

                $worksheet = $spreadsheet->getActiveSheet();

                $i = 3;
                foreach ($result as $rec) {
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
                    if ($rec->gate_status) {
                        $gate_status = json_decode($rec->gate_status);
                        $worksheet->setCellValue('K' . $i, substaionCheckBox('unlocked', $gate_status ) == 'checked' ? 'yes' : 'no' );
                        $worksheet->setCellValue('L' . $i, substaionCheckBox('demaged', $gate_status ) == 'checked' ? 'yes' : 'no' );
                        $worksheet->setCellValue('M' . $i, substaionCheckBox('other', $gate_status ) == 'checked' ? 'yes' : 'no' );


                    }
                    // $worksheet->setCellValue('K' . $i, $rec->gate_status);
                    $worksheet->setCellValue('N' . $i, $rec->vandalism_status);
                    $worksheet->setCellValue('O' . $i, $rec->leaning_status);

                    $worksheet->setCellValue('P' . $i, $rec->rust_status);
                    $worksheet->setCellValue('Q' . $i, $rec->advertise_poster_status);


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
