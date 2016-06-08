<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Attendance extends Model {

    protected $table = 'attendance_upload'; //DB Name
    protected $db = 'dta_1';
    private $date_start;
    private $date_end;

    public function Uploaddata($request) {
        if ($request) {

            DB::connection($this->db)->beginTransaction();
            try {
                DB::connection($this->db)->table('attendance_upload')->insert($request);
                DB::connection($this->db)->commit();
                return true;
            } catch (\Exception $e) {
                DB::connection($this->db)->rollBack();
                throw $e;
            }
        }
        return false;
    }

    public function Raw($uid = null, $date_start, $date_end) {

        if ($uid) {
            $this->date_start = $date_start;
            $this->date_end = $date_end;
            $emp_data = $this->Employee_data($uid); //Get Employee Data

            if ($emp_data) {
                //Employee Group Time
                $emp_group_time = $this->Grouptime($uid);


                if ($emp_group_time) {

                    foreach ($emp_group_time as $key => $emp_group_time_val) {

                        $emp_group_time[$key]->ttime = $this->Duplicationtime($emp_group_time_val->ttime);
                    }

                    //Check Night
                    //    if ($emp_data->status_night == 1) {


                    $data = $this->Checknight($emp_group_time, $emp_data->status_night_time, $emp_data, $emp_data->status_night);

                    if ($data) {

                        return $data;
                    } else {

                        return true;
                    }
                    //  }
                }
            }

            return false; // Error No Employee
        }
        return false;
    }

    function Checknight($emp_group_time, $night_time, $emp_data, $staus_night, $company_status = 1) {  //company status 1 default,2 night or day first time and last time
        if ($emp_group_time && $staus_night) {
            $date_log = null;
            $count_date = 0;
            $data_time = null;
            $tmp_date = null;
            $state = null;
            $night_time = strtotime($night_time) - (60 * 60);
            $status_last = null;



            foreach ($emp_group_time as $key => $emp_group_time_val) {
                if ($emp_group_time_val->ttime['time']) {
                    $data_time[$key] = explode('__', $emp_group_time_val->ttime['time']);
                    if ($date_log == null) {
                        if (strtotime(date('H:i:s', strtotime($data_time[$key][0]))) < $night_time) {
                            $tmp_date[$count_date] = $data_time[$key];
                            $state = 1;
                            ++$count_date;
                        } else {
                            $tmp_date[$count_date][0] = $data_time[$key][0];
                            $state = 0;
                        }
                    } else {
                        if ($state == 1) {
                            if (strtotime(date('H:i:s', strtotime($data_time[$key][0]))) < $night_time) {
                                $tmp_date[$count_date] = $data_time[$key];
                                $state = 1;
                                ++$count_date;
                            } else {
                                $tmp_date[$count_date][0] = $data_time[$key][0];
                                $state = 0;
                            }
                        } else {
                            if (floor(strtotime(date('Y-m-d', strtotime($data_time[$key][0]))) - $date_log) / 86400 == 1) {
                                if (strtotime(date('H:i:s', strtotime($data_time[$key][0]))) >= $night_time) {
                                    ++$count_date;
                                    $tmp_date[$count_date][0] = $data_time[$key][0];
                                    $state = 0;
                                } else {

                                    $tmp_date[$count_date][1] = $data_time[$key][0];
                                    ++$count_date;
                                    if (strtotime(date('H:i:s', strtotime($data_time[$key][count($data_time[$key]) - 1]))) < $night_time) {
                                        $tmp_date[$count_date] = $data_time[$key];
                                        $state = 1;
                                    } else {
                                        $tmp_date[$count_date][0] = $data_time[$key][count($data_time[$key]) - 1];
                                        $state = 0;
                                    }
                                }
                            } else {
                                $tmp_date[$count_date] = $data_time[$key];
                                $state = 1;
                                ++$count_date;
                            }
                        }
                    }
                    $date_log = strtotime(date('Y-m-d', strtotime($data_time[$key][0])));

                    if ($key == count($emp_group_time) - 2) {
                        $status_last = $state;
                    }
                }
            }
            if ($status_last == 0) {
                unset($tmp_date[count($tmp_date) - 1]);
            }

            //Check Date In Month
            if ($tmp_date) {


                $day_first = date('d', strtotime($this->date_start));
                $month_first = date('m', strtotime($this->date_start));
                $year_first = date('Y', strtotime($this->date_start));
                $day_last = date('d', strtotime($this->date_end));
                $month_last = date('m', strtotime($this->date_end));
                $year_last = date('Y', strtotime($this->date_end));


                if ((int) $month_first == (int) $month_last) { //เดือนเท่ากัน
                    //$i = (int) $day_first;
                    $i = (int) date('d', strtotime($this->date_start));
                    $j = count($tmp_date) - 1;
                    $l = (int) date('d', strtotime($this->date_end));


                    $date_total = null;

                    foreach ($tmp_date as $val) {
                        $date_total[] = (int) date('d', strtotime($val[0]));
                    }

                    while ($i <= (int) $l) { //$day_last
                        if (!in_array((int) $i, $date_total)) {
                            $tmp_date[] = array($year_first . '-' . $month_first . '-' . ($i < 10 ? '0' . $i : $i), 1);
                        }

                        ++$i;
                    }
                } else {

                    $day_in_month_f = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($this->date_start)), date('y', strtotime($this->date_start)));


                    //$i = (int) $day_first;
                    $i = (int) date('d', strtotime($this->date_start));
                    $j = count($tmp_date) - 1;

                    $date_total = null;

                    foreach ($tmp_date as $val) {
                        if ((int) date('m', strtotime($val[0])) == (int) $month_first) {
                            $date_total[] = (int) date('d', strtotime($val[0]));
                        }
                    }

                    while ($i <= (int) $day_in_month_f) {
                        if (!in_array((int) $i, $date_total)) {
                            // $tmp_date[][0] = $year_first . '-' . $month_first . '-' . ($i < 10 ? '0' . $i : $i);
                        }

                        ++$i;
                    }

                    //------- Next Month --------
                    $i = 1;
                    $date_total = null;
                    $l = (int) date('d', strtotime($this->date_end));

                    foreach ($tmp_date as $val) {
                        if ((int) date('m', strtotime($val[0])) == (int) $month_last) {
                            $date_total[] = (int) date('d', strtotime($val[0]));
                        }
                    }

                    while ($i <= $l) { //$day_last
                        if (!$date_total || !in_array((int) $i, $date_total)) {

                            $tmp_date[] = array($year_last . '-' . $month_last . '-' . ($i < 10 ? '0' . $i : $i), 'state' => 1);
                        }

                        ++$i;
                    }
                }



                $data_return = null;

//                $date = '2016-03-31 17:37:00';
//                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
//                    echo 'true';
//                }else{
//                    echo 'false';
//                }



                foreach ($tmp_date as $key => $val) {


                    $extradate = $this->extradate($emp_data->empcode, date('Y-m-d', strtotime($val[0])), $emp_data->dept_id);

                    $new_time = implode(',', $val);

                    $ddate = date('Y-m-d', strtotime($val[0]));
                    $tmp_date[$key] = NULL;
                    $tmp_date[$key]['ddate'] = $ddate;

                    if (isset($val['state']) && $val['state'] == 1) {
                        $tmp_date[$key]['dtime'] = 0;
                        $tmp_date[$key]['count_time'] = 0;
                    } else {
                        $tmp_date[$key]['dtime'] = $new_time;
                        $tmp_date[$key]['count_time'] = count($val);
                    }


                    $tmp_date[$key]['detail'] = $extradate;
                    $tmp_date[$key]['employee'] = $emp_data;

//                    echo '<pre>';
//                    print_r($extradate);
//                    echo '</pre>';

                    $insert_id = DB::connection($this->db)->table('attendance_raw')->insertGetId(array(
                        'uid' => $tmp_date[$key]['employee']->id_emp,
                        'empcode' => $tmp_date[$key]['employee']->empcode,
                        'prefix' => $tmp_date[$key]['employee']->prefix,
                        'firstname' => $tmp_date[$key]['employee']->firstname,
                        'lastname' => $tmp_date[$key]['employee']->lastname,
                        'sex' => $tmp_date[$key]['employee']->sex,
                        'position' => $tmp_date[$key]['employee']->position,
                        'id_card' => $tmp_date[$key]['employee']->id_card,
                        'paytype' => $tmp_date[$key]['employee']->paytype,
                        'payrate' => $tmp_date[$key]['employee']->payrate,
                        'payrate' => $tmp_date[$key]['employee']->payrate,
                        'wage' => $tmp_date[$key]['employee']->wage,
                        'extrawage' => $tmp_date[$key]['employee']->extrawage,
                        'extrawage_status' => $tmp_date[$key]['employee']->extrawage_status,
                        'technicialwage' => $tmp_date[$key]['employee']->technicialwage,
                        'technicialwage_status' => $tmp_date[$key]['employee']->technicialwage_status,
                        'weekendotorday' => $tmp_date[$key]['employee']->technicialwage_status,
                        'date_working' => $tmp_date[$key]['employee']->date_working,
                        'picture' => $tmp_date[$key]['employee']->picture,
                        'ddate' => $tmp_date[$key]['ddate'],
                        'dtime' => $tmp_date[$key]['dtime'],
                        'name_date' => $tmp_date[$key]['detail']->ddate,
                        'group_condition' => $tmp_date[$key]['employee']->emp_group,
                        'weekendcompany' => $tmp_date[$key]['detail']->weekendcompany,
                        'weekenddept' => $tmp_date[$key]['detail']->weekenddept,
                        'holidayoff_id' => $tmp_date[$key]['detail']->holidayoff_id,
                        'holidayoff_detail' => $tmp_date[$key]['detail']->holidayoff_detail,
                        'holidaybus_id' => $tmp_date[$key]['detail']->holidaybus_id,
                        'holidaybus_detail' => $tmp_date[$key]['detail']->holidaybus_detail,
                        'abs_id' => $tmp_date[$key]['detail']->abs_id,
                        'abs_detail' => $tmp_date[$key]['detail']->abs_detail,
                        'count_time' => $tmp_date[$key]['count_time'],
                        'state' => 0,
                        'dept_id' => $tmp_date[$key]['employee']->dept_id,
                        'dept_code' => $tmp_date[$key]['employee']->dept_code,
                        'dept_name' => $tmp_date[$key]['employee']->dept_name,
                        'state2' => (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $val[0]) ? 1 : 0)
                    ));



                    if ((count($val) % 2 == 1 || count($val) > 6) && strlen($val[0]) == 19) {
                        $data_return[] = array('id' => $insert_id, 'time' => $val);
                    }
                }

                DB::connection($this->db)->update('update attendance_upload set state = 1 where uid = ' . $emp_data->empcode);

                if ($data_return) {
                    return $data_return;
                } else {

                    return 'true';
                }
            }
        } else if ($emp_group_time) {
            $date_log = null;
            $count_date = 0;
            $data_time = null;
            $tmp_date = null;
            $state = null;
            $night_time = strtotime($night_time) - (60 * 60);

            foreach ($emp_group_time as $key => $emp_group_time_val) {
                if ($emp_group_time_val->ttime['time']) {
                    $data_time[$key] = explode('__', $emp_group_time_val->ttime['time']);
                    $tmp_date[$count_date] = $data_time[$key];
                    ++$count_date;
                }
            }


            //Check Date In Month
            if ($tmp_date) {


                $day_first = date('d', strtotime($this->date_start));
                $month_first = date('m', strtotime($this->date_start));
                $year_first = date('Y', strtotime($this->date_start));
                $day_last = date('d', strtotime($this->date_end));
                $month_last = date('m', strtotime($this->date_end));
                $year_last = date('Y', strtotime($this->date_end));


                if ((int) $month_first == (int) $month_last) { //เดือนเท่ากัน
                    //$i = (int) $day_first;
                    $i = (int) date('d', strtotime($this->date_start));
                    $j = count($tmp_date) - 1;
                    $l = (int) date('d', strtotime($this->date_end));


                    $date_total = null;

                    foreach ($tmp_date as $val) {
                        $date_total[] = (int) date('d', strtotime($val[0]));
                    }

                    while ($i <= (int) $l) { //$day_last
                        if (!in_array((int) $i, $date_total)) {
                            $tmp_date[] = array($year_first . '-' . $month_first . '-' . ($i < 10 ? '0' . $i : $i), 1);
                        }

                        ++$i;
                    }
                } else {

                    $day_in_month_f = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($this->date_start)), date('y', strtotime($this->date_start)));


                    //$i = (int) $day_first;
                    $i = (int) date('d', strtotime($this->date_start));
                    $j = count($tmp_date) - 1;

                    $date_total = null;

                    foreach ($tmp_date as $val) {
                        if ((int) date('m', strtotime($val[0])) == (int) $month_first) {
                            $date_total[] = (int) date('d', strtotime($val[0]));
                        }
                    }

                    while ($i <= (int) $day_in_month_f) {
                        if (!in_array((int) $i, $date_total)) {
                            // $tmp_date[][0] = $year_first . '-' . $month_first . '-' . ($i < 10 ? '0' . $i : $i);
                        }

                        ++$i;
                    }

                    //------- Next Month --------
                    $i = 1;
                    $date_total = null;
                    $l = (int) date('d', strtotime($this->date_end));

                    foreach ($tmp_date as $val) {
                        if ((int) date('m', strtotime($val[0])) == (int) $month_last) {
                            $date_total[] = (int) date('d', strtotime($val[0]));
                        }
                    }

                    while ($i <= $l) { //$day_last
                        if (!$date_total || !in_array((int) $i, $date_total)) {

                            $tmp_date[] = array($year_last . '-' . $month_last . '-' . ($i < 10 ? '0' . $i : $i), 'state' => 1);
                        }

                        ++$i;
                    }
                }



                $data_return = null;

//                $date = '2016-03-31 17:37:00';
//                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
//                    echo 'true';
//                }else{
//                    echo 'false';
//                }



                foreach ($tmp_date as $key => $val) {


                    $extradate = $this->extradate($emp_data->empcode, date('Y-m-d', strtotime($val[0])), $emp_data->dept_id);

                    $new_time = implode(',', $val);

                    $ddate = date('Y-m-d', strtotime($val[0]));
                    $tmp_date[$key] = NULL;
                    $tmp_date[$key]['ddate'] = $ddate;

                    if (isset($val['state']) && $val['state'] == 1) {
                        $tmp_date[$key]['dtime'] = 0;
                        $tmp_date[$key]['count_time'] = 0;
                    } else {
                        $tmp_date[$key]['dtime'] = $new_time;
                        $tmp_date[$key]['count_time'] = count($val);
                    }


                    $tmp_date[$key]['detail'] = $extradate;
                    $tmp_date[$key]['employee'] = $emp_data;

//                    echo '<pre>';
//                    print_r($extradate);
//                    echo '</pre>';

                    $insert_id = DB::connection($this->db)->table('attendance_raw')->insertGetId(array(
                        'uid' => $tmp_date[$key]['employee']->id_emp,
                        'empcode' => $tmp_date[$key]['employee']->empcode,
                        'prefix' => $tmp_date[$key]['employee']->prefix,
                        'firstname' => $tmp_date[$key]['employee']->firstname,
                        'lastname' => $tmp_date[$key]['employee']->lastname,
                        'sex' => $tmp_date[$key]['employee']->sex,
                        'position' => $tmp_date[$key]['employee']->position,
                        'id_card' => $tmp_date[$key]['employee']->id_card,
                        'paytype' => $tmp_date[$key]['employee']->paytype,
                        'payrate' => $tmp_date[$key]['employee']->payrate,
                        'payrate' => $tmp_date[$key]['employee']->payrate,
                        'wage' => $tmp_date[$key]['employee']->wage,
                        'extrawage' => $tmp_date[$key]['employee']->extrawage,
                        'extrawage_status' => $tmp_date[$key]['employee']->extrawage_status,
                        'technicialwage' => $tmp_date[$key]['employee']->technicialwage,
                        'technicialwage_status' => $tmp_date[$key]['employee']->technicialwage_status,
                        'weekendotorday' => $tmp_date[$key]['employee']->technicialwage_status,
                        'date_working' => $tmp_date[$key]['employee']->date_working,
                        'picture' => $tmp_date[$key]['employee']->picture,
                        'ddate' => $tmp_date[$key]['ddate'],
                        'dtime' => $tmp_date[$key]['dtime'],
                        'name_date' => $tmp_date[$key]['detail']->ddate,
                        'group_condition' => $tmp_date[$key]['employee']->emp_group,
                        'weekendcompany' => $tmp_date[$key]['detail']->weekendcompany,
                        'weekenddept' => $tmp_date[$key]['detail']->weekenddept,
                        'holidayoff_id' => $tmp_date[$key]['detail']->holidayoff_id,
                        'holidayoff_detail' => $tmp_date[$key]['detail']->holidayoff_detail,
                        'holidaybus_id' => $tmp_date[$key]['detail']->holidaybus_id,
                        'holidaybus_detail' => $tmp_date[$key]['detail']->holidaybus_detail,
                        'abs_id' => $tmp_date[$key]['detail']->abs_id,
                        'abs_detail' => $tmp_date[$key]['detail']->abs_detail,
                        'count_time' => $tmp_date[$key]['count_time'],
                        'state' => 0,
                        'dept_id' => $tmp_date[$key]['employee']->dept_id,
                        'dept_code' => $tmp_date[$key]['employee']->dept_code,
                        'dept_name' => $tmp_date[$key]['employee']->dept_name,
                        'state2' => (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $val[0]) ? 1 : 0)
                    ));



                    if ((count($val) % 2 == 1 || count($val) > 6) && strlen($val[0]) == 19) {
                        $data_return[] = array('id' => $insert_id, 'time' => $val);
                    }
                }

                DB::connection($this->db)->update('update attendance_upload set state = 1 where uid = ' . $emp_data->empcode);

                if ($data_return) {
                    return $data_return;
                } else {

                    return 'true';
                }
            }
        }
        return false;
    }

    public function extradate($id, $ddate, $deptid) {

        $data = DB::connection($this->db)->select(''
                . 'SELECT a.id,'
                . '(SELECT weekend FROM config_weekend_company e WHERE e.ydate="' . date('Y', strtotime($ddate)) . '") as weekendcompany, '
                . '(SELECT COUNT(id) FROM config_weekend_department b WHERE b.ddate="' . $ddate . '" AND b.dep_id="' . $deptid . '") as weekenddept, '
                . '(SELECT CONCAT(id,"||",description) FROM config_holiday_official c WHERE c.ddate="' . $ddate . '") as holidayoff, '
                . '(SELECT CONCAT(id,"||",description) FROM config_holiday_business d WHERE d.ddate="' . $ddate . '") as holidaybus, '
                . '(SELECT CONCAT(e.status_id,"|",e.status_name) FROM data_employee_absence e WHERE e.ddate="' . $ddate . '" AND e.uid=a.id AND e.state=2) as abs '
                . 'FROM data_employee a WHERE a.empcode="' . $id . '"');

        if ($data) {
            $data[0]->ddate = date('N', strtotime($ddate));
            $weekendcompany = explode(',', $data[0]->weekendcompany);

            if (in_array($data[0]->ddate, $weekendcompany)) {
                $data[0]->weekendcompany = 1;
            } else {
                $data[0]->weekendcompany = 0;
            }
            if ($data[0]->abs) {
                $data[0]->abs = explode('|', $data[0]->abs);
                $data[0]->abs_id = (int) $data[0]->abs[0];
                $data[0]->abs_detail = $data[0]->abs[1];
                unset($data[0]->abs);
            } else {
                $data[0]->abs_id = 0;
                $data[0]->abs_detail = '';
                unset($data[0]->abs);
            }
            $data[0]->weekenddept = (int) $data[0]->weekenddept;
            if ($data[0]->holidaybus) {
                $holidaybus = explode('||', $data[0]->holidaybus);
                $data[0]->holidaybus_id = (int) $holidaybus[0];
                $data[0]->holidaybus_detail = $holidaybus[1];
            } else {
                $data[0]->holidaybus_id = '';
                $data[0]->holidaybus_detail = '';
            }

            if ($data[0]->holidayoff) {
                $holidayoff = explode('||', $data[0]->holidayoff);
                $data[0]->holidayoff_id = (int) $holidayoff[0];
                $data[0]->holidayoff_detail = $holidayoff[1];
            } else {
                $data[0]->holidayoff_id = '';
                $data[0]->holidayoff_detail = '';
            }

            return $data[0];
        }
        return false;
    }

    function Duplicationtime($time) {

        if ($time) {
            $t1 = null;
            $t2 = null;
            $txt = null;
            $timearr = explode(',', $time);
            $ct = count($timearr) - 1;
            $i = 0;
            $j = 0;

            if ($ct == 0) {
                $txt = date('Y-m-d H:i:s', strtotime($timearr[$ct]));
                ++$j;
            } else {
                while ($i < $ct) {
                    if ($t1 == NULL) {
                        $t1 = $timearr[$i];
                    }
                    $t2 = $timearr[$i + 1];
                    $chk = $this->Distance_minutes($t1, $t2);

                    if ((int) $chk <= 5) {
                        $t1 = $t2;
                    } else {

                        if ($j === 0) {
                            $txt = date('Y-m-d H:i:s', strtotime($t1));
                            $j++;
                        }
                        $txt .= "__" . date('Y-m-d H:i:s', strtotime($t2));
                        $t1 = $t2;
                        ++$j;
                    }


                    ++$i;
                }
            }
            return array('time_count' => $j, 'time' => $txt);
        }
        return false;
    }

    function Distance_minutes($t1, $t2) {
        if ($t1 && $t2) {
            $time = Intval(strtotime($t2) - strtotime($t1));
            return floor($time / 60);
        }
        return false;
    }

    function Grouptime($uid = null) {
        if ($uid) {
            $time = DB::connection($this->db)->select('SELECT '
                    . 'uid,count(distinct work_time) as ct,substr(work_time,1,10) as ddate, group_concat(distinct work_time ORDER BY id) as ttime'
                    . ' FROM attendance_upload GROUP BY uid,DATE(work_time) HAVING uid = ' . $uid); //WHERE state = 0

            if ($time) {
                return $time;
            }
        }
        return false;
    }

    function Employee_data($uid) { //
        if ($uid) {
            $emp_data = DB::connection($this->db)->select('SELECT '
                    . 'a.id,a.id_emp,a.empcode,IF(a.group_me IS NULL OR a.group_me = "",a.group_condition,a.group_me) AS emp_group,a.dept_id,a.prefix,firstname,a.lastname,a.sex,a.position,a.idcard as id_card,a.paytype,a.payrate,a.wage,a.extrawage,a.extrawage_status,a.technicialwage,a.technicialwage_status,a.weekendotorday,a.date_working,picture,'
                    . 'b.status_day,b.status_night,b.status_night_time,b.name as dept_name,b.code as dept_code'
                    . ' FROM data_employee a LEFT JOIN data_department b ON a.dept_id = b.id  WHERE a.empcode = ' . $uid);
            if ($emp_data) {
                return $emp_data[0];
            }
        }
        return false;
    }

    public function remove_time($id, $time) {

        if ($id) {
            $rs = DB::connection($this->db)->update('update attendance_raw set dtime = "' . $time . '",count_time = ' . count(explode(',', $time)) . ' where id = ' . $id);
            if ($rs) {
                return true;
            }
        }
        return false;
    }

    public function getCondition() {
        $data = DB::connection($this->db)->select('SELECT * FROM config_condition_time ORDER BY `group`,counttime ASC');
        if ($data) {
            return json_encode($data);
        }
        return false;
    }

    public function getRaw($empcode = null) {

        if ($empcode) {

            $data = DB::connection($this->db)->select('SELECT *,DAYNAME(ddate) as name_date FROM attendance_raw WHERE empcode = ' . $empcode . ' AND state = 0 ORDER BY id');

            if ($data) {

                $data = json_encode($data);
                return $data;
            }
        }
        return false;
    }

    public function insert_view($data = null) {

        if ($data) {
            foreach ($data as $val) {
                $insert_id = DB::connection($this->db)->table('attendance_view')->insert(get_object_vars($val));
            }
            return true;
        }
        return false;
    }

    public function getDept() {
        $data = DB::connection($this->db)->select('SELECT id,name from data_department where state = 1');
        if ($data) {
            return $data;
        }
    }

    public function getSearch_employee($text = null) {
        if ($text) {

            $data = DB::connection($this->db)->select('SELECT empcode as id,prefix,firstname,lastname from data_employee where '
                    . 'state = 1 AND (empcode LIKE "' . $text . '%" OR firstname LIKE "' . $text . '%" OR lastname LIKE "' . $text . '%")'
            );

            if ($data) {
                return $data;
            } else {
                return '';
            }
        }
        return false;
    }

    public function destroy_view($data) {
        if ($data) {
            $date = explode(' - ', $data['date_length']);
            if ($data['type_delete'] == 1) { //remove All
                $rs = DB::connection($this->db)->delete('DELETE FROM attendance_view WHERE DATE(ddate) BETWEEN "' . $date[0] . '" AND "' . $date[1] . '"');
            } else if ($data['type_delete'] == 2) { //remove by Department
                $rs = DB::connection($this->db)->delete('DELETE FROM attendance_view WHERE DATE(ddate) BETWEEN "' . $date[0] . '" AND "' . $date[1] . '" AND dept_id = ' . $data['department']);
            } else if ($data['type_delete'] == 3) { //remove by Employee Code
                $rs = DB::connection($this->db)->delete('DELETE FROM attendance_view WHERE DATE(ddate) BETWEEN "' . $date[0] . '" AND "' . $date[1] . '" AND empcode = ' . $data['employee_id']);
            }

            if ($rs) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function data_log($data = null) {
        echo 'abc';
        exit;
        if ($data) {
            $rs = DB::connection($this->db)->table('file_log')->insert($data);
            if ($rs) {
                return true;
            }
        }
        return false;
    }

}
