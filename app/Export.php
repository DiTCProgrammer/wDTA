<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Export extends Model {

    protected $connection = 'db';
    protected $db = 'dta_1';

    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    public function getDept() {
        $data = $this->conn()->select('SELECT id,name from data_department where state = 1');
        if ($data) {
            return $data;
        }
    }

    public function Employee($DateStart = null, $DateEnd = null, $dept = null, $employee_id = null) {

        $conn = $this->conn();

        $sql = 'SELECT *, ';
        $sql .= ' CASE paytype WHEN 2 THEN wage ELSE payrate END AS salary,';
        $sql .= ' CASE technicialwage_status WHEN 1 THEN technicialwage ELSE \'-\' END AS tech,';
        $sql .= ' SUM(CASE WHEN timein1 IS NOT NULL AND holidayoff_id = \'0\' AND holidaybus_id = \'0\' AND weekendcompany = \'0\' AND weekenddept = \'0\' AND status_error = \'0\' AND abs_id = \'0\' THEN stthalfday ELSE 0 END) AS workingdayreal, ';
        $sql .= ' SUM(CASE WHEN timein1 IS NOT NULL AND weekendcompany = \'0\' AND weekenddept = \'0\' AND status_error = \'0\' AND abs_id = \'0\' THEN stthalfday ELSE 0 END) AS workingday, ';
        $sql .= ' SUM(CASE WHEN timein1 IS NOT NULL AND (weekendcompany = \'1\' OR weekenddept = \'1\') AND status_error = \'0\' AND abs_id = \'0\' THEN 1 ELSE 0 END) AS weekend, ';
        $sql .= ' SUM(CASE WHEN timein1 IS NOT NULL AND (holidayoff_id = \'1\' OR holidaybus_id = \'1\') AND status_error = \'0\' AND abs_id = \'0\' THEN 1 ELSE 0 END) AS holiday, ';
        $sql .= ' SUM(CASE WHEN paytype=\'2\' AND `condition` IS NOT NULL THEN (wage/8/60)*OT_1_rate*OT_1 WHEN paytype=\'1\' AND `condition` IS NOT NULL THEN (payrate/30/8/60)*OT_1_rate*OT_1 ELSE 0 END) AS pay2_ot1,';
        $sql .= ' SUM(CASE WHEN paytype=\'2\' AND `condition` IS NOT NULL THEN (wage/8/60)*OT_2_rate*OT_2 WHEN paytype=\'1\' AND `condition` IS NOT NULL THEN (payrate/30/8/60)*OT_2_rate*OT_2 ELSE 0 END) AS pay2_ot2,';
        $sql .= ' SUM(CASE WHEN paytype=\'2\' AND `condition` IS NOT NULL THEN (wage/8/60)*OT_3_rate*OT_3 WHEN paytype=\'1\' AND `condition` IS NOT NULL THEN (payrate/30/8/60)*OT_3_rate*OT_3 ELSE 0 END) AS pay2_ot3,';
        $sql .= ' SUM(CASE WHEN paytype=\'2\' AND `condition` IS NOT NULL THEN (wage/8/60)*OT_4_rate*OT_4 WHEN paytype=\'1\' AND `condition` IS NOT NULL THEN (payrate/30/8/60)*OT_4_rate*OT_4 ELSE 0 END) AS pay2_ot4,';
        $sql .= ' CASE WHEN SUM(OT_1) <> 0 THEN SUM(OT_1) ELSE \'-\' END AS ot10, ';
        $sql .= ' CASE WHEN SUM(OT_2) <> 0 THEN SUM(OT_2) ELSE \'-\' END AS ot15, ';
        $sql .= ' CASE WHEN SUM(OT_3) <> 0 THEN SUM(OT_3) ELSE \'-\' END AS ot20, ';
        $sql .= ' CASE WHEN SUM(OT_4) <> 0 THEN SUM(OT_4) ELSE \'-\' END AS ot30, ';
        $sql .= ' SUM(late) late';
        $sql .= ' FROM `attendance_view`';
        $sql .= ' WHERE 1';

        if ($DateStart && $DateEnd) {
            $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
        }

        if ($dept) {
            $sql .= ' AND dept_id = \'' . $dept . '\'';
        }

        if ($employee_id) {
            $sql .= ' AND empcode = \'' . $employee_id . '\'';
        }

        $sql .= ' GROUP BY uid';
        $sql .= ' ORDER BY `empcode` ASC';

//        echo $sql;
//        exit();

        $result = $conn->select($sql);
        if ($result) {
            $row['data'] = $result;
        } else {
            $row['data'] = '';
        }

        //Error
        $conn = $this->conn();

        $sql = 'SELECT * ';
        $sql .= ' FROM `attendance_view`';
        $sql .= ' WHERE 1';

        if ($DateStart && $DateEnd) {
            $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
        }

        if ($dept) {
            $sql .= ' AND dept_id = \'' . $dept . '\'';
        }

        if ($employee_id) {
            $sql .= ' AND empcode = \'' . $employee_id . '\'';
        }

        $sql .= ' AND weekendcompany != \'1\' ';
        $sql .= ' AND status_error = \'1\' ';
        $sql .= ' ORDER BY `empcode`,`ddate` ASC';

        $result = $conn->select($sql);
        if ($result) {
            $row['error'] = $result;
        } else {
            $row['error'] = '';
        }
        
        //Absence
        $conn = $this->conn();

        $sql = 'SELECT * ';
        $sql .= ' FROM `attendance_view`';
        $sql .= ' WHERE 1';

        if ($DateStart && $DateEnd) {
            $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
        }

        if ($dept) {
            $sql .= ' AND dept_id = \'' . $dept . '\'';
        }

        if ($employee_id) {
            $sql .= ' AND empcode = \'' . $employee_id . '\'';
        }
        
//        $sql .= ' AND timein1 = \'00:00:00\'';
//        $sql .= ' AND timein1 IS NULL';
        $sql .= ' AND holidayoff_id = \'0\'';
        $sql .= ' AND holidaybus_id = \'0\'';
        $sql .= ' AND weekendcompany = \'0\'';
        $sql .= ' AND weekenddept = \'0\'';
        $sql .= ' AND abs_id = \'1\'';
        $sql .= ' AND status_error = \'0\'';
        
        $sql .= ' ORDER BY `empcode`,`ddate` ASC';

        $result = $conn->select($sql);
        if ($result) {
            $row['absence'] = $result;
        } else {
            $row['absence'] = '';
        }
        
        //OT Group
        $conn = $this->conn();

        $sql = 'SELECT * ';
        $sql .= ' FROM `attendance_view`';
        $sql .= ' WHERE 1';

        if ($DateStart && $DateEnd) {
            $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
        }

        if ($dept) {
            $sql .= ' AND dept_id = \'' . $dept . '\'';
        }

        if ($employee_id) {
            $sql .= ' AND empcode = \'' . $employee_id . '\'';
        }
        
        $sql .= ' GROUP BY dept_id';
        $sql .= ' ORDER BY `dept_id` ASC';

        $result = $conn->select($sql);
        if ($result) {
            $row['otgroup'] = $result;
        } else {
            $row['otgroup'] = '';
        }

        return $row;
    }

    public function WorkingDay($id, $DateStart = null, $DateEnd = null) {
        $conn = $this->conn();

        $sql = 'SELECT * FROM `attendance_view`';
        $sql .= ' WHERE 1';
        if ($id) {
            $sql .= ' AND `uid` = \'' . $id . '\'';
            if ($DateStart && $DateEnd) {
                $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
            }
//            $sql .= ' AND timein1 != \'00:00:00\' ';
            $sql .= ' AND timein1 IS NOT NULL ';
            $sql .= ' AND holidayoff_id = \'0\' ';
            $sql .= ' AND holidaybus_id = \'0\' ';
            $sql .= ' AND weekendcompany = \'0\' ';
            $sql .= ' AND weekenddept = \'0\' ';
            $sql .= ' AND abs_id = \'0\' ';
            $sql .= ' AND status_error = \'0\' ';
        }
        $sql .= ' ORDER BY `ddate` ASC';

        $result = $conn->select($sql);

        if ($result) {
            $row = COUNT($result);
        } else {
            $row = '';
        }

        return $row;
    }

    public function SunDay($id, $DateStart = null, $DateEnd = null) {
        $conn = $this->conn();

        $sql = 'SELECT * FROM `attendance_view`';
        $sql .= ' WHERE 1';
        if ($id) {
            $sql .= ' AND `uid` = \'' . $id . '\'';
            if ($DateStart && $DateEnd) {
                $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
            }
            $sql .= ' AND weekendcompany = \'0\' ';
            $sql .= ' AND weekenddept = \'0\' ';
            $sql .= ' AND status_error = \'0\' ';
        }
        $sql .= ' ORDER BY `ddate` ASC';

        $result = $conn->select($sql);

        if ($result) {
            $row = COUNT($result);
        } else {
            $row = '';
        }

        return $row;
    }

}

//        $data = $conn->table('attendance_view')
//                ->select('id')
//                ->get();

/*//Sum Employee ID
        $conn = $this->conn();

        $sql = 'SELECT * FROM `attendance_view`';
        $sql .= ' WHERE 1';
        if ($DateStart && $DateEnd) {
            $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
        }
        $sql .= ' AND status_error = \'0\' ';
        $sql .= ' GROUP BY uid';
        $sql .= ' ORDER BY `empcode` ASC';

        $result = $conn->select($sql);
        if ($result) {
            $row['sumemployeeid'] = COUNT($result);
        } else {
            $row['sumemployeeid'] = '';
        }

        //Sum Working Day
        $conn = $this->conn();

        $sql = 'SELECT * FROM `attendance_view`';
        $sql .= ' WHERE 1';
        if ($DateStart && $DateEnd) {
            $sql .= ' AND ddate BETWEEN \'' . $DateStart . '\' AND \'' . $DateEnd . '\' ';
        }
        $sql .= ' AND holidayoff_id = \'0\' ';
        $sql .= ' AND holidaybus_id = \'0\' ';
        $sql .= ' AND weekendcompany = \'0\' ';
        $sql .= ' AND weekenddept = \'0\' ';
        $sql .= ' AND status_error = \'0\' ';
        $sql .= ' GROUP BY uid';
        $sql .= ' ORDER BY `empcode` ASC';

        $result = $conn->select($sql);

        if ($result) {
            $row['sumworkingday'] = COUNT($result);
        } else {
            $row['sumworkingday'] = '';
        }
 * 
 */