<?php

namespace App\Http\Controllers\management;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Employee;
//use App\Http\Requests\StoreEmployeeRequest;
use Image;
use DB;
use Auth;

class EmployeeController extends Controller {

    public function __construct() {
        $this->middleware('HR');
        \Debugbar::disable();
    }

    function createuser() {
        $emp = new Employee;

        $prefix['นาย'] = 'นาย';
        $prefix['นางสาว'] = 'นางสาว';
        $prefix['นาง'] = 'นาง';

        $dataEmp['1'] = 'Employee';
        $dataEmp['2'] = 'Head of dept';
        $dataEmp['3'] = 'HR';
        $dataEmp['4'] = 'Mangger';
        $dataList = $emp->Select_Department();
        foreach ($dataList as $row):
            $dataLists[$row->id . ':' . $row->name] = $row->name;
        endforeach;
        return view('management/employee/createuser', ['dataEmp' => $dataEmp, 'dataList' => $dataLists, 'prefix' => $prefix]);
    }

    function updateuser(Request $request) {
        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'username' => 'required'
        ]);

        $username = $request->input('username') . '@' . Auth::user()->company_code;
        $dept = '';
        $dept_name = '';

        if ($request->input('privilege') == 2):
            $expdept = explode(':', $request->input('dept'));
            $dept = $expdept[0];
            $dept_name = $expdept[1];

        endif;
        $name = $request->input('firstname') . ' ' . $request->input('lastname');

        $emp = new Employee;

        $ins_sql_central = [ 'name' => $name,
            'email' => $request->input('email'),
            'username' => $username,
            'password' => bcrypt($request->input('password')),
            'username_tmp' => $request->input('username'),
            'company_code' => Auth::user()->company_code,
            'company_id' => Auth::user()->company_id,
            'privilege' => $request->input('privilege'),
            'position_1' => Auth::user()->position_1,
            'position_2' => Auth::user()->position_2,
            'dept' => $dept,
            'dept_name' => $dept_name,
        ];

        $id = $emp->InsertUserEmployee($ins_sql_central);
        $ins_sql_1 = [ 'id' => $id,
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'prefix' => $request->input('prefix'),
            'state' => 1
        ];
        $emp->InsertEmployee_SQL_1($ins_sql_1);
//        
        return redirect('employee/' . $id . '/edit');
    }

    public function index() {
        $emp = new Employee;
        $where = array(['N' => 'state', 'M' => '=', 'W' => 1]);
        $dataEmp = $emp->Select_All('data_employee', $where);

        return view('management/employee/view', ['dataEmp' => $dataEmp]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $emp = new Employee;
        $where_d = array(['N' => 'group_condition', 'M' => '!=', 'W' => '']);
        $department = $emp->Select_All('data_department', $where_d);
        $condition_time = $emp->Select_Group('config_condition_time', $where = null, 'group');

        return view('management/employee/create', ['department' => $department, 'condition_time' => $condition_time]);
    }

    function checkemp(Request $request) {
        $emp_input = json_decode($request->data);
        $emp = new Employee;
        $where = array(['N' => 'empcode', 'M' => '=', 'W' => $emp_input], ['N' => 'state', 'M' => '=', 'W' => 1]);
        $employee_emp = $emp->Select_Checkemp('data_employee', $where);
        if ($employee_emp) :
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
    public function edit($id = null) {
        $employee_emp = '';
        $emp = new Employee;
        if ($id != null):
            $where = array(['N' => 'id', 'M' => '=', 'W' => $id]);
            $employee_emp = $emp->Select_Checkemp('data_employee', $where);
        endif;

        $dataEmp['1'] = 'Employee';
        $dataEmp['2'] = 'Head of dept';
        $dataEmp['3'] = 'HR';
        $dataEmp['4'] = 'Mangger';
        $central = $emp->getCentral($id);
        $where = array(['N' => 'group_condition', 'M' => '!=', 'W' => '']);
        $department = $emp->Select_Checkemp('data_department', $where);

        $dataList = $emp->Select_Department();
        foreach ($dataList as $row):
            $dataLists[$row->id . ':' . $row->name] = $row->name;
        endforeach;

        $data_department = array();
        foreach ($department as $row) :
            $data_department[$row->id . ':' . $row->name . ':' . $row->group_condition] = $row->name;
        endforeach;
        $condition_time = $emp->Select_Group('config_condition_time', $where = null, 'group');
        $data_condition = array();
        foreach ($condition_time as $row) :
            $data_condition[$row->group] = $row->group;
        endforeach;
        return view('management/employee/edit', ['department' => $data_department,
            'condition_time' => $data_condition,
            'emp_data' => $employee_emp,
            'dataEmp' => $dataEmp,
            'central' => $central,
            'dataList' => $dataLists]);
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
            'empcode' => 'required',
            'prefix' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'sex' => 'required',
            'Department' => 'required'
        ]);
        $picture = '';
        if ($request->hasFile('image')) :
            $company_id = Auth::user()->company_id;
            $directory = public_path('file') . '/'.$company_id.'/employee';
            if (!is_dir($directory)) :
                @mkdir($directory, 0777, true);
            endif;
            $filename = str_random(10) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('file') . '/', $filename);
            Image::make(public_path() . '/file/' . $filename)->resize(150, 180)->save($directory . '/' . $filename);

            @unlink(public_path() . '/file/' . $filename);
            $picture = 'file/'.$company_id.'/employee/' . $filename;
        endif;

        $emp = new Employee;
        $Department = explode(':', $request->input('Department'));
        $pay1 = 0;
        $pay2 = 0;
        $extrawage_status = 0;
        $extrawage = 0;
        if ($request->input('paytype')) :
            if ($request->input('paytype') == 1) :
                $pay1 = $request->input('Pay');
                $extrawage_status = $request->input('extrawage_status');
                $extrawage = $request->input('extrawage');
            else:
                $pay2 = $request->input('Pay');
            endif;
        endif;
        if ($request->input('img_edit') && $picture == '') :
            $picture = $request->input('img_edit');
        endif;

        $ins_data = ['empcode' => $request->input('empcode'),
            'prefix' => $request->input('prefix'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'sex' => $request->input('sex'),
            'dept_id' => $Department[0],
            'dept_name' => $Department[1],
            'position' => $request->input('position'),
            'idcard' => $request->input('idcard'),
            'paytype' => $request->input('paytype'),
            'payrate' => $pay1,
            'wage' => $pay2,
            'extrawage' => $extrawage,
            'technicialwage' => $request->input('technicialwage'),
            'date_working' => $request->input('date_working'),
            'picture' => $picture,
            'group_condition' => $Department[2],
            'group_me' => $request->input('group_me'),
            'date_birth' => $request->input('date_birth'),
            'extrawage_status' => $extrawage_status,
            'technicialwage_status' => $request->input('technicialwage_status'),
            'weekendotorday' => $request->input('weekendotorday')
        ];
        $dept = 0;
        $dept_name = '';
        if ($request->input('privilege') == 2):

            $expdept = explode(':', $request->input('dept'));
            $dept = $expdept[0];
            $dept_name = $expdept[1];
        endif;

        $ins_data_central = [
            'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
            'privilege' => $request->input('privilege'),
            'dept' => $dept,
            'dept_name' => $dept_name
        ];

        if ($id == null) :
            $emp->InsertEmployee($ins_data);
        else:
            $emp->UpdateEmployee($ins_data, $id);
            $emp->UpdateEmployeeCentral($ins_data_central, $id);
        endif;
        return redirect('employee');
    }

    public function destroy($id) {
        $emp = new Employee;
        $emp->DestroyEmployee($id);
        return redirect('employee');
    }

}
