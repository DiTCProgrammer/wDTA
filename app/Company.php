<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Company extends Model
{
    protected $company = 'config_company';
    protected $db = 'dta_1';
    
    function conn() {
        return DB::connection('dta_' . Auth::user()->company_id);
    }  
    
    function SelectCompany() {
       
        $conn =  $this->conn();
        $q = $conn->table($this->company);       
        return $q->get();
    }
    
     function UpdateCompany($data, $id) {
        $conn =  $this->conn();
        $q = $conn->table($this->company);
        $q->where('id', $id);
        $q->update($data);
        return TRUE;
    }
    
}