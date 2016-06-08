@extends('layouts.app')
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

    {!! Form::open(array('url' => '/department/update','class'=>'','id'=>'form_department','files' => true)) !!}
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-sm-4">
                    <label>{{ trans('department.code') }}</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-4"><input type="text" class="form-control " id="code" name="code" value="{{ old('code') }}"  ></div>
                <div class="col-sm-4"><div class="show_status_code"></div></div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label>{{ trans('department.name') }}</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-8"><input type="text" class="form-control " id="name" name="name" value="{{ old('name') }}"  ></div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label>{{ trans('department.sttnight') }}</label>&nbsp;<span id="necessary">*</span>
                    <span class="span-right hidden-xs">:</span>
                </div>
                <div class="col-sm-8">
                    <input type="radio" name="status_night" id="status_night" class="minimal night" value="1" <?php echo (old('status_night') == 1 ? 'checked' : ''); ?>>
                    {{ trans('department.use') }}&nbsp;&nbsp;
                    <input type="radio" name="status_night" id="status_night" class="minimal night" value="0" <?php echo old('status_night') ? (old('status_night') == 0 ? 'checked' : '') : 'checked'; ?>>
                    {{ trans('department.nouse') }}
                </div>
            </div>

            <div class="row time_val">
                <div class="col-sm-4">
                    <label>{{ trans('department.settime') }}</label>
                    <span class="span-right hidden-xs">:</span>
                </div>

                <div class="col-sm-3">
                    <select class="form-control" name="time_h" id="time_h"> 
                        <option value="00" <?php echo (old('time_h') == 00 ? 'selected' : ''); ?> >{{ trans('department.hour') }}</option>                                
                        @for ($i = 1; $i <= 23; $i++)
                        <option value="{{$i}}" <?php echo (old('time_h') == $i ? 'selected' : ''); ?> ><?= sprintf("%02d", $i) ?></option>
                        @endfor                                

                    </select>
                </div>

                <div class="col-sm-3">
                    <select class="form-control" name="time_m" id="time_m">   
                        <option value="00" <?php echo (old('time_h') == 00 ? 'selected' : ''); ?> >{{ trans('department.minute') }}</option> 
                        @for ($i = 1; $i <= 59; $i++)
                        <option value="{{$i}}" <?php echo (old('time_m') == $i ? 'selected' : ''); ?> ><?= sprintf("%02d", $i) ?></option>
                        @endfor                                

                    </select>  
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
                            <input type="radio" name="icon" id="icon" class="minimal" value="{{$img}}" <?php echo (old('icon') == $img ? 'checked' : ''); ?>>
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