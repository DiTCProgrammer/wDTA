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
            <h3>Week End Department</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href="{{ url('weekend/depertment/add')}}" class="btn btn-default">
                Add New <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <P></P>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Department</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Day</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataWeek as $key=> $row)
                    <tr>
                        <td class="text-center">{{ $row['department'] }}</td>
                        <td class="text-center">
                            {{$row['date']}}                                   
                        </td>
                        <td class="text-center">
                            {{$row['day']}}                                   
                        </td>
                        <td class="text-center">                                                                 
                            <a  onclick="delWeekendDepertment('<?= $row['id'] ?>')" class="btn btn-del">
                                <i class="fa fa-trash"></i>
                                Delete                                        
                            </a>                                  
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/weekend.js') !!}

@endsection

