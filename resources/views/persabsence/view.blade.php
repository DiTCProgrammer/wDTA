@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/persabsence/persabsence.css') !!}
@endsection
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--persabsence">
    <div class="col-md-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="title">SETTINGS</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body from-view">
                <div class="row">
                    <div class="col-md-6">
                        <h3>
                            Persabsence
                        </h3>                

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ url('persabsence/create')}}" class="btn btn-default">
                            Add New Holiday Official <i class="fa fa-plus"></i>
                        </a>

                    </div>                
                    <div class="col-md-8">
                        <form action="{{url('persabsence/view')}}" method="post">
                            <table class="filter">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label for="">Department</label>
                                            <select name="form[dept]" onchange="this.form.submit()">
                                                <option value="0">Change Department</option>
                                                <?php
                                                if ($dept) {
                                                    foreach ($dept as $val) {
                                                        ?>
                                                        <option value="{{$val->id}}" <?php echo ($state == 1 && $dept_id == $val->id ? 'selected="selected"' : ''); ?>>{{$val->name}}</option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <label for="">Date Range</label>
                                            <input type="text" readonly="readonly" class="pull-right calendar" name="form[ddate]" style="float: none !important;" value="<?php echo ($state == 1 && $ddate ? $ddate : date('Y-m-d') . ' - ' . date('Y-m-d', strtotime("+1 month", strtotime(date('Y-m-d'))))); ?>">
                                            <i class="fa fa-calendar calendar_icon" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <label for="">Status</label>
                                            <select name="form[state]" onchange="this.form.submit()">
                                                <option>Change Status</option>
                                                <option value="-1" <?php echo ($state == 1 && $status == -1 ? 'selected="selected"' : ''); ?>>ไม่อนุมัติ</option>
                                                <option value="0" <?php echo ($state == 1 && $status == 01 ? 'selected="selected"' : ''); ?>>ไม่ยื่นคำขอ</option>
                                                <option value="1" <?php echo ($state == 1 && $status == 1 ? 'selected="selected"' : ''); ?>>อนุมัติ</option>
                                                <option value="-2" <?php echo ($state == 1 && $status == 2 ? 'selected="selected"' : ''); ?>>ยกเลิก</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        </form>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>Empcode</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Name Absence</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key=> $row)
                                <?php
//                                echo '<pre>';
//                                print_r($row);exit;
                                ?>
                                <tr>

                                    <td>
                                        {{$row->empcode}}                                   
                                    </td>
                                    <td>
                                        {{$row->firstname}} {{$row->lastname}}                                   
                                    </td>
                                    <td>
                                        {{$row->rank1}} -  {{$row->rank2}}                                    
                                    </td>
                                    <td>
                                        {{$row->status_name}}                                   
                                    </td>
                                    <td>     
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" 
                                                data-empcode="{{$row->empcode}}"
                                                data-name="{{$row->firstname}} {{$row->lastname}} "
                                                data-date="{{$row->rank1}} -  {{$row->rank2}}"
                                                data-absence="{{$row->status_name}}"
                                                data-detial="{{$row->comment}}"
                                                data-img="{{($row->attfile?url($row->attfile):'')}}">
                                            View
                                        </button>                           

                                        <a  onclick="delPersabsence('<?= $row->group ?>')" class="btn btn-del">
                                            <i class="fa fa-trash"></i>
                                            Delete                                        
                                        </a>                                  
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>         
                        <div class="col-xs-12 text-center">
                            {!! $data->links() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>View Persabsence</h4>
            </div>
            <div class="modal-body">
                <div class="modal-empcode"></div>
                <div class="modal-name"></div>
                <div class="modal-date"></div>
                <div class="modal-absence"></div>
                <div class="modal-detial"></div>
                <div class="modal-img"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/attendance/detatime/daterangepicker.js') !!}
{!! Html::script('assets/dist/js/persabsence/persabsence.js') !!}

@endsection

