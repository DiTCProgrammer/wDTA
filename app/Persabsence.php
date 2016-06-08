<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Persabsence extends Model {

    protected $absence = 'config_absence';
    protected $employee_absence = 'data_employee_absence';
    protected $employee = 'data_employee';
    protected $db = 'dta_1';

    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    function getPersabsence($state, $dept, $ddate, $status) {
        $conn = $this->conn();
        $q = $conn->table($this->employee_absence);
        $q->select(DB::raw("MIN($this->employee_absence.ddate) AS rank1"), DB::raw("MAX($this->employee_absence.ddate) AS rank2"), "$this->employee_absence.comment", "$this->employee_absence.empcode", "$this->employee_absence.group", "$this->employee_absence.attfile", "$this->employee.firstname", "$this->employee.lastname", "$this->employee_absence.status_name");

        if ($state == 1) :
            if ($status != Null) :
                $q->where("$this->employee_absence.state", '=', $status);
            endif;

            if ($dept != Null && $dept) :

                $q->where("$this->employee_absence.dept_id", '=', $dept);
            endif;

            if ($ddate != Null) :
                $q->whereBetween("$this->employee_absence.ddate", array($ddate[0], $ddate[1]));
            endif;
        endif;

        $q->join($this->employee, "$this->employee_absence.uid", '=', "$this->employee.id");
        $q->groupBy("$this->employee_absence.group");
        return $q->paginate(20);
    }

    function getMypersabsence($state, $ddate, $status) {
        if (Auth::user()->id) {
            $conn = $this->conn();
            $q = $conn->table($this->employee_absence);
            $q->select(DB::raw("MIN($this->employee_absence.ddate) AS rank1"), DB::raw("MAX($this->employee_absence.ddate) AS rank2"), "$this->employee_absence.comment", "$this->employee_absence.empcode", "$this->employee_absence.group", "$this->employee_absence.attfile", "$this->employee.firstname", "$this->employee.lastname", "$this->employee_absence.status_name");
            $q->where("$this->employee_absence.uid", '=', Auth::user()->id);

            if ($state == 1) {
                if ($status != Null) {
                    $q->where("$this->employee_absence.state", '=', $status);
                }
                if ($ddate != Null) {
                    $q->whereBetween("$this->employee_absence.ddate", array($ddate[0], $ddate[1]));
                }
            }

            $q->join($this->employee, "$this->employee_absence.uid", '=', "$this->employee.id");
            $q->groupBy("$this->employee_absence.group");
            return $q->paginate(20);
        }
        return false;
    }

    function InsertPersabsence($data, $table) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->insert($data);
        return TRUE;
    }

    function searchPersabsence($data) {
        $conn = $this->conn();
        $q = $conn->table($this->employee);
        $q->select('id', 'empcode', 'firstname', 'lastname');
        $q->where("empcode", 'LIKE', '%' . $data . '%');
        $q->orwhere("firstname", 'LIKE', '%' . $data . '%');
        $q->orwhere("lastname", 'LIKE', '%' . $data . '%');

        return $q->get();
    }

    function getAbsence() {
        $conn = $this->conn();
        $q = $conn->table($this->absence);
        $q->where("state", '=', 1);
        return $q->get();
    }

    function getPersabsence_Group() {
        $conn = $this->conn();
        $q = $conn->table($this->employee_absence);
        return $q->max('group');
    }

    function DestroyDelPersabsence($id, $table) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->where('group', $id);
        $q->delete();
        return TRUE;
    }

    function getDepartment() {

        $data = $this->conn()->select('SELECT id,name FROM data_department WHERE state = 1');

        if ($data) {
            return $data;
        }
        return false;
    }

    function getPage() {
        $conn = $this->conn();
        $q = $conn->table('data_employee');
        return $q->paginate(15);
    }

    public function getSearch_employee($text = null) {
        if ($text) {

            $data = $this->conn()->select('SELECT id as uid,empcode as empcode,prefix,firstname,lastname,dept_id from data_employee where '
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

    public function import_data($data) {
        if ($data) {
            $this->conn()->beginTransaction();
            try {
                $this->conn()->table('data_employee_absence')->insert($data);
                $this->conn()->commit();
                return true;
            } catch (\Exception $e) {
                $this->conn()->rollBack();
                throw $e;
            }
        }
        return false;
    }

}
