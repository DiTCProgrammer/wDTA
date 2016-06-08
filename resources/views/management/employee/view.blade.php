@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/management/employee.css') !!}
@endsection
@section('content')
<?php
//echo '<pre>';
//print_r($dataEmp);exit;
?>

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--employee">
    <div class="col-md-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="title">VIEW EMPLOYEE</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body from-view">
                <div class="col-md-6">
                    <h3>
                        Employee
                    </h3>
                    <h3>
                        General Information
                    </h3>
                </div>
                <div class="col-md-12">
                    <a href="{{ url('employee/createuser')}}" class="btn btn-default">
                        Add New Employee <i class="fa fa-plus"></i>
                    </a>
                </div>

                <div class="col-md-8 col-md-offset-2">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>EmployeeID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>At Work</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataEmp as $dataEmpRow)
                            <tr>
                                <td>{{$dataEmpRow->empcode}}</td>
                                <td>
                                    @if($dataEmpRow->picture)
                                    <img src="{{url('').'/'.$dataEmpRow->picture}}" />
                                    @else
                                    <img src="{{url('').'/pictures/default.jpg'}}" />
                                    @endif
                                </td>
                                <td>{{$dataEmpRow->prefix.' '.$dataEmpRow->firstname.' '.$dataEmpRow->lastname}}</td>
                                <td>{{$dataEmpRow->date_working}}</td>
                                <td>
                                    <p>
                                    <a href="{{ url('employee/'.$dataEmpRow->id_emp.'/edit')}}" class="btn btn-edit">
                                        <i class="fa fa-edit"></i>
                                         View/Edit                                        
                                    </a>
                                    </p>
                                    <p>
                                        <a  onclick="delCheck('<?=$dataEmpRow->id?>')" class="btn btn-del">
                                        <i class="fa fa-trash"></i>
                                          Delete                                        
                                    </a>
                                    </p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-center">
                                    {!! $dataEmp->links() !!}
                                </td>
                            </tr>
                        </tfoot>
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
{!! Html::script('assets/dist/js/management/management.js') !!}
{!! Html::script('assets/dist/js/management/employee.js') !!}

@endsection

