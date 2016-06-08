<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Department extends Model {

    protected $department = 'data_department';
    protected $db = 'dta_1';

    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }

    function Select_All($table, $where, $search) {
        $conn = $this->conn();
        $q = $conn->table($table);
        if ($where) :
            foreach ($where as $row) :
                $q->where($row['N'], $row['M'], $row['W']);
            endforeach;
        endif;

        if ($search != null) {
            $q->WhereRaw('(code LIKE "' . $search . '%" OR name LIKE "' . $search . '%")');
        }
        return $q->get();
    }

    function InsertDepartment($data) {
        $conn = $this->conn();
//        $conn->beginTransaction();
        $q = $conn->table($this->department);
        $q->insert($data);
//        $q->commit();
        return TRUE;
    }

    function UpdateDepartment($data, $id) {
        $conn = $this->conn();
        $q = $conn->table($this->department);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }

    function DestroyDepartment($id) {
        $conn = $this->conn();
        $q = $conn->table($this->department);
        $q->where('id', $id);
        $q->update(['state' => 0]);
        return TRUE;
    }

}
