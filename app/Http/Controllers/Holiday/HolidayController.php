<?php

namespace App\Http\Controllers\Holiday;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Holiday;
use Image;
use DB;


class HolidayController extends Controller {

    protected $business = 'config_holiday_business';
    protected $official = 'config_holiday_official';

    public function __construct() {
        $this->middleware('adminhrhof');
        \Debugbar::disable();
    }

    public function index() {

        return view('management/holiday/main');
    }

//****************************************************************************** start Official *****************************************************************************
    function Official() {
     
        $Holiday = new Holiday;
        $where = array(['N' => 'state', 'M' => '=', 'W' => 1]);
//        $dataW = Holiday::getHoliday1($this->official, $where);
        $dataW = $Holiday->getHoliday1($this->official, $where);
        $dataTextW = array();
        $i = 0;

        foreach ($dataW as $row):
//            $dayinput = $this->DayName(date('N', strtotime($row->ddate)));
//            $dataTextW[$i]['day'] = $dayinput;

            $dataTextW[$i]['group'] = $row->group;
            $dataTextW[$i]['rank'] = $row->rank1 . ' - ' . $row->rank2;
            $dataTextW[$i]['description'] = $row->description;

            $i++;
        endforeach;
        return view('management/holiday/official/view', ['dataOfficial' => $dataTextW]);
    }

    function createOfficial() {

        return view('management/holiday/official/create');
    }

    function destroyOfficial($id) {
        $Holiday = new Holiday;
        $Holiday->DestroyDelHoliday($id, $this->official);
    }

    function updateOfficial(Request $request, $id = null) {
        $this->validate($request, [
            'description' => 'required',
            'date_length' => 'required',
        ]);
        $Holiday = new Holiday;
        $dataW = $Holiday->getHoliday_Official();
        $group = $dataW + 1;
        $string = $request->input('date_length');
        $exp = explode(' - ', $string);
        $start = explode('-', $exp[0]);
        $end = explode('-', $exp[1]);
        $ddate = '';
        if ($start[1] == $end[1]):
            for ($i = $start[2]; $i <= $end[2]; $i++):
                $ddate = $start[0] . '-' . $start[1] . '-' . $i;
                $ins_data = ['ddate' => $ddate,
                    'description' => $request->input('description'),
                    'state' => 1,
                    'group' => $group
                ];
                if ($id == null) :
                    $Holiday->InsertHoliday($ins_data, $this->official);
                endif;
            endfor;
        else:
            $start_M = date('t', strtotime($exp[0]));
            for ($i = $start[2]; $i <= $start_M; $i++):
                $ddate = $start[0] . '-' . $start[1] . '-' . $i;
                $ins_data = ['ddate' => $ddate,
                    'description' => $request->input('description'),
                    'state' => 1,
                    'group' => $group
                ];
                if ($id == null) :
                    $Holiday->InsertHoliday($ins_data, $this->official);
                endif;
            endfor;
            for ($i = 1; $i <= $end[2]; $i++):
                $ddate = $end[0] . '-' . $end[1] . '-' . $i;
                $ins_data = ['ddate' => $ddate,
                    'description' => $request->input('description'),
                    'state' => 1,
                    'group' => $group
                ];
                if ($id == null) :
                    $Holiday->InsertHoliday($ins_data, $this->official);
                endif;
            endfor;
        endif;
        return redirect('holiday/official');
    }

//****************************************************************************** end Official ********************************************************************************
//****************************************************************************** start Business ****************************************************************************** 
    function Business() {
        $Holiday = new Holiday;
        $where = array(['N' => 'state', 'M' => '=', 'W' => 1]);
        $dataW = $Holiday->getHoliday2($this->business, $where);
        $dataTextW = array();
        $i = 0;


        foreach ($dataW as $row):
            $dataTextW[$i]['name'] = $row->dept_name;
            $dataTextW[$i]['group'] = $row->group;
            $dataTextW[$i]['rank'] = $row->rank1 . ' - ' . $row->rank2;
            $dataTextW[$i]['description'] = $row->description;

            $i++;
        endforeach;
        return view('management/holiday/business/view', ['dataBusiness' => $dataTextW]);
    }

    function createBusiness() {
        $Holiday = new Holiday;
        $dataList = $Holiday->getDepartment();
        foreach ($dataList as $row):
            $dataLists[$row->id . ':' . $row->name] = $row->name;
        endforeach;
        return view('management/holiday/business/create', ['dataLists' => $dataLists]);
    }

    function destroyBusiness($id) {
        $Holiday = new Holiday;
        $Holiday->DestroyDelHoliday($id, $this->business);
    }

    function updateBusiness(Request $request, $id = null) {
        $this->validate($request, [
            'description' => 'required',
            'date_length' => 'required',
        ]);
        $Holiday = new Holiday;
        $dataW = $Holiday->getHoliday_Business();
        $group = $dataW + 1;
        $string = $request->input('date_length');
        $exp = explode(' - ', $string);
        $start = explode('-', $exp[0]);
        $end = explode('-', $exp[1]);
        $dept = explode(':', $request->input('department'));
        $ddate = '';
        if ($start[1] == $end[1]):
            for ($i = $start[2]; $i <= $end[2]; $i++):
                $ddate = $start[0] . '-' . $start[1] . '-' . $i;
                $ins_data = ['ddate' => $ddate,
                    'description' => $request->input('description'),
                    'state' => 1,
                    'group' => $group,
                    'dept_id' => $dept[0],
                    'dept_name' => $dept[1]
                ];
                if ($id == null) :
                    $Holiday->InsertHoliday($ins_data, $this->business);
                endif;
            endfor;
        else:
            $start_M = date('t', strtotime($exp[0]));
            for ($i = $start[2]; $i <= $start_M; $i++):
                $ddate = $start[0] . '-' . $start[1] . '-' . $i;
                $ins_data = ['ddate' => $ddate,
                    'description' => $request->input('description'),
                    'state' => 1,
                    'group' => $group,
                    'dept_id' => $dept[0],
                    'dept_name' => $dept[1]
                ];
                if ($id == null) :
                    $Holiday->InsertHoliday($ins_data, $this->business);
                endif;
            endfor;
            for ($i = 1; $i <= $end[2]; $i++):
                $ddate = $end[0] . '-' . $end[1] . '-' . $i;
                $ins_data = ['ddate' => $ddate,
                    'description' => $request->input('description'),
                    'state' => 1,
                    'group' => $group,
                    'dept_id' => $dept[0],
                    'dept_name' => $dept[1]
                ];
                if ($id == null) :
                    $Holiday->InsertHoliday($ins_data, $this->business);
                endif;
            endfor;
        endif;
        return redirect('holiday/business');
    }

//****************************************************************************** end Business ******************************************************************************    
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

}
