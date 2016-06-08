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
                Week End Add Week end Department
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

    {!! Form::open(array('url' => '/weekend/depertment/update','class'=>'','id'=>'form_department','files' => true)) !!}
    <div class="row">
        <div class="col-md-3 col-md-offset-2">
            <div class="week-checkbook-row">
                {!!Form::select('dep_id',$dep,null,['class' => 'form-control','id'=>'dep_id']); !!} 
            </div>
        </div>

        <div class="col-md-2">
            <div class="week-checkbook-row">
                <div class="week-checkbook-row">
                    {!!Form::select('year',$dataWArrYear,null,['class' => 'form-control','id'=>'year']); !!} 
                </div>
                <div class="week-checkbook-row">
                    {!!Form::select('month',$month,null,['class' => 'form-control','id'=>'month']); !!}     
                </div>
            </div>
        </div>

        <div class="col-md-4 week-checkbook">
            <div class="">
                <div class="col-sm-8 col-sm-offset-4 name_date">
                    <span>M</span> 
                    <span>T</span> 
                    <span>W</span> 
                    <span>Th</span> 
                    <span>F</span> 
                    <span>Sa</span> 
                    <span>Su</span> 
                </div>
            </div>


            <div class="">
                @for($i=1;$i<=6;$i++)
                <div class="col-sm-12 dataretuenQ"> 
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="" ><h4>{{$i}} week </h4></div>
                        </div>
                        <div class="col-sm-8">
                            <div class="week-checkbook-row" >
                                @for($ii=1;$ii<=7;$ii++)                                
                                @if($week[$i][$ii] == '')
                                <span>{!!Form::checkbox('weekend[]',null,null,['class' => '','id'=>'weekend[]','disabled']); !!}</span>
                                @else
                                <span>{!!Form::checkbox('weekend[]',$week[$i][$ii],null,['class' => '','id'=>'weekend[]']); !!}</span>
                                @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                @endfor

            </div>
        </div>

        <div>
            <div class="col-xs-12 text-center">
                <button type="submit" class="btn btn-info"><i class="fa  fa-save "></i>SAVE</button>
            </div>
        </div>


    </div>
    {!! Form::close() !!} 

</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/weekend.js') !!}

@endsection

