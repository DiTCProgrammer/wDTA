<?php

namespace App\Http\Controllers\Persabsence;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Persabsence;
use Image;
use DB;
use Auth;

class PersabsenceController extends Controller {

    protected $absence = 'config_absence';
    protected $employee_absence = 'data_employee_absence';

    public function __construct() {
        $this->middleware('adminhrhof');
        \Debugbar::disable();
    }

    public function index() {
        return view('persabsence/nav');
    }

    function view(Request $request) {
        $form = $request->input('form');
        $state = 0;
        $dept_id = null;
        $ddate = null;
        $status = null;
        if ($form) {
            $state = 1;
            $dept_id = $form['dept'];
            $ddate = explode(' - ', $form['ddate']);
            if (preg_match("/^-?[0-9]{1,4}$/", $form['state'])) {
                $status = $form['state'];
            }
        }



        $Persabsence = new Persabsence;
        $dataW = $Persabsence->getPersabsence($state, $dept_id, $ddate, $status);
        $dept = $Persabsence->getDepartment();

        return view('persabsence/view', ['data' => $dataW, 'dept' => $dept, 'dept_id' => $dept_id, 'ddate' => $form['ddate'], 'status' => $status, 'state' => $state]);
    }

    function create() {
        $Persabsence = new Persabsence;
        $dataW = $Persabsence->getAbsence();
        return view('persabsence/create', ['absence' => $dataW]);
    }

    function search(Request $request) {
        $Persabsence = new Persabsence;
        $dataW = $Persabsence->searchPersabsence($request->data);
        return $dataW;
    }

    function update(Request $request, $id = null) {
        $this->validate($request, [

            'empcode' => 'required',
            'date_length' => 'required',
            'Absence' => 'required'
        ]);
        $Persabsence = new Persabsence;
        $dataW = $Persabsence->getPersabsence_Group();
        $group = $dataW + 1;
        $string = $request->input('date_length');
        $exp = explode(' - ', $string);
        $start = explode('-', $exp[0]);
        $end = explode('-', $exp[1]);
        $Absence = explode('-', $request->input('Absence'));
        $ddate = '';

        $file = '';
        if ($request->hasFile('attfile')) :
            $directory = public_path('file') . '/1/attfile';
            if (!is_dir($directory)) :
                @mkdir($directory, 0777, true);
            endif;
            $filename = str_random(10) . '.' . $request->file('attfile')->getClientOriginalExtension();
            $request->file('attfile')->move(public_path('file') . '/1/attfile/', $filename);
            $file = 'file/1/attfile/' . $filename;
        endif;

        if ($start[1] == $end[1]):
            for ($i = $start[2]; $i <= $end[2]; $i++):
                $ddate = $start[0] . '-' . $start[1] . '-' . $i;
                $ins_data = ['uid' => $request->input('id_empcode'),
                    'empcode' => $request->input('empcode'),
                    'ddate' => $ddate,
                    'status_id' => $Absence[0],
                    'status_name' => $Absence[1],
                    'comment' => $request->input('comment'),
                    'attfile' => $file,
                    'state' => 1,
                    'group' => $group,
                    'dept_id' => $request->input('dept_id'),
                    'create_by' => Auth::user()->id
                ];
                if ($id == null) :
                    $Persabsence->InsertPersabsence($ins_data, $this->employee_absence);
                endif;
            endfor;
        else:
            $start_M = date('t', strtotime($exp[0]));
            for ($i = $start[2]; $i <= $start_M; $i++):
                $ddate = $start[0] . '-' . $start[1] . '-' . $i;
                $ins_data = ['uid' => $request->input('id_empcode'),
                    'empcode' => $request->input('empcode'),
                    'ddate' => $ddate,
                    'status_id' => $Absence[0],
                    'status_name' => $Absence[1],
                    'comment' => $request->input('comment'),
                    'attfile' => $file,
                    'state' => 1,
                    'group' => $group,
                    'dept_id' => $request->input('dept_id'),
                    'create_by' => Auth::user()->id
                ];
                if ($id == null) :
                    $Persabsence->InsertPersabsence($ins_data, $this->employee_absence);
                endif;
            endfor;
            for ($i = 1; $i <= $end[2]; $i++):
                $ddate = $end[0] . '-' . $end[1] . '-' . $i;
                $ins_data = ['uid' => $request->input('id_empcode'),
                    'empcode' => $request->input('empcode'),
                    'ddate' => $ddate,
                    'status_id' => $Absence[0],
                    'status_name' => $Absence[1],
                    'comment' => $request->input('comment'),
                    'attfile' => $file,
                    'state' => 1,
                    'group' => $group,
                    'dept_id' => $request->input('dept_id'),
                    'create_by' => Auth::user()->id
                ];
                if ($id == null) :
                    $Persabsence->InsertPersabsence($ins_data, $this->employee_absence);
                endif;
            endfor;
        endif;
        return redirect('persabsence/view');
    }

    function destroy($id) {
        $Persabsence = new Persabsence;
        $Persabsence->DestroyDelPersabsence($id, $this->employee_absence);
    }

    function search_employee(Request $request) {
        if ($request->text) {

            $model = new Persabsence();
            $rs = $model->getSearch_employee($request->text);

            if ($rs) {
                return json_encode($rs);
            }
        }
    }

    function myabsence() {
        return view('persabsence/mynav');
    }

    function myview(Request $request) {
        $form = $request->input('form');
        $state = 0;
        $ddate = null;
        $status = null;
        if ($form) {
            $state = 1;
            $dept_id = $form['dept'];
            $ddate = explode(' - ', $form['ddate']);
            if (preg_match("/^-?[0-9]{1,4}$/", $form['state'])) {
                $status = $form['state'];
            }
        }

        $Persabsence = new Persabsence;
        $dataW = $Persabsence->getMypersabsence($state, $ddate, $status);

        return view('persabsence/myview', ['data' => $dataW, 'ddate' => $form['ddate'], 'status' => $status, 'state' => $state]);
    }

    function import() {
        return view('persabsence/import');
    }

    function import_data(Request $request) {

        if ($request->data) {
            $user = Auth::user();
            $request->data = json_decode($request->data);
            $data = null;
            $empcode = null;
            foreach ($request->data as $key => $val) {
                $data[] = array(
                    'uid' => "" . $val[0] . "",
                    'empcode' => "" . $val[1] . "",
                    'dept_id' => $val[2],
                    'status_id' => $val[4],
                    'status_name' => "" . $val[5] . "",
                    'group' => "" . $val[6] . "",
                    'state' => 2,
                    'ddate' => $val[3],
                    'create_by' => $user->id
                );
                $empcode = $val[1];
            }



            if ($data) {
                $model = new Persabsence();
                $rs = $model->import_data($data);
                if ($rs == true) {
                    return json_encode(array('empcode' => $empcode, 'state' => 1));
                }
            }
            return json_encode(array('empcode' => $empcode, 'state' => 0));
        }
        return json_encode(array('empcode' => '', 'state' => -1));
    }

}
