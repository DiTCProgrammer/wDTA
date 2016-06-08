<?php

namespace App\Http\Controllers\Weekend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Weekend;
use Image;
use DB;

class WeekendController extends Controller {

    protected $company = 'config_weekend_company';
    protected $department = 'config_weekend_department';
    protected $data_department = 'data_department';
    
    public function __construct() {
        $this->middleware('adminhrhof');
        \Debugbar::disable();
    }

    public function index() {

        return view('management/weekend/main');
    }

    //*************************************************************** start company **********************************************************
    function Company() {
        $weekend = new Weekend;
        $where = array(['N' => 'state', 'M' => '=', 'W' => 1]);
        $dataWCom = $weekend->getWeekend($this->company, $where);
        $dataTextWCom = array();
        $i = 0;
        foreach ($dataWCom as $row):
            $weekArr = explode(',', $row->weekend);
            $dayinput = '';
            foreach ($weekArr as $x => $weekRow):
                if ($x == 0):
                    $dayinput = $this->DayName($weekRow);
                else:
                    $dayinput = $dayinput . ',' . $this->DayName($weekRow);
                endif;
            endforeach;
            $dataTextWCom[$i]['day'] = $dayinput;
            $dataTextWCom[$i]['id'] = $row->id;
            $dataTextWCom[$i]['year'] = $row->ydate;

            $i++;
        endforeach;
        return view('management/weekend/company/view', ['dataWeek' => $dataTextWCom]);
    }

    public function editCompany($id) {
//        $employee_emp = '';
        $weekend = new Weekend;
        if ($id != null) :
            $where = array(['N' => 'id', 'M' => '=', 'W' => $id]);
            $rowWeekend = $weekend->getWeekend($this->company, $where);
        endif;
        $weekArr = explode(',', $rowWeekend[0]->weekend);
        foreach ($weekArr as $row):
            $arr[$row] = $row;
        endforeach;
        $i = 1;
        while ($i <= 7):
            $day[$i] = '';
            if (!empty($arr[$i])):
                $day[$i] = $arr[$i];
            endif;
            $i++;
        endwhile;

        return view('management/weekend/company/edit', ['Year' => $this->Year(), 'Day' => $this->Day(), 'dataCompany' => $rowWeekend[0], 'dataDay' => $day]);
    }

    public function createCompany() {
        return view('management/weekend/company/create', ['dataWArrYear' => $this->Year(), 'dataDay' => $this->Day()]);
    }

    public function updateCompany(Request $request, $id = null) {

        $this->validate($request, [
            'weekend' => 'required',
            'ydate' => 'required'
        ]);
        $dayinput = '';
        foreach ($request->input('weekend') as $i => $row):
            if ($i == 0):
                $dayinput = $row;
            else:
                $dayinput = $dayinput . ',' . $row;
            endif;
        endforeach;

        $ins_data = ['ydate' => $request->input('ydate'),
            'weekend' => $dayinput,
            'state' => 1
        ];
        $weekend = new Weekend;

        if ($id == null) :
            $weekend->InsertWeekend($ins_data, $this->company);
        else:
            $weekend->UpdateWeekend($ins_data, $this->company, $id);
        endif;
        return redirect('weekend/company');
    }

    public function destroyCompany($id) {
        $weekend = new Weekend;
        $weekend->DestroyWeekend($id, $this->company);
        return redirect('weekend/company');
    }

    //*************************************************************** end company **********************************************************
    //*************************************************************** start department **********************************************************

    function Depertment() {
        $weekend = new Weekend;
        $dataWDep = $weekend->getWeekendDepertment($where = null);
       
        $dataTextWDep = array();
        $i = 0;
//        date('l', strtotime('2016-5-4')) วันเป็นภาษาอังกฤษ
//        date('N', strtotime('2016-5-4'))  เลขประจำวันในสัปดาห์ แบบอังกฤษ เริ่มต้นวันจันทร์(1 จันทร์ – 7อาทิตย์)      
//        echo date('W', strtotime('2016-5-1')) . "<br />";
        foreach ($dataWDep as $row):
//            $weekArr = explode('-', $row->ddate);
//            $dayinput = '';
//            foreach ($weekArr as $x => $weekRow):
//                if ($x == 0):
//                    $dayinput = $this->DayName($weekRow);
//                else:
//                    $dayinput = $dayinput . ',' . $this->DayName($weekRow);
//                endif;
//            endforeach;

            $dataTextWDep[$i]['department'] = $row->name;
            $dataTextWDep[$i]['id'] = $row->id;
            $dataTextWDep[$i]['date'] = $row->ddate;
            $dataTextWDep[$i]['day'] = date('l', strtotime($row->ddate)); //หาวัน

            $i++;
        endforeach;
        return view('management/weekend/department/view', ['dataWeek' => $dataTextWDep]);
    }

    function createDepertment() {
        $weekend = new Weekend;
        $where = array(['N' => 'state', 'M' => '=', 'W' => 1], ['N' => 'group_condition', 'M' => '!=', 'W' => '']);
        $dataWDep = $weekend->getWeekend($this->data_department, $where);
        $arrDep = array();
        foreach ($dataWDep as $row):
            $arrDep[$row->id] = $row->name;
        endforeach;
        $y = date('Y', time());
        $sumMonth = date("t", strtotime($y . "-1-1"));
        $startDay = date('N', strtotime($y . '-1-1'));
        $x = 1;
        $ii = 1;
        while ($x <= 6):
            $i = 1;
            while ($i <= 7):
                $day[$x][$i] = '';
                if ($ii <= $sumMonth):
                    if ($i >= $startDay || $x > 1):
                        $day[$x][$i] = $ii;
                        $ii++;
                    endif;
                endif;
                $i++;
            endwhile;
            $x++;
        endwhile;

        return view('management/weekend/department/create', ['dataWArrYear' => $this->Year(), 'month' => $this->Month(), 'week' => $day, 'dep' => $arrDep]);
    }

    function checkDateTime(Request $request) {
        $y = $request->input('y');
        $m = $request->input('m');
        $sumMonth = date("t", strtotime($y . "-" . $m . "-1"));
        $startDay = date('N', strtotime($y . '-' . $m . '-1'));
        $x = 1;
        $ii = 1;
        while ($x <= 6):
            $i = 1;
            while ($i <= 7):
                $day[$x][$i] = '';
                if ($ii <= $sumMonth):
                    if ($i >= $startDay || $x > 1):
                        $day[$x][$i] = $ii;
                        $ii++;
                    endif;
                endif;
                $i++;
            endwhile;
            $x++;
        endwhile;

        return $day;
    }

    function updateDepertment(Request $request, $id = null) {
        $this->validate($request, [
            'dep_id' => 'required',
            'year' => 'required',
            'month' => 'required',
            'weekend' => 'required'
        ]);
        $dayinput = '';
        $weekend = new Weekend;
        foreach ($request->input('weekend') as $i => $row):
            $dayinput = $request->input('year') . '-' . $request->input('month') . '-' . $row;

            $ins_data = ['dep_id' => $request->input('dep_id'),
                'ddate' => $dayinput,
                'state' => 1
            ];

            if ($id == null) :
                $weekend->InsertWeekend($ins_data, $this->department);
            else:
                $weekend->UpdateWeekend($ins_data, $this->department, $id);
            endif;
        endforeach;
        return redirect('weekend/depertment');
    }
    
    function destroyDepertment($id){
        $weekend = new Weekend;
        $weekend->DestroyDelWeekend($id, $this->department);
        
//        echo $id;
        return redirect('weekend/depertment');
    }

    //*************************************************************** end department **********************************************************



    function Day() {
        $day = array(
            '0' => array('Monday', '1'),
            '1' => array('Tuesday', '2'),
            '2' => array('Wednesday', '3'),
            '3' => array('Thursday', '4'),
            '4' => array('Friday', '5'),
            '5' => array('Saturday', '6'),
            '6' => array('Sunday', '7'));
        return $day;
    }

    function Month() {
        $day[1] = 'มกราคม';
        $day[2] = 'กุมภาพันธ์';
        $day[3] = 'มีนาคม';
        $day[4] = 'เมษายน';
        $day[5] = 'พฤษภาคม';
        $day[6] = 'มิถุนายน';
        $day[7] = 'กรกฎาคม';
        $day[8] = 'สิงหาคม';
        $day[9] = 'กันยายน';
        $day[10] = 'ตุลาคม';
        $day[11] = 'พฤศจิกายน';
        $day[12] = 'ธันวาคม';

//        $day = array(
//            '0' => array('มกราคม', '1'), 
//            '1' => array('กุมภาพันธ์', '2'), 
//            '2' => array('มีนาคม', '3'), 
//            '3' => array('เมษายน', '4'), 
//            '4' => array('พฤษภาคม', '5'), 
//            '5' => array('มิถุนายน', '6'), 
//            '6' => array('กรกฎาคม', '7'),
//            '7' => array('สิงหาคม', '8'),
//            '8' => array('กันยายน', '9'),
//            '9' => array('ตุลาคม', '10'),
//            '10' => array('พฤศจิกายน', '11'),
//            '11' => array('ธันวาคม', '12'),
//            );
        return $day;
    }

    function DayName($weekRow) {
        $dayName = '';
        switch ($weekRow) :
            case 1:
                $dayName = "Monday";
                break;
            case 2:
                $dayName = "Tuesday";
                break;
            case 3:
                $dayName = "Wednesday";
                break;
            case 4:
                $dayName = "Thursday";
                break;
            case 5:
                $dayName = "Friday";
                break;
            case 6:
                $dayName = "Saturday";
                break;
            case 7:
                $dayName = "Sunday";
                break;
        endswitch;
        return $dayName;
    }

    function MonthName($weekRow) {
        $Name = '';
        switch ($weekRow) :
            case '01':
                $Name = "มกราคม";
                break;
            case '02':
                $Name = "กุมภาพันธ์";
                break;
            case '03':
                $Name = "มีนาคม";
                break;
            case '04':
                $Name = "เมษายน";
                break;
            case '05':
                $Name = "พฤษภาคม";
                break;
            case '06':
                $Name = "มิถุนายน";
                break;
            case '07':
                $Name = "กรกฎาคม";
                break;
            case '08':
                $Name = "สิงหาคม";
                break;
            case '09':
                $Name = "กันยายน";
                break;
            case '10':
                $Name = "ตุลาคม";
                break;
            case '11':
                $Name = "พฤศจิกายน";
                break;
            case '12':
                $Name = "ธันวาคม";
                break;
        endswitch;
        return $Name;
    }

    function Year() {
        $y = date("Y", time());
        $x = 0;
        while ($x < 5):

            $dataWArrYear[$y + $x] = $y + $x;
            $x++;
        endwhile;

//        $weekend = new Weekend;
//        $where = array(['N' => 'state', 'M' => '=', 'W' => 1]);
//        $dataWCom = $weekend->getWeekendGroup($this->company, $where, 'ydate');
//        $x = $dataWCom[0]->ydate;
//        $dataWArrYear = array();
//        foreach ($dataWCom as $yRow):
//            $dataWArrYear[$x] = $yRow->ydate;
//            $x++;
//        endforeach;
//        $n1 = $x + 3;
//        $n2 = $x;
//        $Year = $dataWArrYear[$n2 - 1];
//        while ($x < $n1):
//            $Year = $Year + 1;
//            $dataWArrYear[$x] = $Year;
//            $x++;
//        endwhile;
        return $dataWArrYear;
    }

}
