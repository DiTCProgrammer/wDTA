<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App;
use Auth;
use DB;
use Session;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $table = 'data_employee'; //DB Name
    
    public function __construct() {
        $this->middleware('auth');
        \Debugbar::disable();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $company_id = Auth::user()->company_id;
        if(Auth::user()->privilege == '1' || Auth::user()->privilege == '2' || Auth::user()->privilege == '3' || Auth::user()->privilege == '4'){
            $users = DB::connection('dta_'.$company_id)->select('SELECT * FROM data_employee WHERE id='.Auth::user()->id);
        }else{
            $users[0] = (object) array('id'=>Auth::user()->id); 
        }
        $company = DB::connection('dta_'.$company_id)->select('SELECT * FROM config_company');
        //$data = $request->session()->all();
//        print_r($users[0]);
//        exit();
        Session::set('myuser', $users[0]);
        Session::set('mycompany', $company[0]);
        //return $users[0]->empcode;
        return view('home');
        
    }

}
