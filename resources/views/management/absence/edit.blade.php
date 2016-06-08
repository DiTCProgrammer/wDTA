@extends('layouts.app')
@section('css')
{!! Html::style('assets/dist/css/management/absence.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--absence">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="title">ABSENCE</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <h3>
                ABSENCE
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

    {!! Form::open(array('url' => '/absence/'.$abs['id'].'/update','class'=>'','id'=>'form_absence','files' => true)) !!}
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-sm-4">
                    <label>Name</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">{!! Form::text('name', $abs['name'], ['class' => 'form-control','id'=>'name']) !!}</div>              
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Amount</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">{!! Form::text('amount', $abs['amount'], ['class' => 'form-control','id'=>'amount']) !!}</div>
              
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Min Day</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">{!! Form::text('min_day', $abs['min_day'], ['class' => 'form-control','id'=>'min_day']) !!}</div>
              
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Max Day</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">{!! Form::text('max_day', $abs['max_day'], ['class' => 'form-control','id'=>'max_day']) !!}</div>
              
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Before Day</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">{!! Form::text('before_day', $abs['before_day'], ['class' => 'form-control','id'=>'before_day']) !!}</div>
              
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Over Day Att</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">{!! Form::text('over_day_att', $abs['over_day_att'], ['class' => 'form-control','id'=>'over_day_att']) !!}</div>
              
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Status Att</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">   {!!Form::select('status_att_file',['1'=>'use','0'=>'No Use'],$abs['status_att_file'],['class' => 'form-control','id'=>'status_att_file']); !!}                </div>
              
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Group</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4">
                    {!!Form::select('group_condition',$abs['group'],$abs['group_condition'],['class' => 'form-control','id'=>'group_condition']); !!}
                </div>
              
            </div>
            

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <button type="submit"><i class="fa  fa-save "></i>SAVE</button>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}


</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/absence.js') !!}

@endsection