<?php
namespace App\Http\Controllers\Absence;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Absence;
use App;
use Auth;
use DB;
use Session;
use Excel;

class ExportSampleController extends Controller {
    
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
            array('ID','Employee Code', 'Department ID', 'Status ID', 'Status Name', 'Group')
        ); 
        $dataHead2 = array(
            array('ID','Employee Code', 'Department ID', 'Name')
        ); 
        $dataHead3 = array(
            array('Status ID','Status Name')
        ); 
        
        $data1 = $this->conModel()->getSample();
        $data2 = $this->conModel()->getEmployee();
        $data3 = $this->conModel()->getAbsence();
        
        $name = date('YmdHis');
        
        Excel::create($name, function($excel) use($dataHead1, $dataHead2, $dataHead3, $data1, $data2, $data3) {

                // Our first sheet
                $excel->sheet('Sample', function($sheet) use($dataHead1, $data1) {

                    $sheet->fromArray($dataHead1, null, 'A1', false, false);
                    $sheet->setFontFamily('Tahoma');
                    $sheet->setFontSize(11);
                    
                    if ($data) {
                        foreach ($data as $val) {
                            $sheet->appendRow($val);
                        }
                    }
                    
                });
                $excel->sheet('Employee', function($sheet) use($dataHead2, $data2) {

                    $sheet->fromArray($dataHead1, null, 'A1', false, false);
                    $sheet->setFontFamily('Tahoma');
                    $sheet->setFontSize(11);
                    
                    if ($data) {
                        foreach ($data as $val) {
                            $sheet->appendRow($val);
                        }
                    }
                    
                });
                $excel->sheet('ListAbsence', function($sheet) use($dataHead3, $data3) {

                    $sheet->fromArray($dataHead1, null, 'A1', false, false);
                    $sheet->setFontFamily('Tahoma');
                    $sheet->setFontSize(11);
                    
                    if ($data) {
                        foreach ($data as $val) {
                            $sheet->appendRow($val);
                        }
                    }
                    
                });
        
        })->export('xls');
        
    }

}
