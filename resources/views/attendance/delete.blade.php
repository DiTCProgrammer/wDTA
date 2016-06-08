
@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="attendance--delete_form">
    <div class="containner">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class='title'>attendance management</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="sub_title">Delete Data</h2>
            </div>
        </div>

        <div class='row'>
            <div class="col-md-8 col-md-offset-2">
                @if (session('status') && session('type') == 1)
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
                @elseif(session('status') && session('type') == 0)
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <form action="{{url('delete/destroy')}}" method="post" id="delete">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box_delete_data">
                        <div class="box_row">
                            <div class="box_radio">
                                <input type="radio" name="form[type_delete]" value="1">
                                <div class="box_sub_radio">
                                    <div class="box_radio_focus"></div>
                                </div>
                                <label>Delete All</label>
                            </div> 
                        </div>


                        <div class="box_row">
                            <div class="box_radio">
                                <input type="radio" name="form[type_delete]" value="2">
                                <div class="box_sub_radio">
                                    <div class="box_radio_focus"></div>
                                </div>
                                <label>Delete Department</label>
                            </div>

                            <div class="select"  style="display: none;">
                                <select name="form[department]">
                                    <option value="0">Change Department</option>
                                    <?php
                                    if ($dept_data) {
                                        foreach ($dept_data as $val) {
                                            ?>
                                            <option value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>


                        <div class="box_row">
                            <div class="box_radio">
                                <input type="radio" name="form[type_delete]" value="3">
                                <div class="box_sub_radio">
                                    <div class="box_radio_focus"></div>
                                </div>
                                <label>Delete User</label>

                            </div>

                            <div class="search" style="display: none;">
                                <input type="text" id="employee_search_text" value="">
                                <a class="btn_search">
                                    <i class="fa fa-search"></i>
                                </a>
                                <input type="hidden" name="form[employee_id]" value="" id="employee_id">
                            </div>

                            <div class="show_search" style="display: none;">
                                <ul>

                                </ul>
                            </div>

                        </div>

                        <div class="box_row">
                            <div class="box_calendar">
                                <label>Date</label>
                                <input type="text" id="date_length" name="form[date_length]" readonly="readonly" class="pull-right calendar" style="float:none !important;" type="text" name="date_length" value="<?php echo date('Y-m-d') ?> - <?php echo date('Y-m-d', strtotime("+1 month", strtotime(date('Y-m-d')))); ?>" >
                                <i class="fa fa-calendar calendar_icon" aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="box_row text-center">
                            <button type="button"  class="btn btn-danger" onclick="delWeekendDepertment()">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{ csrf_token() }}" name="_token">
            </form>
        </div>





    </div>
</div>

@endsection

@section('footer')
{!! Html::script('assets/dist/js/attendance/detatime/daterangepicker.js') !!}
<script src="assets/dist/js/attendance/attendance_delete.js" type="text/javascript"></script>
<script src="assets/dist/js/attendance/delete.js" type="text/javascript"></script>
@endsection

@section('css')
<link href="assets/dist/css/attendance/attendance_delete.css" rel="stylesheet" type="text/css">
@endsection