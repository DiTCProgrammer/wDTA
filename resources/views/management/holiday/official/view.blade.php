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
                    <h1 class="title">{{ trans('holiday.title')}}</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body from-view">
                <div class="col-md-6">
                    <h3>
                        Holiday
                    </h3>
                    <h3>
                        Official Holidays
                    </h3>

                </div>
                <div class="col-md-12">
                    <a href="{{ url('holiday/official/add')}}" class="btn btn-default">
                        Add New Holiday Official <i class="fa fa-plus"></i>
                    </a>
                </div>                
                <div class="col-md-8 col-md-offset-2">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                               
                                <th>Date</th>
                                <th>Official Holidays</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataOfficial as $key=> $row)
                            <tr>
                              
                                <td>
                                    {{$row['rank']}}                                   
                                </td>
                                <td>
                                    {{$row['description']}}                                   
                                </td>
                                <td>                                 
                                   
                                    <a  onclick="delHolidatOfficial('<?= $row['group'] ?>')" class="btn btn-del">
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
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/holiday.js') !!}

@endsection

