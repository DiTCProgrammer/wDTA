<?php

namespace App\Http\Controllers\Scheduletime;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Scheduletime;
use Image;
use DB;

class ScheduletimeController extends Controller {

    protected $condition_time = 'config_condition_time';
    
    public function __construct() {
        $this->middleware('adminhr');
        \Debugbar::disable();
    }

    public function index() {
        return view('management/scheduletime/main');
    }

    public function edit($id = null) {
        $group = array();
        $Hour = array();
        $Min = array();
        for ($i = 0; $i <= 99; $i++):
            $group[$i] = $i;
        endfor;
        for ($i = 0; $i <= 23; $i++):
            $Hour[sprintf("%02d", $i)] = sprintf("%02d", $i);
        endfor;
        for ($i = 0; $i <= 59; $i++):
            $Min[sprintf("%02d", $i)] = sprintf("%02d", $i);
        endfor;
        $Scheduletime = new Scheduletime;
        $Condition_Time = $Scheduletime->getCondition_Time_ID($id);
        $jsontimesparemin = json_decode($Condition_Time[0]->timesparemin);
        $jsontimeinout = json_decode($Condition_Time[0]->timeinout);
        $arr_Timeinout = array();
        $arr_Timeinout['group_1_h1'] = '00';
        $arr_Timeinout['group_1_m1'] = '00';
        $arr_Timeinout['group_1_h2'] = '00';
        $arr_Timeinout['group_1_m2'] = '00';
        $arr_Timeinout['group_2_h3'] = '00';
        $arr_Timeinout['group_2_m3'] = '00';
        $arr_Timeinout['group_2_h4'] = '00';
        $arr_Timeinout['group_2_m4'] = '00';
        $arr_Timeinout['group_3_h5'] = '00';
        $arr_Timeinout['group_3_m5'] = '00';
        $arr_Timeinout['group_3_h6'] = '00';
        $arr_Timeinout['group_3_m6'] = '00';
        if (!empty($jsontimeinout->t1)):
            $t1 = explode(":", $jsontimeinout->t1);
            $arr_Timeinout['group_1_h1'] = $t1[0];
            $arr_Timeinout['group_1_m1'] = $t1[1];
        endif;
        if (!empty($jsontimeinout->t2)):
            $t2 = explode(":", $jsontimeinout->t2);
            $arr_Timeinout['group_1_h2'] = $t2[0];
            $arr_Timeinout['group_1_m2'] = $t2[1];
        endif;
        if (!empty($jsontimeinout->t3)):
            $t3 = explode(":", $jsontimeinout->t3);
            $arr_Timeinout['group_2_h3'] = $t3[0];
            $arr_Timeinout['group_2_m3'] = $t3[1];
        endif;
        if (!empty($jsontimeinout->t4)):
            $t4 = explode(":", $jsontimeinout->t4);
            $arr_Timeinout['group_2_h4'] = $t4[0];
            $arr_Timeinout['group_2_m4'] = $t4[1];
        endif;
        if (!empty($jsontimeinout->t5)):
            $t5 = explode(":", $jsontimeinout->t5);
            $arr_Timeinout['group_3_h5'] = $t5[0];
            $arr_Timeinout['group_3_m5'] = $t5[1];
        endif;
        if (!empty($jsontimeinout->t6)):
            $t6 = explode(":", $jsontimeinout->t6);
            $arr_Timeinout['group_3_h6'] = $t6[0];
            $arr_Timeinout['group_3_m6'] = $t6[1];
        endif;
        $aot = explode(":", $Condition_Time[0]->aot);
        $arr_Timeinout['aot_h'] = $aot[0];
        $arr_Timeinout['aot_m'] = $aot[1];
        $arr_Timeinout['flexibility_1_m1'] = '00';
        $arr_Timeinout['flexibility_1_m2'] = '00';
        $arr_Timeinout['flexibility_2_m3'] = '00';
        $arr_Timeinout['flexibility_2_m4'] = '00';
        $arr_Timeinout['flexibility_3_m5'] = '00';
        $arr_Timeinout['flexibility_3_m6'] = '00';

        if (!empty($jsontimesparemin->t1)):
            $arr_Timeinout['flexibility_1_m1'] = $jsontimesparemin->t1;
        endif;
        if (!empty($jsontimesparemin->t2)):
            $arr_Timeinout['flexibility_1_m2'] = $jsontimesparemin->t2;
        endif;
        if (!empty($jsontimesparemin->t3)):
            $arr_Timeinout['flexibility_2_m3'] = $jsontimesparemin->t3;
        endif;
        if (!empty($jsontimesparemin->t4)):
            $arr_Timeinout['flexibility_2_m4'] = $jsontimesparemin->t4;
        endif;
        if (!empty($jsontimesparemin->t5)):
            $arr_Timeinout['flexibility_3_m5'] = $jsontimesparemin->t5;
        endif;
        if (!empty($jsontimesparemin->t6)):
            $arr_Timeinout['flexibility_3_m6'] = $jsontimesparemin->t6;
        endif;

        return view('management/scheduletime/edit', ['group' => $group, 'Hour' => $Hour, 'Min' => $Min, 'Condition_Time' => $Condition_Time, 'Timeinout' => $arr_Timeinout]);
    }

    function updatedep(Request $request, $id = null) {
        $ins_data = [
            'group_condition' => $request->input('datagroup'),
        ];
        $Scheduletime = new Scheduletime;
        $Scheduletime->UpdateScheduletimeDepartment($ins_data, $request->input('groupmodel'));
        return redirect('scheduletime/view');
    }

    public function view() {
        $Scheduletime = new Scheduletime;
        $Depgroup = $Scheduletime->getDepartmentAll();
        $Condition_Time = $Scheduletime->getCondition_Time();
        $group = array();
        $group2 = array();
        $group3 = array();
        foreach ($Depgroup as $i => $row):
            if ($row->group_condition != ''):
                $group2[$row->group_condition]['id'][] = $row->id;
                $group2[$row->group_condition]['name'][] = $row->name;
            else:
                $group2['null']['id'][] = $row->id;
                $group2['null']['name'][] = $row->name;
                $group3[$row->id] = $row->name;
            endif;

        endforeach;
        foreach ($Condition_Time as $i => $row):
            $group[$row->group]['timeinout'][] = json_decode($row->timeinout);
            $group[$row->group]['group'][] = $row->group;
            $group[$row->group]['id'][] = $row->id;
            $group[$row->group]['name'][] = $row->name;
        endforeach;

        foreach ($group as $i => $row):
            if (!empty($group2[$i])):
                $group[$i]['depgroup'][] = $group2[$i];
            else:
                $group[$i]['depgroup'][] = '';
            endif;
        endforeach;


        return view('management/scheduletime/view', ['nogroup' => $group2['null'], 'group' => $group, 'groupmodel' => $group3]);
    }

    function create() {
        $group = array();
        $Hour = array();
        $Min = array();
        for ($i = 0; $i <= 99; $i++):
            $group[$i] = $i;
        endfor;
        for ($i = 0; $i <= 23; $i++):
            $Hour[sprintf("%02d", $i)] = sprintf("%02d", $i);
        endfor;
        for ($i = 0; $i <= 59; $i++):
            $Min[sprintf("%02d", $i)] = sprintf("%02d", $i);
        endfor;
        return view('management/scheduletime/create', ['group' => $group, 'Hour' => $Hour, 'Min' => $Min]);
    }

    public function update(Request $request, $id = null) {

        $this->validate($request, [
            'group' => 'required',
            'name' => 'required',
            'worktime' => 'required',
            'timecheck_1' => 'required'
        ]);
        $arr_Timeinout = array();
        $arr_Timespare = array();
        if (!empty($request->input('sttkidlate'))):
            $sttkidlate = $request->input('sttkidlate');
        else:
            $sttkidlate = 0;
        endif;



        $group_1_h1 = $request->input('group_1_h1');
        $group_1_m1 = $request->input('group_1_m1');
        $group_1_h2 = $request->input('group_1_h2');
        $group_1_m2 = $request->input('group_1_m2');
        $group_2_h3 = $request->input('group_2_h3');
        $group_2_m3 = $request->input('group_2_m3');
        $group_2_h4 = $request->input('group_2_h4');
        $group_2_m4 = $request->input('group_2_m4');
        $group_3_h5 = $request->input('group_3_h5');
        $group_3_m5 = $request->input('group_3_m5');
        $group_3_h6 = $request->input('group_3_h6');
        $group_3_m6 = $request->input('group_3_m6');
        $counttime = 2;
        if ($request->input('timecheck_1')):
            $counttime = $request->input('timecheck_1');
            $arr_Timeinout['t1'] = $group_1_h1 . ':' . $group_1_m1 . ':00';
            $arr_Timeinout['t2'] = $group_1_h2 . ':' . $group_1_m2 . ':00';
        endif;
        if ($request->input('timecheck_2')):
            $counttime = $request->input('timecheck_2');
            $arr_Timeinout['t3'] = $group_2_h3 . ':' . $group_2_m3 . ':00';
            $arr_Timeinout['t4'] = $group_2_h4 . ':' . $group_2_m4 . ':00';
        endif;
        if ($request->input('timecheck_3')):
            $counttime = $request->input('timecheck_3');
            $arr_Timeinout['t5'] = $group_3_h5 . ':' . $group_3_m5 . ':00';
            $arr_Timeinout['t6'] = $group_3_h6 . ':' . $group_3_m6 . ':00';
        endif;

        if ($sttkidlate == 1):
            $timesparemin = array();

            $flexibility_1_m1 = $request->input('flexibility_1_m1');
            $flexibility_1_m2 = $request->input('flexibility_1_m2');
            $flexibility_2_m3 = $request->input('flexibility_2_m3');
            $flexibility_2_m4 = $request->input('flexibility_2_m4');
            $flexibility_3_m5 = $request->input('flexibility_3_m5');
            $flexibility_3_m6 = $request->input('flexibility_3_m6');


            if ($request->input('timecheck_1')):
                $TimeSpare_t1 = $this->TimeSpare($group_1_h1, $group_1_m1, $flexibility_1_m1);
                $TimeSpare_t2 = $this->TimeSpare($group_1_h2, $group_1_m2, $flexibility_1_m2);
                $timesparemin['t1'] = $flexibility_1_m1;
                $timesparemin['t2'] = $flexibility_1_m2;
                $arr_Timespare['t1'] = $TimeSpare_t1['H'] . ':' . $TimeSpare_t1['M'] . ':00';
                $arr_Timespare['t2'] = $TimeSpare_t2['H'] . ':' . $TimeSpare_t2['M'] . ':00';
            endif;
            if ($request->input('timecheck_2')):
                $TimeSpare_t3 = $this->TimeSpare($group_2_h3, $group_2_m3, $flexibility_2_m3);
                $TimeSpare_t4 = $this->TimeSpare($group_2_h4, $group_2_m4, $flexibility_2_m4);
                $timesparemin['t3'] = $flexibility_2_m3;
                $timesparemin['t4'] = $flexibility_2_m4;
                $arr_Timespare['t3'] = $TimeSpare_t3['H'] . ':' . $TimeSpare_t3['M'] . ':00';
                $arr_Timespare['t4'] = $TimeSpare_t4['H'] . ':' . $TimeSpare_t4['M'] . ':00';
            endif;
            if ($request->input('timecheck_3')):
                $TimeSpare_t5 = $this->TimeSpare($group_3_h5, $group_3_m5, $flexibility_3_m5);
                $TimeSpare_t6 = $this->TimeSpare($group_3_h6, $group_3_m6, $flexibility_3_m6);
                $timesparemin['t5'] = $flexibility_3_m5;
                $timesparemin['t6'] = $flexibility_3_m6;
                $arr_Timespare['t5'] = $TimeSpare_t5['H'] . ':' . $TimeSpare_t5['M'] . ':00';
                $arr_Timespare['t6'] = $TimeSpare_t6['H'] . ':' . $TimeSpare_t6['M'] . ':00';
            endif;
        else:
            $sttkidlate = 0;
            if ($request->input('timecheck_1')):
                $timesparemin['t1'] = "";
                $timesparemin['t2'] = "";
                $arr_Timespare['t1'] = "";
                $arr_Timespare['t2'] = "";
            endif;
            if ($request->input('timecheck_2')):
                $timesparemin['t3'] = "";
                $timesparemin['t4'] = "";
                $arr_Timespare['t3'] = "";
                $arr_Timespare['t4'] = "";
            endif;
            if ($request->input('timecheck_3')):
                $timesparemin['t5'] = "";
                $timesparemin['t6'] = "";
                $arr_Timespare['t5'] = "";
                $arr_Timespare['t6'] = "";
            endif;
        endif;
        $ot = $request->input('ot');
        if ($ot == 1):
            if ($request->input('ot_text')):
                $ot = $request->input('ot_text');
            else:
                $ot = 0;
            endif;
        endif;
        $bot = $request->input('bot');
        if ($bot == 1):
            if ($request->input('bot_text')):
                $bot = $request->input('bot_text');
            else:
                $bot = 0;
            endif;
        endif;
        $fixot = $request->input('fixot') ? 1 : 0;
        $aot = $request->input('aot_h') . ':' . $request->input('aot_m') . ':00';
        $rate_ot_1 = $request->input('rate_ot_1') ? $request->input('rate_ot_1') : 0;
        $rate_ot_2 = $request->input('rate_ot_2') ? $request->input('rate_ot_2') : 0;
        $rate_ot_3 = $request->input('rate_ot_3') ? $request->input('rate_ot_3') : 0;
        $rate_ot_4 = $request->input('rate_ot_4') ? $request->input('rate_ot_4') : 0;
        $ins_data = [
            'group' => $request->input('group'),
            'name' => $request->input('name'),
            'counttime' => $counttime,
            'timespare' => json_encode($arr_Timespare),
            'timesparemin' => json_encode($timesparemin),
            'timeinout' => json_encode($arr_Timeinout),
            'ot' => $ot,
            'bot' => $bot,
            'worktime' => $request->input('worktime'),
            'aot' => $aot,
            'sttkidlate' => $sttkidlate,
            'fixot' => $fixot,
            'rate_ot_1' => $rate_ot_1,
            'rate_ot_2' => $rate_ot_2,
            'rate_ot_3' => $rate_ot_3,
            'rate_ot_4' => $rate_ot_4,
            'common_montly_ot' => $request->input('common_montly_ot'),
            'common_montly_technicial' => $request->input('common_montly_technicial'),
            'common_daily_ot' => $request->input('common_daily_ot'),
            'common_daily_technicial' => $request->input('common_daily_technicial'),
            'weekend_montly_intime' => $request->input('weekend_montly_intime'),
            'weekend_montly_ot' => $request->input('weekend_montly_ot'),
            'weekend_montly_technicial' => $request->input('weekend_montly_technicial'),
            'weekend_daily_intime' => $request->input('weekend_daily_intime'),
            'weekend_daily_ot' => $request->input('weekend_daily_ot'),
            'weekend_daily_technicial' => $request->input('weekend_daily_technicial'),
            'holiday_montly_intime' => $request->input('holiday_montly_intime'),
            'holiday_montly_ot' => $request->input('holiday_montly_ot'),
            'holiday_montly_technicial' => $request->input('holiday_montly_technicial'),
            'holiday_daily_intime' => $request->input('holiday_daily_intime'),
            'holiday_daily_ot' => $request->input('holiday_daily_ot'),
            'holiday_daily_technicial' => $request->input('holiday_daily_technicial'),
            'stthalfday' => $request->input('stthalfday'),
        ];

        $Scheduletime = new Scheduletime;

        if ($id == null) :
            $Scheduletime->InsertScheduletime($ins_data, $this->condition_time);
        else:
            $Scheduletime->UpdateScheduletime($ins_data, $this->condition_time, $id);
        endif;
        return redirect('scheduletime');
    }

    function TimeSpare($H, $M, $F) {
        $numM_s = $M + $F;
        $numM = sprintf("%02d", $numM_s);
        $numH = $H;
        if ($numM > 59):
            $numM_s2 = $numM - 59;
            $numM = sprintf("%02d", $numM_s2);
            $numH = $H + 1;
            if ($numH > 23):
                $numH = '00';
            else:
                $numH = sprintf("%02d", $numH);
            endif;
        endif;

        return ['H' => $numH, 'M' => $numM];
    }

    public function destroy($id) {
        $Scheduletime = new Scheduletime;
        $Scheduletime->DestroyScheduletime($id);
        return redirect('scheduletime/view');
    }

    public function destroydep($id) {
        $Scheduletime = new Scheduletime;
        $Scheduletime->DestroyScheduletimeDep($id);
        return redirect('scheduletime/view');
    }

}
