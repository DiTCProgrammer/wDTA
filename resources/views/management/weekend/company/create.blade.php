@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/management/weekend.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="management--weekend">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="title">SETTINGS</h1>
        </div>
    </div>


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>
                Week End Company Add
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


    {!! Form::open(array('url' => '/weekend/company/update','class'=>'','id'=>'form_department','files' => true)) !!}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            <div class="row">
                <div class="col-sm-4 ">
                    {!!Form::select('ydate',$dataWArrYear,null,['class' => 'form-control','id'=>'ydate']); !!} 
                </div>
                <div class="col-sm-4 col-sm-offset-1">  
                    @foreach($dataDay as $i => $row)
                    <ul>  
                        <li>
                            {!!Form::checkbox('weekend[]',$row[1],null,['class' => '','id'=>'weekend[]']); !!} 
                            {{$row[0]}}
                        </li>
                    </ul>
                    @endforeach
                </div>
            </div>


        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <button type="submit" class="btn btn-info"><i class="fa  fa-save "></i>SAVE</button>
        </div>
    </div>
    {!! Form::close() !!} 


</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/weekend.js') !!}

@endsection

