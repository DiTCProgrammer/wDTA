@extends('layouts.app')
@section('css')
{!! Html::style('assets/dist/css/management/employee.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--employee--create">
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

                    {!! Form::open(array('url' => '/employee/updateuser','class'=>'','id'=>'form_employee','files' => true)) !!}
                    <div class="col-sm-12 form-group-employee">
                        <span for="Prefix" class="col-sm-4 control-label ">Prefix <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-4">
                            {!!Form::select('prefix',$prefix,null,['class' => 'form-control','id'=>'prefix']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Firstname" class="col-sm-4 control-label ">Firstname <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            {!!Form::text('firstname',null,['class' => 'form-control','id'=>'firstname']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Lastname" class="col-sm-4 control-label ">Lastname <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            {!!Form::text('lastname',null,['class' => 'form-control','id'=>'lastname']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Email" class="col-sm-4 control-label ">Email <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            {!!Form::email('email',null,['class' => 'form-control','id'=>'email']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Username" class="col-sm-4 control-label ">Username <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            {!!Form::text('username',null,['class' => 'form-control','id'=>'username'])!!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Password" class="col-sm-4 control-label ">Password <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            {!!Form::password('password',['class' => 'form-control','id'=>'password'])!!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Privilege" class="col-sm-4 control-label ">Privilege <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-6">
                            {!!Form::select('privilege',$dataEmp,null,['class' => 'form-control','id'=>'privilege']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-employee show-dept">
                        <span for="Department" class="col-sm-4 control-label ">Head of Department <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-6">
                            {!!Form::select('dept',$dataList,null,['class' => 'form-control','id'=>'dept']) !!}
                        </div>                        
                    </div>
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

    <div class="row">
        <div class="col-xs-12 text-right">
            <a href="{{url('/employee/create')}}">Skip>></a>
        </div>
    </div>
</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/management.js') !!}
{!! Html::script('assets/dist/js/management/employee.js') !!}

@endsection