<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Absence extends Model {

    protected $absence = 'config_absence';
    protected $condition_time= 'config_condition_time';
                function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    function getAbsence() {
        $conn = $this->conn();
        $q = $conn->table($this->absence);
        $q->where('state', '=', '1');
        return $q->get();
    }
    
    function getGroup_Condition(){
        $conn = $this->conn();
        $q = $conn->table($this->condition_time);    
        $q->select('group');
        $q->groupBy('group');
        return $q->get();
    }
    
    function getAbsenceId($id){
        $conn = $this->conn();
        $q = $conn->table($this->absence);
        $q->where('id', '=', $id);
        return $q->get();
    }
    
    function InsertAbsence($data) {
        $conn = $this->conn();
        $q = $conn->table($this->absence);
        $q->insert($data);
        return TRUE;
    }

    function DestroyAbsence($id) {
        $conn = $this->conn();
        $q = $conn->table($this->absence);
        $q->where('id', $id);
        $q->delete();
        return TRUE;
    }
    function UpdateAbsence($data, $id) {
       $conn = $this->conn();
        $q = $conn->table($this->absence);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }

}
