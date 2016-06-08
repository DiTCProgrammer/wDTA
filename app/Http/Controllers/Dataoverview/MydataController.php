<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use Image;
use DB;
use Auth;

class CompanyController extends Controller {
    
    public function __construct() {
        $this->middleware('noadmin');
        \Debugbar::disable();
    }

    public function index() {
        $com = new Company;
        $dataCom = $com->SelectCompany();
        return view('management/company/edit', ['dataCom' => $dataCom]);
    }

    public function update(Request $request, $id = null) {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'tax_id' => 'required',
            //'tel' => 'required',
            //'fax' => 'required',
            //'phone' => 'required',
            //'email' => 'required',
            //'website' => 'required'
        ]);
        $picture = '';
        if ($request->hasFile('logo')) :
             $company_id = Auth::user()->company_id;
            $directory = public_path('file') . '/'.$company_id.'/logo';
            if (!is_dir($directory)) {
                @mkdir($directory, 0777, true);
            }
            $filename = str_random(10) . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('file') . '/', $filename);
            Image::make(public_path() . '/file/' . $filename)->resize(200, 180)->save($directory . '/' . $filename);

            @unlink(public_path() . '/file/' . $filename);
            $picture = 'file/'.$company_id.'/logo/' . $filename;
        endif;
        
        if ($request->input('img_edit') && $picture == '') :
            $picture = $request->input('img_edit');
        endif;           

        $ins_data = ['name' => $request->input('name'),
            'address' => $request->input('address'),
            'tax_id' => $request->input('tax_id'),
            'tel' => $request->input('tel'),
            'fax' => $request->input('fax'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'logo' => $picture            
        ];
        $com = new Company;
        $com->UpdateCompany($ins_data, $id);

        return redirect('company');
    }
    
   

}
