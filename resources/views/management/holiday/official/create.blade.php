@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/management/holiday.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--holiday">
    <div class="col-md-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="title">SETTINGS</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body from-view">
                <div class="col-md-6">
                    <h3>
                        Holiday
                    </h3>
                    <h3>
                       Add Official
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
                <div class="col-md-8 col-md-offset-2">
                    {!! Form::open(array('url' => '/holiday/official/update','class'=>'','id'=>'form_department','files' => true)) !!}
                    <div class="col-sm-12 form-group-holiday">
                        <span for="Description" class="col-sm-4 control-label ">Description <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-4">                       
                            <input type="text" class="form-control " id="description" name="description" value="{{ old('empcode') }}"  >
                        </div>
                        
                    </div>
                    <div class="col-sm-12 form-group-holiday">
                        <span for="Date_length" class="col-sm-4 control-label ">Date <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-4 ">
                            <input readonly="readonly" class="form-control pull-right" type="text" name="date_length" value="{{ old('date_length') }}" />                                                      
                        </div>          

                    </div>
                    <div class="col-sm-12 form-group-holiday">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-info"><i class="fa  fa-save "></i>SAVE</button>
                        </div>                                
                    </div>
                    {!! Form::close() !!} 
                </div>

            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/holiday.js') !!}
{!! Html::script('assets/dist/js/attendance/detatime/daterangepicker.js') !!}
@endsection

