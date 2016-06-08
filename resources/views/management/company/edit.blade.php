@extends('layouts.app')
@section('css')
{!! Html::style('assets/dist/css/management/company.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--company">
    <div class="col-md-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="title">{{ trans('menu.setting') }}</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    <h3>
                        {{ trans('company.company') }}
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
                    {!! Form::open(array('url' => '/company/'.$dataCom[0]->id.'/update','class'=>'','id'=>'form_employee','files' => true)) !!}

                    <div class="col-sm-12 form-group-company">
                        <span for="Name" class="col-sm-4 control-label ">{{ trans('company.name') }} <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-4">
                            {!! Form::text('name', $dataCom[0]->name, ['class' => 'form-control','id'=>'name']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <span for="Address" class="col-sm-4 control-label">{{ trans('company.address') }} <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            {!! Form::textarea('address', $dataCom[0]->address, ['class' => 'form-control','id'=>'address', 'rows' => '5']) !!}                           
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <span for="Tax Id" class="col-sm-4 control-label ">{{ trans('company.taxid') }} <span id="necessary">*</span> <span class="span-right">:</span></span>
                        <div class="col-sm-4">
                            {!! Form::text('tax_id', $dataCom[0]->tax_id, ['class' => 'form-control','id'=>'tax_id']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <span for="Tel" class="col-sm-4 control-label ">{{ trans('company.tel') }} <span class="span-right">:</span></span>
                        <div class="col-sm-4">
                            {!! Form::tel('tel', $dataCom[0]->tel, ['class' => 'form-control','id'=>'tel']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <span for="Fax" class="col-sm-4 control-label ">{{ trans('company.fax') }}  <span class="span-right">:</span></span>
                        <div class="col-sm-4">
                            {!! Form::tel('fax', $dataCom[0]->fax, ['class' => 'form-control','id'=>'fax']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <span for="Phone" class="col-sm-4 control-label ">{{ trans('company.phone') }} <span class="span-right">:</span></span>
                        <div class="col-sm-4">
                            {!! Form::tel('phone', $dataCom[0]->phone, ['class' => 'form-control','id'=>'phone']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <span for="Email" class="col-sm-4 control-label ">{{ trans('company.email') }} <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            {!! Form::email('email', $dataCom[0]->email, ['class' => 'form-control','id'=>'email']) !!}
                        </div>                        
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <span for="Website" class="col-sm-4 control-label ">{{ trans('company.website') }} <span class="span-right">:</span></span>
                        <div class="col-sm-8">
                            {!! Form::url('website', $dataCom[0]->website, ['class' => 'form-control','id'=>'website']) !!}
                        </div>                        
                    </div>

                    <div class="col-sm-12 form-group-company">
                        <span for="Start Working" class="col-sm-4 control-label">{{ trans('company.logo') }} <span class="span-right">:</span></span>

                        <div class="col-sm-6">
                            <div class="file">
                                {!! Form::file('logo', $attributes = ['id'=>'img_onload','class'=>'form-control pull-right']);  !!}
                                <div data-default="Choose a file">Choose a file</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group-company">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8 ">
                            <div class="show_img">
                                @if($dataCom[0]->logo)
                                <img src="{{url('').'/'.$dataCom[0]->logo}}" />
                                @else
                                <img src="{{url('').'/pictures/default.jpg'}}" />
                                @endif
                            </div>
                        </div>
                    </div>
                    {!! Form::hidden('img_edit', $dataCom[0]->logo, ['class' => 'form-control','id'=>'img_edit']) !!} 

                    <div class="col-sm-12 form-group-company">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-info"><i class="fa  fa-save "></i>{{ trans('company.save') }}</button>
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
{!! Html::script('assets/dist/js/management/company.js') !!}

@endsection