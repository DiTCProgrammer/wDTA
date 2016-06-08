@extends('layouts.app')
<!--<link href="assets/dist/css/management/employee.css" rel="stylesheet" type="text/css">-->
@section('css')
{!! Html::style('assets/dist/css/management/department.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--department create">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="title">{{ trans('menu.setting') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <h3>
                {{ trans('department.department') }}
            </h3>
        </div>
    </div>


    @if (count($errors) > 0)   
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">       
                <ul>                    
                    @foreach ($errors->all() as $error)     
                    <li>{{ $error }}</li>                       
                    @endforeach                   
                </ul>            
            </div>     
        </div>
    </div>
    @endif

    {!! Form::open(array('url' => '/department/'.$Dep[0]->id.'/update','class'=>'','id'=>'form_department','files' => true)) !!}
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-sm-4">
                    <label>{{ trans('department.code') }}</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">{!! Form::text('code', $Dep[0]->code, ['class' => 'form-control','id'=>'code']) !!}</div>
                <div class="col-sm-4"><div class="show_status_code"></div></div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label>{{ trans('department.name') }}</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-8">{!! Form::text('name', $Dep[0]->name, ['class' => 'form-control','id'=>'name']) !!}</div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label>{{ trans('department.sttnight') }}</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-8">
                    {!! Form::radio('status_night', 1,$Dep[0]->status_night == 1 ? 'true':'', ['class' => 'minimal night','id'=>'status_night']) !!}  
                    {{ trans('department.use') }}
                    {!! Form::radio('status_night', 0,$Dep[0]->status_night == 0 ? 'true':'', ['class' => 'minimal night','id'=>'status_night']) !!} 
                    {{ trans('department.nouse') }}
                </div>
            </div>

            <div class="row time_val">
                <div class="col-sm-4">
                    <label>{{ trans('department.settime') }}</label>
                    <span class="span-right hidden-xs">:</span>
                </div>

                <div class="col-sm-3">
                    {!!Form::select('time_h',$time_h,$h1,['class' => 'form-control','id'=>'time_h']); !!}                
                </div>

                <div class="col-sm-3">
                    {!!Form::select('time_m',$time_m,$m1,['class' => 'form-control','id'=>'time_m']); !!} 
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label>{{ trans('department.icon') }}</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>

                <div class="col-sm-8">
                    <ul>
                        @foreach($objScan as $img)  
                        <li>
                            {!! Form::radio('icon', $img,$Dep[0]->icon == $img ? 'true':'', ['class' => 'minimal','id'=>'icon']) !!}  
                            <img  src="{{ url('images/icon').'/'.$img}}" class="img-file">
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-8 col-sm-offset-4 text-center">
                    <button type="submit"><i class="fa  fa-save "></i>{{ trans('department.save') }}</button>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}


</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/department.js') !!}

@endsection