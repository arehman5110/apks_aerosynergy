<?php

namespace App\Http\Controllers\web\excel;

use App\Http\Controllers\Controller;
use App\Models\LinkBox;
use App\Traits\Filter;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LinkBoxExcelController extends Controller
{
    //

    use Filter;
    public function generateLinkBoxExcel(Request $req){
        try{ 
            if ($req->filled('defects')) {

                $getIds = DB::table('link_box_all_defects');
        
                foreach($req->defects as $res){
        
                    $getIds->orWhere($res,'Yes');
               }
        
                $ids = $getIds->pluck('id');
            }
            
        $result = LinkBox::query();
        if ($req->filled('defects')) {
            $result->whereIn('id',$ids);
        }
        $result = $this->filter($result , 'visit_date',$req);



        $result = $result->select('*', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();

         
        if ($result) {
                $excelFile = public_path('assets/excel-template/link-box.xlsx');

                $spreadsheet = IOFactory::load($excelFile);

                $worksheet = $spreadsheet->getActiveSheet();

                $i = 4;
                foreach ($result as $rec) {
                    $worksheet->setCellValue('A' . $i, $i - 3);
                    $worksheet->setCellValue('B' . $i, $rec->zone);
                    $worksheet->setCellValue('C' . $i, $rec->ba);
                    $worksheet->setCellValue('D' . $i, $rec->team);
                    $worksheet->setCellValue('E' . $i, date('Y-m-d', strtotime($rec->visit_date)) );
                    $worksheet->setCellValue('F' . $i, date('H:i:s', strtotime($rec->patrol_time)) );
                    $worksheet->setCellValue('G' . $i, $rec->feeder_involved);
                    $worksheet->setCellValue('H' . $i, $rec->aera);
                    $worksheet->setCellValue('I' . $i, $rec->start_date);
                    $worksheet->setCellValue('J' . $i, $rec->end_date);
                    $worksheet->setCellValue('K' . $i, $rec->type);
                    $worksheet->setCellValue('L' . $i, $rec->coordinate);
                    $worksheet->setCellValue('M' . $i, $rec->gate_status);
                    $worksheet->setCellValue('N' . $i, $rec->cover_status);
                    $worksheet->setCellValue('O' . $i, $rec->vandalism_status);
                    $worksheet->setCellValue('P' . $i, $rec->leaning_staus);
                    $worksheet->setCellValue('Q' . $i, $rec->rust_status);
                    $worksheet->setCellValue('R' . $i, $rec->paint_status);
                    $worksheet->setCellValue('S' . $i, $rec->advertise_poster_status);
                    $worksheet->setCellValue('T' . $i, $rec->bushes_status);
                    
                    $i++;
                }

                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

                $filename = 'qr-link-box'.rand(2,10000).'.xlsx';
                $writer->save(public_path('assets/updated-excels/') . $filename);
                return response()->download(public_path('assets/updated-excels/') . $filename)->deleteFileAfterSend(true);

                
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
