@extends('layouts.app')
<!--<link href="assets/dist/css/management/employee.css" rel="stylesheet" type="text/css">-->
@section('css')
{!! Html::style('assets/dist/css/management/employee.css') !!}
@endsection
@section('content')
<?php
//echo '<pre>';
//print_r($emp_data);
//exit;
?>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--employee">
    <div class="col-md-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="title">SETTNGS</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    <h3>
                        Employee
                    </h3>
                    <h3>
                        General Information
                    </h3>
                </div>
                @if (count($errors) > 0)     
                <div class="col-md-12">
                    <div class="alert alert-warning">       
                        <ul>                    
                            @foreach ($errors->all() as $error)     
                            <li>{{ $error }}</li>                       
                            @endforeach                   
                        </ul>            
                    </div>     
                </div>
                @endif 

                <div class="col-md-6 col-md-offset-3">

                    {!! Form::open(array('url' => '/employee/'.$emp_data[0]->id_emp.'/update','class'=>'','id'=>'form_employee','files' => true)) !!}

                    <div class="col-sm-12 form-group-employee">
                        <span for="Empty" class="col-sm-4 control-label ">Empty Code <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-4">
                            {!! Form::text('empcode', $emp_data[0]->empcode, ['class' => 'form-control','id'=>'empcode']) !!}
                        </div>
                        <div class="col-sm-4">
                            <div class="show_status_emptycode"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Privilege" class="col-sm-4 control-label ">Privilege <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-6">
                            {!!Form::select('privilege',$dataEmp,$central[0]->privilege,['class' => 'form-control','id'=>'privilege']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee show-dept">
                        <span for="Head of Department" class="col-sm-4 control-label ">Head of Department <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-6">
                            {!!Form::select('dept',$dataList,$central[0]->dept.':'.$central[0]->dept_name,['class' => 'form-control','id'=>'dept']) !!}
                        </div>                        
                    </div>
                    
                    <div class="col-sm-12 form-group-employee">
                        <span for="Prefix" class="col-sm-4 control-label">Prefix <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            {!!Form::select('prefix', array('นาย' => 'นาย', 'นาง' => 'นาง','นางสาว'=>'นางสาว'),$emp_data[0]->prefix,['class' => 'form-control','id'=>'prefix']) !!}
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="First Name" class="col-sm-4 control-label ">First Name <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            {!! Form::text('firstname', $emp_data[0]->firstname, ['class' => 'form-control','id'=>'firstname']) !!}
                         
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Last Name" class="col-sm-4 control-label">Last Name <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            {!! Form::text('lastname', $emp_data[0]->lastname, ['class' => 'form-control','id'=>'lastname']) !!}
                         
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Gender" class="col-sm-4 control-label">Gender <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-3">                            
                            {!!Form::select('sex', array('ชาย' => 'Male', 'หญิง' => 'Female'),$emp_data[0]->sex,['class' => 'form-control','id'=>'sex']); !!}
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Identfication Card" class="col-sm-4 control-label">Identfication Card <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            {!! Form::text('idcard', $emp_data[0]->idcard, ['class' => 'form-control','id'=>'idcard']) !!}

                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee " >
                        <span for="Date of Birth" class="col-sm-4 control-label">Date of Birth <span class="span-right">:</span></span>

                        <div class="col-sm-4">
                            {!! Form::text('date_birth', $emp_data[0]->date_birth, ['class' => 'form-control','id'=>'date_birth']) !!}

                        </div>
                        <span class="fa fa-calendar"   ></span>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Date of Birth" class="col-sm-4 control-label">Warking Type <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                {!! Form::radio('paytype', 1,$emp_data[0]->paytype == 1 ? 'true':'', ['class' => 'minimal','id'=>'paytype']) !!}                               
                                Monthly
                            </span>
                            <span>
                                {!! Form::radio('paytype', 2,$emp_data[0]->paytype == 2 ? 'true':'', ['class' => 'minimal','id'=>'paytype']) !!}                               
                                Daily
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Pay" class="col-sm-4 control-label">Pay <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            {!! Form::text('Pay', $emp_data[0]->payrate !=0 ? $emp_data[0]->payrate : $emp_data[0]->wage, ['class' => 'form-control','id'=>'Pay']) !!}
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Department" class="col-sm-4 control-label">Department <span class="span-right">:</span></span>
                        <div class="col-sm-8">                      
                            {!!Form::select('Department',$department,$emp_data[0]->dept_id.':'.$emp_data[0]->dept_name.':'.$emp_data[0]->group_condition,['class' => 'form-control','id'=>'Department']); !!}                           
                        </div>
                    </div>

                    <div class="col-sm-12 form-group-employee">
                        <span for="Department" class="col-sm-4 control-label">Group Condition Me <span class="span-right">:</span></span>
                        <div class="col-sm-8">                      

                            {!!Form::select('group_me',$condition_time,$emp_data[0]->group_me,['class' => 'form-control','id'=>'group_me']); !!} 
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Position" class="col-sm-4 control-label">Position <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            {!! Form::text('position', $emp_data[0]->position, ['class' => 'form-control','id'=>'position']) !!}

                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Extrawage" class="col-sm-4 control-label">Extrawage <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            {!! Form::text('extrawage', $emp_data[0]->extrawage, ['class' => 'form-control','id'=>'extrawage']) !!}

                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee show_extrawage_status">
                        <span for="Extrawage Status" class="col-sm-4 control-label">Extrawage Status <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                {!! Form::radio('extrawage_status', 1,$emp_data[0]->extrawage_status == 1 ? 'true':'', ['class' => 'minimal','id'=>'extrawage_status']) !!}                                
                                Use
                            </span>
                            <span>
                                 {!! Form::radio('extrawage_status', 0,$emp_data[0]->extrawage_status == 0 ? 'true':'', ['class' => 'minimal','id'=>'extrawage_status']) !!}                               
                                No
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee ">
                        <span for="Technicialwage Status" class="col-sm-4 control-label">Technicialwage Status <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                {!! Form::radio('technicialwage_status', 1,$emp_data[0]->technicialwage_status == 1 ? 'true':'', ['class' => 'minimal','id'=>'technicialwage_status']) !!}                                
                                Use
                            </span>
                            <span>
                                 {!! Form::radio('technicialwage_status', 0,$emp_data[0]->technicialwage_status == 0 ? 'true':'', ['class' => 'minimal','id'=>'technicialwage_status']) !!}                               
                                No
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee ">
                        <span for="Weekend Status" class="col-sm-4 control-label">Weekend Status <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                {!! Form::radio('weekendotorday', 1,$emp_data[0]->weekendotorday == 1 ? 'true':'', ['class' => 'minimal','id'=>'weekendotorday']) !!}                                
                                Use
                            </span>
                            <span>
                                 {!! Form::radio('weekendotorday', 0,$emp_data[0]->weekendotorday == 0 ? 'true':'', ['class' => 'minimal','id'=>'weekendotorday']) !!}                               
                                No
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Technicial" class="col-sm-4 control-label">Technicial wage <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            {!! Form::text('technicialwage', $emp_data[0]->technicialwage, ['class' => 'form-control','id'=>'technicialwage']) !!}

                        </div>
                    </div>            
                    <div class="col-sm-12 form-group-employee">
                        <span for="Start Working" class="col-sm-4 control-label">Start Working <span class="span-right">:</span></span>

                        <div class="col-sm-4">
                            {!! Form::text('date_working', $emp_data[0]->date_working, ['class' => 'form-control','id'=>'date_working']) !!}                          
                        </div>
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Start Working" class="col-sm-4 control-label">Image <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            {!! Form::file('image', $attributes = ['id'=>'img_onload','class'=>'form-control pull-right']);  !!}
                        </div>
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8 ">
                            <div class="show_img">

                                @if($emp_data[0]->picture)
                                <img src="{{url('').'/'.$emp_data[0]->picture}}" />
                                @else
                                <img src="{{url('').'/pictures/default.jpg'}}" />
                                @endif
                            </div>
                        </div>
                    </div>
                    {!! Form::hidden('img_edit', $emp_data[0]->picture, ['class' => 'form-control','id'=>'img_edit']) !!} 
                    <div class="col-sm-12 form-group-employee">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-info"><i class="fa  fa-save "></i>SAVE</button>
                        </div>                                
                    </div>
                    <!-- /.box-body -->

                    <!-- /.box-footer -->
                    {!! Form::close() !!} 
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/management.js') !!}
{!! Html::script('assets/dist/js/management/employee.js') !!}

@endsection