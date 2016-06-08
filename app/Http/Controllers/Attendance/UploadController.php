<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Attendance;
use DB;
use Auth;

class UploadController extends Controller {

    private $date_start;
    private $date_end;
    protected $db = 'dta_1';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function __construct() {
//        $this->middleware('auth');
//    }
    
    public function __construct() {
        $this->middleware('hr');
        \Debugbar::disable();
    }

    public function index() {
        return view('/attendance/upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function insert1(Request $request) {
        if ($request->data) {
            $data = json_decode($request->data);
            $date_length = explode(' - ', $request->date_length);
            $this->date_start = $date_length[0];
            $this->date_end = $date_length[1];
            $insert_data = null;
            $id = null;

            foreach ($data as $val) {
                $new_data = null;
                $new_data = preg_split('/\s+\s+\s+/', $val);
                $insert_data[] = array('uid' => $new_data[0], 'work_time' => "" . $this->SetDatetime($new_data[1], 1) . "", 'state' => 0);
                $id = $new_data[0];
            }




            if ($insert_data && strtotime(date('Y-m-d', strtotime($insert_data[0]['work_time']))) >= strtotime($this->date_start) && strtotime(date('Y-m-d', strtotime($insert_data[count($insert_data) - 1]['work_time']))) <= strtotime($this->date_end)) {


                $model = new Attendance();
                if ($model->Uploaddata($insert_data)) {

                    $raw = $model->Raw($id, $this->date_start, $this->date_end);

                    if ($raw) {

                        $error_type = null;
                        if ($raw == 'true') {
                            $error_type = 2;
                        } else if ($raw == false) {
                            $error_type = 3;
                        } else {
                            $error_type = 1;
                        }

                        $return = array('id' => $id, 'error_type' => $error_type, 'detail' => ($raw != 'true' && $raw != false ? $raw : ''));
                        return json_encode($return);
                        //return '<tr><td width="50%">' . $id . '</td><td width="50%">Complete</td></tr>';
                    } else {
                        $return = array('id' => $id, 'error_type' => 3, 'detail' => '');
                        return json_encode($return);
                    }
                }
            }
            $return = array('id' => $id, 'error_type' => '4', 'detail' => '');
            return json_encode($return);
            //return '<tr><td width="50%">' . $id . '</td><td width="50%">Error</td></tr>';
        } else {
            return 'False';
        }
    }

    function SetDatetime($d = null, $s = null) {
        if ($d) {
            $d = explode(' ', $d);
            $d[0] = explode('/', $d[0]);
            if ($s == 1) {
                return date('Y-m-d H:i:s', strtotime($d[0][2] . '/' . $d[0][1] . '/' . $d[0][0] . ' ' . $d[1] . ':00'));
            } else {
                return strtotime($d[0][2] . '/' . $d[0][1] . '/' . $d[0][0] . ' ' . $d[1] . ':00');
            }
        }
    }

    function remove_time(Request $request) {
        $id = $request->id;
        $time = $request->time;

        $model = new Attendance();
        $rs = $model->remove_time($id, $time);
        if ($rs) {
            return 1;
        } else {
            return 0;
        }
    }

    function getcondition() {
        $model = new Attendance();
        $data = $model->getCondition();
        if ($data) {
            return $data;
        }
        return false;
    }

    function getraw(Request $request) {

        if ($request->empcode) {
            $model = new Attendance();
            $data = $model->getraw($request->empcode);
            if ($data) {
                return $data;
            }
        }
        return false;
    }

    function insert_view(Request $request) {
        if ($request->data) {

            $data = json_decode($request->data);
            $model = new Attendance();

            $rs = $model->insert_view($data);
            $empcode = get_object_vars($data);

            if ($rs) {
                return '<tr class="success"><td>Employee Code------' . $empcode[0]->empcode . '------Status------Success</td></tr>';
            } else {
                return '<tr class="error"><td>Employee Code------' . $empcode[0]->empcode . '------Status------Error</td></tr>';
            }
        }
    }

    function Test() {
        DB::connection($this->db)->delete('DELETE FROM attendance_upload');
        DB::connection($this->db)->delete('DELETE FROM attendance_raw');
        DB::connection($this->db)->delete('DELETE FROM attendance_view');
        // $model = new Attendance();
        //$data = $model->getraw('152');
        //  $data = $model->Raw('152', '2016-03-01', '2016-03-31');
        exit;
    }

}
