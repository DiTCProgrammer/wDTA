<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Excel;

class MaatwebsiteController extends Controller {

    public function index() {

        $data = array(
            array('DiTC Time Attendance Report ( Summary )'),
            array('Period: xxxxx Select Date Report: xxxx-xx-xx to xxxx-xx-xx'),
            array('Year: xxxx Company: xxxxxxxxxxxxx'),
            array('Exported on ' . date('Y-m-d') . ' Address: xxxxxx Tel: xxx-xxx-xxxx Fax: xxx-xxx-xxxx'),
            array('', ''),
            array('ลำดับ', 'รหัส', 'ชื่อ', 'นามสกุล', 'ค่าแรง', 'ค่าเทคนิค', 'วันทำงานปกติ', 'วันหยุดสัปดาห์', 'วันหยุดนักขัต', 'OT1', 'OT2', 'OT3', 'OT4', 'รวมเงินเดือน', 'รวมค่าเทคนิค', 'OT1', 'OT2', 'OT3', 'OT4', 'สายนาที', 'สายยอดเงิน')
        );
        $data2 = array(
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd'),
            array('asdasdasd', 'asdasdasdasd')
        );

//        foreach ($data2 as $value) {
//            print_r($value);
//        }
//        exit();
        
        Excel::create('Summary_' . date('Y-m-d'), function($excel) use($data,$data2) {
            
            $excel->sheet('First sheet', function($sheet) use($data,$data2) {
                

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->setPageMargin(array(
                    0.46, 0.30, 0.30, 0.46
                ));
                $sheet->mergeCells('A0:U0')->setFontSize(14)->cell(function($cells) {
                    $sheet->setAllBorders('none');
                });
                $sheet->mergeCells('A1:U1')->setFontSize(14)->cell(function($cells) {
                    $sheet->setAllBorders('none');
                });
                $sheet->mergeCells('A2:U2')->setFontSize(14)->cell(function($cells) {
                    $sheet->setAllBorders('none');
                });
                $sheet->mergeCells('A3:U3')->setFontSize(14)->cell(function($cells) {
                    $sheet->setAllBorders('none');
                });
                $sheet->mergeCells('A4:U4')->setFontSize(14)->cell(function($cells) {
                    $sheet->setAllBorders('none');
                });
                $sheet->mergeCells('A5:U5')->setFontSize(14)->cell(function($cells) {
                    $sheet->setAllBorders('none');
                });

                $sheet->setFontSize(14)->setAllBorders('thin')->cells('A6:U6', function($cells) {
                    $cells->setBackground('#0099CC');
                    $cells->setAlignment('center');
                })->setrowsToRepeatAtTop(array(6,6));
                
                foreach($data2 as $val){
                    $sheet->appendRow($val);
                }
                
                $sheet->setAutoSize(false);
                $sheet->setfitToWidth(true);
                $sheet->setfitToHeight(false);
                $sheet->setFontSize(14);
                $sheet->setAllBorders('thin');
                $sheet->setOrientation('landscape');
            });

            // Our second sheet
            $excel->sheet('Second sheet', function($sheet) {
                
            });
        })->download('xls');
    }

}
