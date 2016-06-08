<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Scheduletime extends Model {

    protected $condition_time = 'config_condition_time';
    protected $department = 'data_department';
    protected $db = 'dta_1';

    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    function UpdateScheduletimeDepartment($data, $id) {
        $conn = $this->conn();
        $q = $conn->table($this->department);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }

    function DestroyScheduletime($id) {
        $conn =  $this->conn();
        $q = $conn->table($this->condition_time);
        $q->where('id', $id);
        $q->delete();
        return TRUE;
    }

    function DestroyScheduletimeDep($id) {
        $conn =  $this->conn();
        $q = $conn->table($this->department);
        $q->where('id', $id);
        $q->update(['group_condition' => '']);
        return TRUE;
    }

    function getCondition_Time() {
        $conn =  $this->conn();
        $q = $conn->table($this->condition_time);
        return $q->get();
    }

    function getCondition_Time_ID($id) {
        $conn =  $this->conn();
        $q = $conn->table($this->condition_time);
        $q->where('id', $id);
        return $q->get();
    }

    function getDepartmentAll() {
        $conn =  $this->conn();
        $q = $conn->table($this->department);
//        $q->where('group_condition', '=', '');
        return $q->get();
    }

    function InsertScheduletime($data, $table) {
        $conn =  $this->conn();
        $q = $conn->table($table);
        $q->insert($data);
        return TRUE;
    }

    function UpdateScheduletime($data, $table, $id) {
        $conn =  $this->conn();
        $q = $conn->table($table);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }

}
