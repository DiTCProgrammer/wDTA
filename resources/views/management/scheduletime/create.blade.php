@extends('layouts.app')
@section('css')
{!! Html::style('assets/dist/css/management/scheduletime.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--scheduletime">
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
                        Schedule Time Menu
                    </h3>    
                    <h3>
                        Add Schedule Time
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

                <div class="col-md-10 col-md-offset-1">

                    {!! Form::open(array('url' => '/scheduletime/update','class'=>'','id'=>'form_scheduletime','files' => true)) !!}
                    <div class="col-sm-12 form-group-scheduletime">
                        <div class="col-sm-3">
                            <div class="col-sm-6">
                                <span for="Group" class="control-label ">Group <span id="necessary">*</span> <span class="span-right">:</span></span>
                            </div>
                            <div class="col-sm-6">
                                {!!Form::select('group',$group,old('group'),['class' => 'form-control','id'=>'group']); !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-6">
                                <span for="Neme Schedule Time" class="control-label ">Neme Schedule Time <span id="necessary">*</span> <span class="span-right">:</span></span>
                            </div>
                            <div class="col-sm-6">
                                {!!Form::text('name',old('name'),['class' => 'form-control','id'=>'name']); !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="col-sm-1">
                                {!!Form::checkbox('sttkidlate',1,null,['class' => '','id'=>'sttkidlate']); !!}
                            </div>
                            <div class="col-sm-6">
                                <span for="Flexibility" class="control-label ">Flexibility </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-scheduletime">
                        <table class="table table-bordered table-striped tab-scheduletime">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Detail</th>
                                    <th colspan="2"> 
                                        Starting Time
                                    </th>
                                    <th colspan="2">Ending Time</th>                                   
                                </tr>
                                <tr>                               
                                    <th> 
                                        Time
                                    </th>
                                    <th>Flexibility</th>
                                    <th>Time</th>
                                    <th>Flexibility</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{!!Form::checkbox('timecheck_1',2,null,['class' => '','id'=>'timecheck_1']); !!}</td>
                                    <td>Group Time 1</td>
                                    <td>{!!Form::select('group_1_h1',$Hour,old('group_1_h1'),['class' => 'form-control-scheduletime','id'=>'group_1_h1']); !!} 
                                        Hour:
                                        {!!Form::select('group_1_m1',$Min,old('group_1_m1'),['class' => 'form-control-scheduletime','id'=>'group_1_m1']); !!} 
                                        Min.
                                    </td>
                                    <td>
                                        {!!Form::select('flexibility_1_m1',$Min,old('flexibility_1_m1'),['class' => 'form-control-scheduletime','id'=>'flexibility_1_m1']); !!} 
                                        Min.
                                    </td>
                                    <td>{!!Form::select('group_1_h2',$Hour,old('group_1_h2'),['class' => 'form-control-scheduletime','id'=>'group_1_h2']); !!} 
                                        Hour:
                                        {!!Form::select('group_1_m2',$Min,old('group_1_m2'),['class' => 'form-control-scheduletime','id'=>'group_1_m2']); !!} 
                                        Min.
                                    </td>
                                    <td>
                                        {!!Form::select('flexibility_1_m2',$Min,old('flexibility_1_m2'),['class' => 'form-control-scheduletime','id'=>'flexibility_1_m2']); !!} 
                                        Min.
                                    </td>
                          
                                </tr>
                                <tr>
                                    <td>{!!Form::checkbox('timecheck_2',4,null,['class' => '','id'=>'timecheck_2']); !!}</td>
                                    <td>Group Time 2</td>
                                    <td>{!!Form::select('group_2_h3',$Hour,old('group_2_h3'),['class' => 'form-control-scheduletime','id'=>'group_2_h3']); !!} 
                                        Hour:
                                        {!!Form::select('group_2_m3',$Min,old('group_2_m3'),['class' => 'form-control-scheduletime','id'=>'group_2_m3']); !!} 
                                        Min.
                                    </td>
                                    <td>
                                        {!!Form::select('flexibility_2_m3',$Min,old('flexibility_2_m3'),['class' => 'form-control-scheduletime','id'=>'flexibility_2_m3']); !!} 
                                        Min.
                                    </td>
                                    <td>{!!Form::select('group_2_h4',$Hour,old('group_2_h4'),['class' => 'form-control-scheduletime','id'=>'group_2_h4']); !!} 
                                        Hour:
                                        {!!Form::select('group_2_m4',$Min,old('group_2_m4'),['class' => 'form-control-scheduletime','id'=>'group_2_m4']); !!} 
                                        Min.
                                    </td>
                                    <td>
                                        {!!Form::select('flexibility_2_m4',$Min,old('flexibility_2_m4'),['class' => 'form-control-scheduletime','id'=>'flexibility_2_m4']); !!} 
                                        Min.
                                    </td>
                                </tr>
                                <tr>
                                    <td>{!!Form::checkbox('timecheck_3',6,null,['class' => '','id'=>'timecheck_3']); !!}</td>
                                    <td>Group Time 3</td>
                                    <td>{!!Form::select('group_3_h5',$Hour,old('group_3_h5'),['class' => 'form-control-scheduletime','id'=>'group_3_h5']); !!} 
                                        Hour:
                                        {!!Form::select('group_3_m5',$Min,old('group_3_m5'),['class' => 'form-control-scheduletime','id'=>'group_3_m5']); !!} 
                                        Min.
                                    </td>
                                    <td>
                                        {!!Form::select('flexibility_3_m5',$Min,old('flexibility_3_m5'),['class' => 'form-control-scheduletime','id'=>'flexibility_3_m5']); !!} 
                                        Min.
                                    </td>
                                    <td>
                                        {!!Form::select('group_3_h6',$Hour,old('group_3_h6'),['class' => 'form-control-scheduletime','id'=>'group_3_h6']); !!} 
                                        Hour:
                                        {!!Form::select('group_3_m6',$Min,old('group_3_m6'),['class' => 'form-control-scheduletime','id'=>'group_3_m6']); !!} 
                                        Min.
                                    </td>
                                    <td>
                                        {!!Form::select('flexibility_3_m6',$Min,old('flexibility_3_m6'),['class' => 'form-control-scheduletime','id'=>'flexibility_3_m6']); !!} 
                                        Min.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 form-group-scheduletime">
                        <div class="col-sm-6">
                            <div class="row  form-group-scheduletime">
                                <div class="col-sm-4">
                                    <span for="Working Day" class="control-label ">Working Day <span class="span-right">:</span></span>
                                </div>
                                <div class="col-sm-8">
                                    {!!Form::select('stthalfday',array('1.0'=>'1.0','0.5'=>'0.5'),old('stthalfday'),['class' => 'form-control','id'=>'stthalfday']); !!} 
                                </div>   
                            </div>
                            <div class="row  form-group-scheduletime">
                                <div class="col-sm-4">
                                    <span for="Working Hour" class="control-label ">Working Hour </span>
                                </div>
                                <div class="col-sm-4">
                                    {!!Form::text('worktime',old('worktime'),['class' => 'form-control','id'=>'worktime']); !!}
                                </div>
                                <div class="col-sm-4">
                                    <span for="Hour" class="control-label ">Hour</span>
                                </div>
                            </div>
                            <div class="row  form-group-scheduletime">
                                <div class="col-sm-1">
                                    {!!Form::checkbox('fixot',1,null,['class' => '','id'=>'fixot']); !!}
                                </div>
                                <div class="col-sm-8">
                                    <span for="Fix Worktime" class="control-label ">Fix Worktime </span>
                                </div> 
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row  form-group-scheduletime">
                                <div class="col-sm-4">
                                    <span for="OT Condition" class="control-label ">OT Condition</span>
                                </div>
                            </div>
                            <div class="row  form-group-scheduletime">
                                <div class="col-sm-3">
                                    <span for="Before Working OT" class="control-label ">Before Working OT</span>
                                </div>
                                <div class="col-sm-9">
                                    <div class="col-sm-2">
                                        <span>
                                            {!! Form::radio('ot', 1,null, ['class' => 'minimal','id'=>'ot']) !!}                               
                                            Max
                                        </span>
                                    </div>
                                    <div class="col-sm-4">
                                        {!!Form::text('ot_text',old('ot_text'),['class' => 'form-control','id'=>'ot_text']); !!}
                                    </div>
                                    <div class="col-sm-6">
                                        <span>Min.</span>
                                        <span>
                                            {!! Form::radio('ot', -1,null, ['class' => 'minimal','id'=>'ot']) !!}                               
                                            Real
                                        </span>
                                        <span>
                                            {!! Form::radio('ot', 0,true, ['class' => 'minimal','id'=>'ot']) !!}                               
                                            No OT
                                        </span>
                                    </div>                                    
                                </div>                               
                            </div>
                            <div class="row  form-group-scheduletime">
                                <div class="col-sm-3">
                                    <span for="Before Working OT" class="control-label ">After Working OT</span>
                                </div>
                                <div class="col-sm-9">
                                    <div class="col-sm-2">
                                        <span>
                                            {!! Form::radio('bot', 1,null, ['class' => 'minimal','id'=>'bot']) !!}                               
                                            Max
                                        </span>
                                    </div>
                                    <div class="col-sm-4">
                                        {!!Form::text('bot_text',old('bot_text'),['class' => 'form-control','id'=>'bot_text']); !!}
                                    </div>
                                    <div class="col-sm-6">
                                        <span>Min.</span>
                                        <span>
                                            {!! Form::radio('bot', -1,null, ['class' => 'minimal','id'=>'bot']) !!}                               
                                            Real
                                        </span>
                                        <span>
                                            {!! Form::radio('bot', 0,true, ['class' => 'minimal','id'=>'bot']) !!}                               
                                            No OT
                                        </span>
                                    </div>                                    
                                </div>                               
                            </div>
                            <div class="row  form-group-scheduletime">
                                <div class="col-sm-4">
                                    <span for="Start Time OT" class="control-label ">Start Time OT</span>
                                </div>
                                <div class="col-sm-8">
                                    {!!Form::select('aot_h',$Hour,old('aot_h'),['class' => 'form-control-scheduletime','id'=>'aot_h']); !!} 
                                    Hour:
                                    {!!Form::select('aot_m',$Min,old('aot_m'),['class' => 'form-control-scheduletime','id'=>'aot_m']); !!} 
                                    Min.
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-sm-8 col-md-offset-2 form-group-scheduletime">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#rate" data-toggle="tab">Rate OT</a></li>
                                <li><a href="#common" data-toggle="tab">Position OT</a></li>
                                <li><a href="#weekend" data-toggle="tab">Weekend</a></li>
                                <li><a href="#holiday" data-toggle="tab">Holiday</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="rate">
                                    <div class="row">
                                        <div class="col-md-12 form-group-scheduletime">
                                            <table class="table table-bordered table-striped tab-scheduletime">
                                                <thead>
                                                    <tr>
                                                        <th>OT 1</th>
                                                        <th>OT 2</th>
                                                        <th> 
                                                            OT 3
                                                        </th>
                                                        <th>OT 4</th>                                   
                                                    </tr>                                                
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            {!!Form::text('rate_ot_1',1,['class' => 'form-control','id'=>'rate_ot_1']); !!}
                                                        </td>
                                                        <td>
                                                            {!!Form::text('rate_ot_2',1.5,['class' => 'form-control','id'=>'rate_ot_2']); !!}
                                                        </td>
                                                        <td>
                                                            {!!Form::text('rate_ot_3',2,['class' => 'form-control','id'=>'rate_ot_3']); !!}
                                                        </td>
                                                        <td>
                                                            {!!Form::text('rate_ot_4',3,['class' => 'form-control','id'=>'rate_ot_4']); !!}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="common">
                                    <div class="row">
                                        <div class="col-md-12 form-group-scheduletime">
                                            <ul >
                                                <li></li>
                                                <li></li>
                                                <li>OT 1</li>
                                                <li>OT 2</li>
                                                <li>OT 3</li>
                                                <li>OT 4</li>

                                            </ul>
                                            <ul>
                                                <li>Montly</li>
                                                <li>OT</li>
                                                <li>{!! Form::radio('common_montly_ot', 1,null, ['class' => 'minimal','id'=>'common_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('common_montly_ot', 2,true, ['class' => 'minimal','id'=>'common_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('common_montly_ot', 3,null, ['class' => 'minimal','id'=>'common_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('common_montly_ot', 4,null, ['class' => 'minimal','id'=>'common_montly_ot']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>Technicial</li>
                                                <li>{!! Form::radio('common_montly_technicial', 1,null, ['class' => 'minimal','id'=>'common_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('common_montly_technicial', 2,null, ['class' => 'minimal','id'=>'common_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('common_montly_technicial', 3,null, ['class' => 'minimal','id'=>'common_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('common_montly_technicial', 4,true, ['class' => 'minimal','id'=>'common_montly_technicial']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li>Daily</li>
                                                <li>OT</li>
                                                <li>{!! Form::radio('common_daily_ot', 1,null, ['class' => 'minimal','id'=>'common_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('common_daily_ot', 2,null, ['class' => 'minimal','id'=>'common_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('common_daily_ot', 3,true, ['class' => 'minimal','id'=>'common_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('common_daily_ot', 4,null, ['class' => 'minimal','id'=>'common_daily_ot']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>Technicial</li>
                                                <li>{!! Form::radio('common_daily_technicial', 1,true, ['class' => 'minimal','id'=>'common_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('common_daily_technicial', 2,null, ['class' => 'minimal','id'=>'common_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('common_daily_technicial', 3,null, ['class' => 'minimal','id'=>'common_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('common_daily_technicial', 4,null, ['class' => 'minimal','id'=>'common_daily_technicial']) !!}</li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="weekend">
                                    <div class="row">
                                        <div class="col-md-12 form-group-scheduletime">
                                            <ul >
                                                <li></li>
                                                <li></li>
                                                <li>OT 1</li>
                                                <li>OT 2</li>
                                                <li>OT 3</li>
                                                <li>OT 4</li>

                                            </ul>
                                            <ul>
                                                <li>Montly</li>
                                                <li>Intime</li>
                                                <li>{!! Form::radio('weekend_montly_intime', 1,true, ['class' => 'minimal','id'=>'weekend_montly_intime']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_intime', 2,null, ['class' => 'minimal','id'=>'weekend_montly_intime']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_intime', 3,null, ['class' => 'minimal','id'=>'weekend_montly_intime']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_intime', 4,null, ['class' => 'minimal','id'=>'weekend_montly_intime']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>OT</li>
                                                <li>{!! Form::radio('weekend_montly_ot', 1,null, ['class' => 'minimal','id'=>'weekend_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_ot', 2,null, ['class' => 'minimal','id'=>'weekend_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_ot', 3,null, ['class' => 'minimal','id'=>'weekend_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_ot', 4,true, ['class' => 'minimal','id'=>'weekend_montly_ot']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>Technicial</li>
                                                <li>{!! Form::radio('weekend_montly_technicial', 1,true, ['class' => 'minimal','id'=>'weekend_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_technicial', 2,null, ['class' => 'minimal','id'=>'weekend_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_technicial', 3,null, ['class' => 'minimal','id'=>'weekend_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('weekend_montly_technicial', 4,null, ['class' => 'minimal','id'=>'weekend_montly_technicial']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li>Daily</li>
                                                <li>Intime</li>
                                                <li>{!! Form::radio('weekend_daily_intime', 1,null, ['class' => 'minimal','id'=>'weekend_daily_intime']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_intime', 2,null, ['class' => 'minimal','id'=>'weekend_daily_intime']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_intime', 3,true, ['class' => 'minimal','id'=>'weekend_daily_intime']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_intime', 4,null, ['class' => 'minimal','id'=>'weekend_daily_intime']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>OT</li>
                                                <li>{!! Form::radio('weekend_daily_ot', 1,null, ['class' => 'minimal','id'=>'weekend_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_ot', 2,null, ['class' => 'minimal','id'=>'weekend_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_ot', 3,null, ['class' => 'minimal','id'=>'weekend_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_ot', 4,true, ['class' => 'minimal','id'=>'weekend_daily_ot']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>Technicial</li>
                                                <li>{!! Form::radio('weekend_daily_technicial', 1,true, ['class' => 'minimal','id'=>'weekend_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_technicial', 2,null, ['class' => 'minimal','id'=>'weekend_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_technicial', 3,null, ['class' => 'minimal','id'=>'weekend_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('weekend_daily_technicial', 4,null, ['class' => 'minimal','id'=>'weekend_daily_technicial']) !!}</li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="holiday">
                                    <div class="row">
                                        <div class="col-md-12 form-group-scheduletime">
                                            <ul >
                                                <li></li>
                                                <li></li>
                                                <li>OT 1</li>
                                                <li>OT 2</li>
                                                <li>OT 3</li>
                                                <li>OT 4</li>

                                            </ul>
                                            <ul>
                                                <li>Montly</li>
                                                <li>Intime</li>
                                                <li>{!! Form::radio('holiday_montly_intime', 1,true, ['class' => 'minimal','id'=>'holiday_montly_intime']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_intime', 2,null, ['class' => 'minimal','id'=>'holiday_montly_intime']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_intime', 3,null, ['class' => 'minimal','id'=>'holiday_montly_intime']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_intime', 4,null, ['class' => 'minimal','id'=>'holiday_montly_intime']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>OT</li>
                                                <li>{!! Form::radio('holiday_montly_ot', 1,null, ['class' => 'minimal','id'=>'holiday_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_ot', 2,null, ['class' => 'minimal','id'=>'holiday_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_ot', 3,null, ['class' => 'minimal','id'=>'holiday_montly_ot']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_ot', 4,true, ['class' => 'minimal','id'=>'holiday_montly_ot']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>Technicial</li>
                                                <li>{!! Form::radio('holiday_montly_technicial', 1,true, ['class' => 'minimal','id'=>'holiday_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_technicial', 2,null, ['class' => 'minimal','id'=>'holiday_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_technicial', 3,null, ['class' => 'minimal','id'=>'holiday_montly_technicial']) !!}</li>
                                                <li>{!! Form::radio('holiday_montly_technicial', 4,null, ['class' => 'minimal','id'=>'holiday_montly_technicial']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li>Daily</li>
                                                <li>Intime</li>
                                                <li>{!! Form::radio('holiday_daily_intime', 1,null, ['class' => 'minimal','id'=>'holiday_daily_intime']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_intime', 2,null, ['class' => 'minimal','id'=>'holiday_daily_intime']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_intime', 3,true, ['class' => 'minimal','id'=>'holiday_daily_intime']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_intime', 4,null, ['class' => 'minimal','id'=>'holiday_daily_intime']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>OT</li>
                                                <li>{!! Form::radio('holiday_daily_ot', 1,null, ['class' => 'minimal','id'=>'holiday_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_ot', 2,null, ['class' => 'minimal','id'=>'holiday_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_ot', 3,null, ['class' => 'minimal','id'=>'holiday_daily_ot']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_ot', 4,true, ['class' => 'minimal','id'=>'holiday_daily_ot']) !!}</li>
                                            </ul>
                                            <ul>
                                                <li></li>
                                                <li>Technicial</li>
                                                <li>{!! Form::radio('holiday_daily_technicial', 1,true, ['class' => 'minimal','id'=>'holiday_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_technicial', 2,null, ['class' => 'minimal','id'=>'holiday_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_technicial', 3,null, ['class' => 'minimal','id'=>'holiday_daily_technicial']) !!}</li>
                                                <li>{!! Form::radio('holiday_daily_technicial', 4,null, ['class' => 'minimal','id'=>'holiday_daily_technicial']) !!}</li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>                                
                            </div>                          
                        </div>
                    </div>


                    <div class="col-sm-12 form-group-scheduletime">
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
{!! Html::script('assets/dist/js/management/scheduletime.js') !!}


@endsection