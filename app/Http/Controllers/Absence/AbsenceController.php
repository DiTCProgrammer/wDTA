<?php

namespace App\Http\Controllers\Absence;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Absence;
use DB;

class AbsenceController extends Controller {
    
    public function __construct() {
        $this->middleware('adminhr');
        \Debugbar::disable();
    }

    function conModel() {
        return new Absence;
    }

    public function index() {
        $data = $this->conModel()->getAbsence();
        return view('management/absence/view', ['data' => $data]);
    }

    public function edit(Request $request, $id = null) {

        if ($id == 'add'):
            $data = $this->addForm();
        else:
            $data = $this->editForm($id);
        endif;

        $group = $this->conModel()->getGroup_Condition();
        $data['group']['-1'] = 'All';
        foreach ($group as $row):
            $data['group'][$row->group] = 'Group ' . $row->group;
        endforeach;

        return view('management/absence/edit', ['abs' => $data]);
        
    }

    function update(Request $request, $id = null) {
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required',
            'min_day' => 'required',
            'max_day' => 'required',
            'before_day' => 'required',
            'over_day_att' => 'required',
            'status_att_file' => 'required',
            'group_condition' => 'required'
        ]);

        $data = [
            'name' => $request->input('name'),
            'amount' => $request->input('name'),
            'min_day' => $request->input('min_day'),
            'max_day' => $request->input('max_day'),
            'before_day' => $request->input('before_day'),
            'over_day_att' => $request->input('over_day_att'),
            'status_att_file' => $request->input('status_att_file'),
            'group_condition' => $request->input('group_condition'),
            'state'=>1
        ];

        if ($id == 'add'):
            $this->conModel()->InsertAbsence($data);
        else:
            $this->conModel()->UpdateAbsence($data,$id);
        endif;
        
        return redirect('absence');
    }
    
    function destroy($id) {
       $this->conModel()->DestroyAbsence($id);        
    }

    function addForm() {
        $data = array();
        $data['id'] = 'add';
        $data['name'] = '';
        $data['amount'] = '';
        $data['min_day'] = 1;
        $data['max_day'] = 5;
        $data['before_day'] = 0;
        $data['over_day_att'] = 1;
        $data['status_att_file'] = '';
        $data['group_condition'] = '';
        return $data;
    }

    function editForm($id) {
        $abs = $this->conModel()->getAbsenceId($id);
        $data = array();
        $data['id'] = $abs[0]->id;
        $data['name'] = $abs[0]->name;
        $data['amount'] = $abs[0]->amount;
        $data['min_day'] = $abs[0]->min_day;
        $data['max_day'] = $abs[0]->max_day;
        $data['before_day'] = $abs[0]->before_day;
        $data['over_day_att'] = $abs[0]->over_day_att;
        $data['status_att_file'] = $abs[0]->status_att_file;
        $data['group_condition'] = $abs[0]->group_condition;
        return $data;
    }

}
