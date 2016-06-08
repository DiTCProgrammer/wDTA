<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Attendance;
use DB;

class DeleteController extends Controller {
    
    public function __construct() {
        $this->middleware('adminhr');
        \Debugbar::disable();
    }

    public function index() {
        $model = new Attendance();
        $rs = $model->getDept();
        return view('/attendance/delete', ['dept_data' => $rs]);
    }

    public function search_employee(Request $request) {

        if ($request->text) {

            $model = new Attendance();
            $rs = $model->getSearch_employee($request->text);

            if ($rs) {
                return json_encode($rs);
            }
        }
    }

    public function test() {

        $model = new Attendance();
        $rs = $model->getSearch_employee('นาย');
        echo $rs;
    }

    public function destroy(Request $request) {
          echo $request->type_delete;exit;
//        echo '<pre>';
//        print_r($request);
//        echo '</pre>';
        
    }

}
