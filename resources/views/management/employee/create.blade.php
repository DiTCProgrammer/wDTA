@extends('layouts.app')
<!--<link href="assets/dist/css/management/employee.css" rel="stylesheet" type="text/css">-->
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

                    {!! Form::open(array('url' => '/employee/update','class'=>'','id'=>'form_employee','files' => true)) !!}

                    <div class="col-sm-12 form-group-employee">
                        <span for="Empty" class="col-sm-4 control-label ">Empty Code <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-4">
                       
                            <input type="text" class="form-control " id="empcode" name="empcode" value="{{ old('empcode') }}"  >
                        </div>
                        <div class="col-sm-4">
                        <div class="show_status_emptycode"></div>
                          </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Prefix" class="col-sm-4 control-label">Prefix <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <select class="form-control" name="prefix" id="prefix">                            
                                <option value="นาย" <?php echo (old('prefix') == 'นาย'?'selected':'');?> >นาย</option>
                                <option value="นาง" <?php echo (old('prefix') == 'นาง'?'selected':'');?>>นาง</option>
                                <option value="นางสาว" <?php echo (old('prefix') == 'นางสาว'?'selected':'');?>>นางสาว</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="First Name" class="col-sm-4 control-label ">First Name <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            <input type="text" class="form-control " id="firstname" name="firstname" value="{{ old('firstname') }}"  >
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Last Name" class="col-sm-4 control-label">Last Name <span id="necessary">*</span> <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}"  >
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Gender" class="col-sm-4 control-label">Gender <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-3">
                            <select class="form-control" name="sex" id="sex">
                                <option value="ชาย" <?php echo (old('sex') =='ชาย'?'selected':'');?> >Male</option>
                                <option value="หญิง" <?php echo (old('sex') == 'หญิง'?'selected':'');?> >Female</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Department" class="col-sm-4 control-label">Department <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <select class="form-control" name="Department" id="Department">
                                @foreach($department as $row)

                                <option value="{{$row->id}}-{{$row->group_condition}}" <?php echo (old('Department') == $row->id.'-'.$row->group_condition?'selected':'');?> >{{$row->name}}</option>

                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Identfication Card" class="col-sm-4 control-label">Identfication Card <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="idcard" name="idcard" value="{{ old('idcard') }}" >
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee " >
                        <span for="Date of Birth" class="col-sm-4 control-label">Date of Birth <span class="span-right">:</span></span>

                        <div class="col-sm-4">
                            <input type="text" class="form-control pull-right" name="date_birth" id="date_birth" value="{{ old('date_birth') }}" >                             
                        </div>
                        <span class="fa fa-calendar"   ></span>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Date of Birth" class="col-sm-4 control-label">Warking Type <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                <input type="radio" name="paytype" id="paytype" class="minimal" value="1" <?php echo old('paytype')?(old('paytype') == 1?'checked':''):'checked';?>>
                                Monthly
                            </span>
                            <span>
                                <input type="radio" name="paytype" id="paytype" class="minimal" value="2" <?php echo (old('paytype') == 2?'checked':'');?>>
                                Daily
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Pay" class="col-sm-4 control-label">Pay <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="Pay" name="Pay" value="{{ old('Pay') }}" >
                        </div>
                    </div>
                    
                    
                    <div class="col-sm-12 form-group-employee">
                        <span for="Department" class="col-sm-4 control-label">Group Condition Me <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <select class="form-control" name="group_me" id="group_me">
                                <option value="">-- Select Group --</option>
                                @foreach($condition_time as $row)
                                <option value="{{$row->group}}" <?php echo (old('group_me') == $row->group?'selected':'');?>>{{$row->group}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Position" class="col-sm-4 control-label">Position <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="position" name="position" value="{{ old('position') }}" >
                        </div>
                    </div>
                     <div class="col-sm-12 form-group-employee">
                        <span for="Extrawage" class="col-sm-4 control-label">Extrawage <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="extrawage" name="extrawage" value="{{ old('extrawage') }}" >
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee show_extrawage_status">
                        <span for="Extrawage Status" class="col-sm-4 control-label">Extrawage Status <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                <input type="radio" name="extrawage_status" id="extrawage_status" class="minimal" value="1" <?php echo old('extrawage_status')?(old('extrawage_status') == 1?'checked':''):'checked';?>>
                                Use
                            </span>
                            <span>
                                <input type="radio" name="extrawage_status" id="extrawage_status" class="minimal" value="0" <?php echo (old('extrawage_status') == 0?'checked':'');?>>
                                No
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Technicialwage Status" class="col-sm-4 control-label">Technicialwage Status <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                <input type="radio" name="technicialwage_status" id="technicialwage_status" class="minimal" value="1" <?php echo old('technicialwage_status')?(old('technicialwage_status') == 1?'checked':''):'checked';?>>
                                Use
                            </span>
                            <span>
                                <input type="radio" name="technicialwage_status" id="technicialwage_status" class="minimal" value="0" <?php echo (old('technicialwage_status') == 0?'checked':'');?>>
                                No
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Weekend Status" class="col-sm-4 control-label">Weekend Status <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            <span>
                                <input type="radio" name="weekendotorday" id="weekendotorday" class="minimal" value="1" <?php echo old('weekendotorday')?(old('weekendotorday') == 1?'checked':''):'checked';?>>
                                Day
                            </span>
                            <span>
                                <input type="radio" name="weekendotorday" id="weekendotorday" class="minimal" value="0" <?php echo (old('weekendotorday') == 0?'checked':'');?>>
                                OT
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 form-group-employee">
                        <span for="Technicial" class="col-sm-4 control-label">Technicial wage <span class="span-right">:</span></span>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="technicialwage" name="technicialwage" value="{{ old('technicialwage') }}" >
                        </div>
                    </div>            
                    <div class="col-sm-12 form-group-employee">
                        <span for="Start Working" class="col-sm-4 control-label">Start Working <span class="span-right">:</span></span>

                        <div class="col-sm-4">

                            <input type="text" class="form-control pull-right" id="date_working" value="{{ old('date_working') }}" name="date_working">

                        </div>
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <span for="Start Working" class="col-sm-4 control-label">Image <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            <input type="file" class="form-control pull-right" id="img_onload" name="image" value="{{ old('image') }}">
                        </div>
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <div class="col-sm-12 form-group-employee">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8 ">
                            <div class="show_img"></div>
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
</div>

@endsection
<!--@section('footer')-->
{!! Html::script('assets/dist/js/management/management.js') !!}
{!! Html::script('assets/dist/js/management/employee.js') !!}

<!--@endsection-->