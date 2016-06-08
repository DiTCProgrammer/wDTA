<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class AbsenceImportExport extends Model {

    protected $absence = 'config_absence';
    
    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }
    
    public function getSample() {

        $sql = 'SELECT * FROM `data_employee_absence_sample`';

        $result = DB::select($sql);

        if ($result) {
            $row = $result;
        } else {
            $row = '';
        }

        return $row;
    }
    
    public function getEmployee() {
        $conn = $this->conn();

        $sql = 'SELECT id,empcode,dept_id,prefix,firstname,lastname FROM `data_employee`';
        $sql .= ' WHERE state=1';
        $sql .= ' ORDER BY `empcode` ASC';

        $result = $conn->select($sql);

        if ($result) {
            $row = $result;
        } else {
            $row = '';
        }

        return $row;
    }

    public function getAbsence() {
        $conn = $this->conn();

        $sql = 'SELECT * FROM `config_absence`';
        $sql .= ' WHERE state=1';

        $result = $conn->select($sql);

        if ($result) {
            $row = $result;
        } else {
            $row = '';
        }

        return $row;
    }

}