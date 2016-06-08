<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;


class Holiday extends Model {

    protected $business = 'config_holiday_business';
    protected $official = 'config_holiday_official';
    protected $department = 'data_department';
    protected $db = 'dta_1';

   function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    function getHoliday1($table, $where) {

        $conn = $this->conn();
        $q = $conn->table($table);
        $q->select(DB::raw('MIN(ddate) AS rank1'), 'description', 'group', DB::raw('MAX(ddate) AS rank2'));
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['N'], $row['M'], $row['W']);
            }
        }

        $q->groupBy('group');
        return $q->get();
    }

    function getHoliday2($table, $where) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->select(DB::raw('MIN(ddate) AS rank1'), 'description', 'dept_name', 'group', DB::raw('MAX(ddate) AS rank2'));
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['N'], $row['M'], $row['W']);
            }
        }

        $q->groupBy('group');
        return $q->get();
    }

    function getDepartment() {
        $conn = $this->conn();
        $q = $conn->table($this->department);
        $q->where('group_condition', '!=', '');
        return $q->get();
    }

    function getHoliday_Official() {
        $conn = $this->conn();
        $q = $conn->table($this->official);
        return $q->max('group');
    }

    function getHoliday_Business() {
        $conn = $this->conn();
        $q = $conn->table($this->business);
        return $q->max('group');
    }

    function InsertHoliday($data, $table) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->insert($data);
        return TRUE;
    }

    function DestroyDelHoliday($id, $table) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->where('group', $id);
        $q->delete();
        return TRUE;
    }

}
