<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Department;
use Image;
use DB;

class DepartmentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('adminhr');
        \Debugbar::disable();
    }

    function view(Request $request) {
        $search = null;
        $input = $request->input();
        if ($input) {
            $search = $input['search'];
        }
        $dep = new Department;
        $where = array(['N' => 'state', 'M' => '=', 'W' => 1]);
        $dataDep = $dep->Select_All('data_department', $where, $search);
        return view('management/department/view', ['dataDep' => $dataDep, 'search' => $search]);
    }

//    public function index() {
//
//        $dep = new Department;
//        $where = array(['N' => 'state', 'M' => '=', 'W' => 1]);
//        $dataDep = $dep->Select_All('data_department', $where);
//        return view('management/department/view', ['dataDep' => $dataDep]);
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        \Debugbar::disable();
        $objScan = scandir('images/icon');
        $x = 0;
        while ($x < count($objScan)) :
            if ($x > 2) {
                $objScans[] = $objScan[$x];
            }
            $x++;
        endwhile;

        return view('management/department/create', ['objScan' => $objScans]);
    }

    function checkemp(Request $request) {
        $search = NULL;
        $dep_input = $request->data;
        $dep = new Department;
        $where = array(['N' => 'code', 'M' => '=', 'W' => $dep_input], ['N' => 'state', 'M' => '=', 'W' => 1]);
        $employee_emp = $dep->Select_All('data_department', $where,$search);
        if ($employee_emp):
            return 'TRUE';
        else:
            return 'FALSE';
        endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
       $search = NULL;
//        $employee_emp = '';
        $dep = new Department;
        if ($id != null) :
            $where = array(['N' => 'id', 'M' => '=', 'W' => $id]);
            $department_dep = $dep->Select_All('data_department', $where,$search);
        endif;
        $night_time = explode(':', $department_dep[0]->status_night_time);
        $t1 = 0;
        while ($t1 <= 23) :
            $data_time_h[$t1] = sprintf("%02d", $t1);
            $t1++;
        endwhile;
        $t2 = 0;
        while ($t2 <= 59) :
            $data_time_m[$t2] = sprintf("%02d", $t2);
            $t2++;
        endwhile;
        $objScan = scandir('images/icon');
        $x = 0;
        while ($x < count($objScan)) :
            if ($x > 2) {
                $objScans[] = $objScan[$x];
            }
            $x++;
        endwhile;
        return view('management/department/edit', ['objScan' => $objScans, 'Dep' => $department_dep, 'time_h' => $data_time_h, 'h1' => $night_time[0], 'time_m' => $data_time_m, 'm1' => $night_time[1]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null) {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'status_night' => 'required',
            'icon' => 'required'
        ]);
        $night_time = $request->input('time_h') . ':' . $request->input('time_m') . ':00';
        $ins_data = ['code' => $request->input('code'),
            'name' => $request->input('name'),
            'status_night' => $request->input('status_night'),
            'icon' => $request->input('icon'),
            'status_day' => 1,
            'state' => 1,
            'group_condition' => '',
            'status_night_time' => $night_time
        ];
        $dep = new Department;
        if ($id == null) :

            $dep->InsertDepartment($ins_data);
        else:
            $dep->UpdateDepartment($ins_data, $id);
        endif;
        return redirect('department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $dep = new Department;
        $dep->DestroyDepartment($id);
        return redirect('department');
    }

}
