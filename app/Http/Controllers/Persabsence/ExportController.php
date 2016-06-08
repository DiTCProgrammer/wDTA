<?php

namespace App\Http\Controllers\persabsence;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AbsenceImportExport;
use Auth;
use DB;
use Session;
use Excel;

class ExportController extends Controller {

    protected $table = 'data_employee'; //DB Name

    public function __construct() {
        //$this->middleware('adminhr');
        //\Debugbar::disable();
    }

    function conModel() {
        return new AbsenceImportExport;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $dataHead1 = array(
            array('ID', 'Employee Code', 'Department ID', 'DATE', 'Status ID', 'Status Name', 'Group')
        );
        $dataHead2 = array(
            array('ID', 'Employee Code', 'Department ID', 'Name')
        );
        $dataHead3 = array(
            array('Status ID', 'Status Name')
        );

        $data1 = $this->conModel()->getSample();
        $data2 = $this->conModel()->getEmployee();
        $data3 = $this->conModel()->getAbsence();

        foreach ($data1 as $key => $item) {
            $data1r[$key]['id'] = $item->id;
            $data1r[$key]['empcode'] = $item->empcode;
            $data1r[$key]['dept_id'] = $item->dept_id;
            $data1r[$key]['ddate'] = $item->ddate;
            $data1r[$key]['status_id'] = $item->status_id;
            $data1r[$key]['status_name'] = $item->status_name;
            $data1r[$key]['group'] = $item->group;
        }
        
        foreach ($data2 as $key => $item) {
            $data2r[$key]['id'] = $item->id;
            $data2r[$key]['empcode'] = $item->empcode;
            $data2r[$key]['dept_id'] = $item->dept_id;
            $data2r[$key]['name'] = $item->prefix.' '.$item->firstname.' '.$item->lastname;
        }
        
        foreach ($data3 as $key => $item) {
            $data3r[$key]['id'] = $item->id;
            $data3r[$key]['name'] = $item->name;
        }

        $name = date('YmdHis');

        Excel::create($name, function($excel) use($dataHead1, $dataHead2, $dataHead3, $data1r, $data2r, $data3r) {

            // Our first sheet
            $excel->sheet('Sample', function($sheet) use($dataHead1, $data1r) {

                $sheet->fromArray($dataHead1, null, 'A1', false, false);
                $sheet->setFontFamily('Tahoma');
                $sheet->setFontSize(11);
                $i = 2;
                if ($data1r) {
                    foreach ($data1r as $val) {
                        $sheet->appendRow($i, $val);
                        ++$i;
                    }
                }
            });
            $excel->sheet('Employee', function($sheet) use($dataHead2, $data2r) {

                $sheet->fromArray($dataHead2, null, 'A1', false, false);
                $sheet->setFontFamily('Tahoma');
                $sheet->setFontSize(11);

                $i = 2;
                if ($data2r) {
                    foreach ($data2r as $val) {
                        $sheet->appendRow($i, $val);
                        ++$i;
                    }
                }
            });
            $excel->sheet('ListAbsence', function($sheet) use($dataHead3, $data3r) {

                $sheet->fromArray($dataHead3, null, 'A1', false, false);
                $sheet->setFontFamily('Tahoma');
                $sheet->setFontSize(11);

                $i = 2;
                if ($data3r) {
                    foreach ($data3r as $val) {
                        $sheet->appendRow($i, $val);
                        ++$i;
                    }
                }
            });
        })->export('xls');
    }

}
