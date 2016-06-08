<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Employee extends Model {

    protected $table = 'data_employee';
    protected $department = 'data_department';
    protected $users = 'users';
    protected $db = 'dta_1';
    protected $db_central = 'dta_central';

     function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }
    
    function Select_Department() {
        $conn = $this->conn();
        $q = $conn->table($this->department);
     
        return $q->get();
    }

    function getCentral($id) {
        $q = DB::table($this->users);
        $q->where('id', $id);

        return $q->get();
    }

    function InsertUserEmployee($data) {
        $q = DB::table($this->users);
        return $q->insertGetId($data);
    }

    function UpdateEmployeeCentral($data, $id) {
        $q = DB::table($this->users);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }

    function InsertEmployee_SQL_1($data) {
        $conn = $this->conn();
        $q = $conn->table($this->table);
       // $q->insert($data);
        return $q->insertGetId($data);
       // return TRUE;
    }

    function Select_All($table, $where) {
        $conn = $this->conn();
        $q = $conn->table($table);
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['N'], $row['M'], $row['W']);
            }
        }
        return $q->paginate(10);
    }

    function Select_Checkemp($table, $where) {
        $conn = $this->conn();
        $q = $conn->table($table);
        if ($where) {
            foreach ($where as $row) {
                $q->where($row['N'], $row['M'], $row['W']);
            }
        }

        return $q->get();
    }

    function Select_Group($table, $where, $group) {
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

    function InsertEmployee($data) {
        $conn = $this->conn();
//        $conn->beginTransaction();
        $q = $conn->table($this->table);
        $q->insert($data);
//        $q->commit();
        return TRUE;
    }

    function UpdateEmployee($data, $id) {
        $conn = $this->conn();
        $q = $conn->table($this->table);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }

    function DestroyEmployee($id) {
        $conn = $this->conn();
        $q = $conn->table($this->table);
        $q->where('id', $id);
        $q->update(['state' => 0]);
        
        $q2 = DB::table($this->users);
        $q2->where('id', $id);
        $q2->update(['privilege' => 0]);
        return TRUE;
    }

}
