<?php //

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Dataoverview extends Model {

    protected $tb = 'data_department';

    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    function getdept($table, $where, $search) {

        $conn = $this->conn();
        $q = $conn->table($table);
        //$q->select(DB::raw('MIN(ddate) AS rank1'), 'description', 'group', DB::raw('MAX(ddate) AS rank2'));
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['col'], $row['opt'], $row['val']);
            }
        }
        if ($search != null) {
            $q->WhereRaw('(code LIKE "' . $search . '%" OR name LIKE "' . $search . '%")');
        }

        return $q->get();
    }

//    function getusers($table, $where, $search, $ddate) {
//        
//        $date = explode(' - ',$ddate);
//
//        $conn = $this->conn();
//        $q = $conn->table($table);
//        $q->select(
//                DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' THEN stthalfday ELSE 0 END) AS workingday'), 
//                DB::raw('SUM(CASE WHEN timein1 IS NULL AND holidayoff_id = \'0\' AND holidaybus_id = \'0\' AND weekendcompany = \'0\' AND weekenddept = \'0\' AND status_error = \'0\' AND abs_id = \'0\' THEN 1 ELSE 0 END) AS absence'),
//                DB::raw('SUM(CASE WHEN abs_id > \'0\' THEN 1 ELSE 0 END) AS absence_comment'),
//                DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' AND late > \'0\' THEN stthalfday ELSE 0 END) AS late'),
//                DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' AND late > \'0\' THEN late ELSE 0 END) AS latetotal'),
//                DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' AND ot > \'0\' THEN ot+bot ELSE 0 END) AS ottotal')
//                );
//        if ($where) {
//            foreach ($where as $row) {
//                $q->where($row['col'], $row['opt'], $row['val']);
//            }
//        }
//        
//        if ($search != null) {
//            $q->WhereRaw('DATE(ddate) BETWEEN "' . $date[0] . '" AND "' . $date[1] . ' AND "(empcode LIKE "' . $search . '%" OR firstname LIKE "' . $search . '% OR lastname LIKE "' . $search . '%")');
//        }
//        
//        $q->groupBy('empcode');
//        
//        return $q->get();
//        
//    }


    function getusers($table, $where, $date1, $date2) {

        $conn = $this->conn();
        $q = $conn->table($table);
        $q->select(
                DB::raw('empcode,prefix,firstname,lastname,picture,dept_id'), DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' THEN stthalfday ELSE 0 END) AS workingday'), DB::raw('SUM(CASE WHEN timein1 IS NULL AND holidayoff_id = \'0\' AND holidaybus_id = \'0\' AND weekendcompany = \'0\' AND weekenddept = \'0\' AND status_error = \'0\' AND abs_id = \'0\' THEN 1 ELSE 0 END) AS absence'), DB::raw('SUM(CASE WHEN abs_id > \'0\' THEN 1 ELSE 0 END) AS absence_comment'), DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' AND late > \'0\' THEN stthalfday ELSE 0 END) AS late'), DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' AND late > \'0\' THEN late ELSE 0 END) AS latetotal'), DB::raw('SUM(CASE WHEN timein1 IS NOT NULL AND abs_id = \'0\' AND ot > \'0\' THEN ot+bot ELSE 0 END) AS ottotal')
        );
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['col'], $row['opt'], $row['val']);
            }
        }


        $q->WhereRaw('DATE(ddate) BETWEEN "' . $date1 . '" AND "' . $date2 . '"');


        $q->groupBy('empcode');

        return $q->get();
    }

    function user_search() {
        
    }

    function getuser($table, $empcode, $dept_id, $date) {
        $date = explode(' - ', $date);
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->select(
                DB::raw('*')
        );
        
        $q->where('empcode','=',$empcode);
        $q->where('dept_id','=',$dept_id);
        $q->whereBetween('ddate',[$date[0],$date[1]]);
        $q->orderBy('ddate','ASC');
        
       return $q->get();
    }
    


}
