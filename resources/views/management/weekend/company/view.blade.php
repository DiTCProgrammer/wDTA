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
            <h3>Week End Company</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <a href="{{ url('weekend/company/add')}}" class="btn btn-default">
                Add New <i class="fa fa-plus"></i>
            </a>
        </div>       
    </div>


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Year</th>
                        <th class="text-center">Week end</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($dataWeek as $key=> $row)
                    <tr>
                        <td class="text-center">{{ $row['year'] }}</td>
                        <td class="text-center">
                            {{$row['day']}}                                   
                        </td>
                        <td class="text-center">                                 
                            <a href="{{ url('weekend/company/'.$row['id'].'/edit')}}" class="btn btn-edit">
                                <i class="fa fa-edit"></i>
                                View/Edit                                        
                            </a>

                            <a  onclick="delWeekendCompany('<?= $row['id'] ?>')" class="btn btn-del">
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
</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/weekend.js') !!}

@endsection

