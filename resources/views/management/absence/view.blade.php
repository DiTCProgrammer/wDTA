@extends('layouts.app')
@section('css')
{!! Html::style('assets/dist/css/management/absence.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--absence">
    <div class="col-md-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="title">VIEW ABSENCE</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body from-view">
                <div class="col-md-6">
                    <h3>
                        Absence
                    </h3>
                   
                </div>
                <div class="col-md-12">
                    <a href="{{ url('absence/add/edit')}}" class="btn btn-default">
                        Add New Absence <i class="fa fa-plus"></i>
                    </a>
                </div>

                <div class="col-md-8 col-md-offset-2">
                    <table id="absence" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                            <tr>
                                <td>{{$row->name}}</td>                                
                                <td>                                    
                                    <a href="{{ url('absence/'.$row->id.'/edit')}}" class="btn btn-edit">
                                        <i class="fa fa-edit"></i>
                                         View/Edit                                        
                                    </a>
                                   
                                        <a  onclick="delAbsence('<?=$row->id?>')" class="btn btn-del">
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


@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/absence.js') !!}
@endsection

