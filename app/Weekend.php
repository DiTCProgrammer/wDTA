<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Weekend extends Model {

    protected $weekend = 'config_weekend_company';
    protected $department = 'config_weekend_department';
    protected $data_department = 'data_department';
    protected $db = 'dta_1';

    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    function getWeekend($table, $where) {
        $conn = $this->conn();
        $q = $conn->table($table);
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['N'], $row['M'], $row['W']);
            }
        }
        return $q->get();
    }

    function getWeekendGroup($table, $where, $group) {
        $conn = $this->conn();
        $q = $conn->table($table);
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['N'], $row['M'], $row['W']);
            }
        }
        $q->groupBy($group);
        return $q->get();
    }

    function InsertWeekend($data, $table) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->insert($data);
        return TRUE;
    }

    function UpdateWeekend($data, $table, $id) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }

    function DestroyWeekend($id, $table) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->where('id', $id);
        $q->update(['state' => 0]);
        return TRUE;
    }

    //**********************************************************************************************************************
    function getWeekendDepertment($where) {
        $conn = $this->conn();
        $q = $conn->table($this->department);
        $q->where($this->department . '.state', '=', 1);
        if ($where) {
            foreach ($where as $row) {
                $q->where($this->department . '.' . $row['N'], $row['M'], $row['W']);
            }
        }
        $q->join($this->data_department, "$this->department.dep_id", '=', "$this->data_department.id");
        $q->select($this->department . '.*', $this->data_department . '.name');

        return $q->get();
    }

    function DestroyDelWeekend($id, $table) {
        $conn = $this->conn();
        $q = $conn->table($table);
        $q->where('id', $id);
        $q->delete();
        return TRUE;
    }

}
