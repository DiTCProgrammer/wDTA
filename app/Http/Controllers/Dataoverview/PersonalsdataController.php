<?php

namespace App\Http\Controllers\Dataoverview;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Dataoverview;
use DB;
use Auth;
use Session;

class PersonalsdataController extends Controller {

    public function __construct() {
        $this->middleware('noemp');
        \Debugbar::disable();
    }

    public function getdept(Request $request) {

        $search = null;
        $input = $request->input();

        if ($input) {
            $search = $input['search'];
        }

        if (Auth::user()->privilege == 2) {
            $where = array(['col' => 'id', 'opt' => '=', 'val' => Auth::user()->dept], ['col' => 'state', 'opt' => '=', 'val' => 1]);
        } else {
            $where = array(['col' => 'state', 'opt' => '=', 'val' => 1]);
        }

        $model = new Dataoverview;
        $data = $model->getdept('data_department', $where, $search);
        return view('dataoverview/pers/main', ['data' => $data, 'search' => $search]);
    }

    public function getusers($id = null, $date_length = null) {

        if ($id) {

            $date = null;
            if ($date_length) {
                $date = explode(' - ', $date_length);
            } else {
                $date[0] = DATE('Y') . '-01-01';
                $date[1] = DATE('Y') . '-12-31';
            }
            if ($id == 'all' && Auth::user()->privilege != 2) {
                $where = array(['col' => 'state', 'opt' => '=', 'val' => 1]);
            } else if (Auth::user()->privilege == 2) {
                $where = array(['col' => 'dept_id', 'opt' => '=', 'val' => Auth::user()->dept], ['col' => 'state', 'opt' => '=', 'val' => 1]);
            } else {
                $where = array(['col' => 'dept_id', 'opt' => '=', 'val' => $id], ['col' => 'state', 'opt' => '=', 'val' => 1]);
            }


            $model = new Dataoverview;
            $data = $model->getusers('attendance_view', $where, $date[0], $date[1]);
            return view('dataoverview/pers/users', ['data' => $data, 'dept_id' => $id, 'date' => $date[0] . ' - ' . $date[1]]);
        }
    }

    function users_search(Request $request) {
        if ($request->dept_id && $request->date_length) {
            $data = $this->getusers($request->dept_id, $request->date_length);
            return $data;
        }
    }

    function getuser($empcode = null, $dept_id = null, $date = null) {
        if ($empcode && $date) {
            $user = Auth::user();
            $model = new Dataoverview;
            $data = $model->getuser('attendance_view', $empcode, $dept_id, $date);

            return view('dataoverview/pers/user', ['data' => $data, 'user' => $user]);
        }
    }

    public function myinformation($date = null) {
        $user = Auth::user();
        if ($user) {

            $model = new Dataoverview;
            if (!$date) {

                $date = Date('Y-m-d', strtotime("-1 month", strtotime(Date('Y-m-d')))) . ' - ' . Date('Y-m-d');
            }
            $dept_id = $user->dept_code;           
            $empcode = (isset(Session::get('myuser')->empcode)?Session::get('myuser')->empcode:'001');
            $dept_id = '9';
            $empcode = '001';
            $data = $model->getuser('attendance_view', $empcode, $dept_id, $date);

            return view('dataoverview/my/myinformation', ['data' => $data, 'user' => $user, 'date' => $date, 'dept_id' => $dept_id]);
        }
        return false;
    }

    public function myinformation2(Request $request) {

        $date = $request->date_length;
        return $this->myinformation($date);
    }

}
