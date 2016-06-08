@extends('layouts.app')
@section('css')
{!! Html::style('assets/dist/css/persabsence/persabsence.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--persabsence">
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
                        Persabsence
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
                    <div class="col-sm-12 form-group-persabsence">
                        <div class="search">
                            <input type="text" id="employee_search_text" value="">
                            <a class="btn_search">
                                <i class="fa fa-search"></i>
                            </a>
                            <input type="hidden" name="form[employee_id]" value="" id="employee_id">
                        </div>

                        <div class="show_search" style="display: none;">
                            <ul>

                            </ul>
                        </div>

                        <!--                        <div class="input-group margin">
                                                    <input type="text" class="form-control" id="search">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-flat"><i class="fa  fa-search"></i></button>
                                                    </span>
                                                </div>
                                                <div class="showSearch"></div>-->
                    </div>
                    {!! Form::open(array('url' => '/persabsence/update','class'=>'','id'=>'form_persabsence','files' => true)) !!}

                    <div class="col-sm-12 form-group-persabsence">
                        <span for="Empty" class="col-sm-4 control-label ">Empty Code <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-4">
                            <input type="text" readonly="readonly" class="form-control " id="empcode" name="empcode" value="{{ old('empcode') }}"  >
                            <input type="hidden"  class="form-control " id="id_empcode" name="id_empcode" value="{{ old('id_empcode') }}"  >
                            <input type="hidden"  class="form-control " id="dept_id" name="dept_id" value="{{ old('dept_id') }}"  >
                        </div>                       
                    </div>
                    <div class="col-sm-12 form-group-persabsence">
                        <span for="Date length" class="col-sm-4 control-label ">Date <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-8 ">
                            <input readonly="readonly" class="form-control pull-right" type="text" name="date_length" value="{{ old('date_length') }}" />                                                      
                        </div>          

                    </div>

                    <div class="col-sm-12 form-group-persabsence">
                        <span for="Absence" class="col-sm-4 control-label ">Absence <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-4 ">
                            <select class="form-control" name="Absence" id="Absence">
                                @foreach($absence as $row)

                                <option value="{{$row->id}}-{{$row->name}}" <?php echo (old('Absence') == $row->id . '-' . $row->name ? 'selected' : ''); ?> >{{$row->name}}</option>

                                @endforeach 
                            </select>                                                
                        </div>          

                    </div>
                    <div class="col-sm-12 form-group-persabsence">
                        <span for="Detial" class="col-sm-4 control-label ">Detial <span class="span-right">:</span></span>
                        <div class="col-sm-8 ">
                            <textarea name="comment" id="comment" class="form-control" rows="4" >{{ old('comment') }}</textarea>                                                      
                        </div>          

                    </div>
                    <div class="col-sm-12 form-group-persabsence">
                        <span for="Attfile" class="col-sm-4 control-label ">Attfile <span class="span-right">:</span></span>
                        <div class="col-sm-6">
                            <div class="file">
                                <input type="file" name="attfile" id="attfile" class="form-control" > 
                                <div data-default="Choose a file">Choose a file</div>
                            </div>                           
                        </div>          

                    </div>
                    <div class="col-sm-12 form-group-persabsence">
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
{!! Html::script('assets/dist/js/persabsence/persabsence.js') !!}
{!! Html::script('assets/dist/js/attendance/detatime/daterangepicker.js') !!}

@endsection