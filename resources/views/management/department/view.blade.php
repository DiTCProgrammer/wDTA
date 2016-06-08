@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/management/department.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--department">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="title">{{ trans('menu.setting') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>
                {{ trans('department.department') }}
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <a href="{{ url('department/create')}}" class="btn btn-default" style="max-width: 100%;">
                <i class="fa fa-plus"></i> {{ trans('department.add') }}
            </a>
        </div>

        <div class="col-md-1">
            <label class="label_search">
                Search
            </label>
        </div>
        <div class="col-md-8">
            <form action="{{url('department')}}" method="post">
                <div class="search">
                    <input type="text" id="employee_search_text" name="search" value="<?php echo ($search?$search:'');?>">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <input type="hidden" value="{{ csrf_token() }}" name="_token">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('department.no') }}</th>
                        <th class="text-center">{{ trans('department.code') }}</th>
                        <th class="text-center">{{ trans('department.department') }}</th>
                        <th class="text-center">{{ trans('department.icon') }}</th>
                        <th class="text-center">{{ trans('department.action') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($dataDep as $key=> $row)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td class="text-center">
                            {{$row->code}}                                   
                        </td>
                        <td class="text-center">{{$row->name}}</td>
                        <td> 
                            @if($row->icon)
                            <img src="{{ url('images/icon').'/'.$row->icon}}" class="img-responsive"  />
                            @else
                            <img src="{{url('').'/pictures/default.jpg'}}" class="img-responsive" />
                            @endif
                        </td>
                        <td class="text-center">

                            <a href="{{ url('department/'.$row->id.'/edit')}}" class="btn btn-edit">
                                <i class="fa fa-edit"></i>
                                {{ trans('department.viewedit') }}                                        
                            </a>


                            <a  onclick="delDepartment('<?= $row->id ?>')" class="btn btn-del">
                                <i class="fa fa-trash"></i>
                                {{ trans('department.delete') }}                                        
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-center">

                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('footer')

{!! Html::script('assets/dist/js/management/department.js') !!}
{!! Html::script('assets/plugins/datatables/jquery.dataTables.min.js') !!}
{!! Html::script('assets/plugins/datatables/dataTables.bootstrap.min.js') !!}

@endsection

