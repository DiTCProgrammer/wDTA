@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/management/holiday.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--holiday">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="title">SETTINGS</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>
                Holiday Business Holidays
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href="{{ url('holiday/business/add')}}" class="btn btn-default">
                Add New <i class="fa fa-plus"></i>
            </a>
        </div>    
    </div>


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Business Holidays</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($dataBusiness as $key=> $row)
                    <tr>
                        <td class="text-center">
                            {{$row['name']}}
                        </td>
                        <td class="text-center">
                            {{$row['rank']}}                                   
                        </td>
                        <td class="text-center">
                            {{$row['description']}}                                   
                        </td>
                        <td class="text-center">                                 

                            <a  onclick="delHolidatBusiness('<?= $row['group'] ?>')" class="btn btn-del">
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
{!! Html::script('assets/dist/js/management/holiday.js') !!}

@endsection

