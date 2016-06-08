<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ' อิอิ'; 
       
        return view('test.test',['s'=>$data]);
    }
    
    function test2($a){
        
        return view('test.test',['s'=>$a]);
    }
}