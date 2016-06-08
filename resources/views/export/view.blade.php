@extends('layouts.app')
@section('css')
{!! Html::style('assets/dist/css/management/export.css') !!}

@endsection
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="attendance--export_form">
    <div class="containner">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class='title'>Export Excel</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="sub_title">Export Excel</h2>
            </div>
        </div>

        <div class="row">
            <form action="{{url('export/excel')}}" method="post" id="export">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box_export_data">
                        <div class="box_row">
                            <div class="box_radio">
                                <input type="radio" name="form[type_export]" value="1">
                                <div class="box_sub_radio">
                                    <div class="box_radio_focus"></div>
                                </div>
                                <label>Export All</label>
                            </div> 
                        </div>


                        <div class="box_row">
                            <div class="box_radio">
                                <input type="radio" name="form[type_export]" value="2">
                                <div class="box_sub_radio">
                                    <div class="box_radio_focus"></div>
                                </div>
                                <label>Export Department</label>
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
                                <input type="radio" name="form[type_export]" value="3">
                                <div class="box_sub_radio">
                                    <div class="box_radio_focus"></div>
                                </div>
                                <label>Export User</label>

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
                                <input type="text" id="date_length" name="form[date_length]" readonly="readonly" class="pull-right calendar" style="float:none !important;" value="<?php echo date('Y-m-d') ?> - <?php echo date('Y-m-d', strtotime("+1 month", strtotime(date('Y-m-d')))); ?>" >
                                <i class="fa fa-calendar calendar_icon iconcal1" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="box_row">
                            <input type="checkbox" id="status_ot" name="form[status_ot]" value="1" />
                            Show OT
                            <div class="box_calendar box_calendar_ot" style="display: none;">
                                <label>Date</label>
                                <input type="text" id="date_ot" name="form[date_ot]" readonly="readonly" class="pull-right calendar" style="float:none !important;" value="<?php echo date('Y-m-d') ?> - <?php echo date('Y-m-d', strtotime("+1 month", strtotime(date('Y-m-d')))); ?>" >
                                <i class="fa fa-calendar calendar_icon iconcal2" aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="box_row text-center">
                            <button type="button"  class="btn btn-danger" onclick="confirmexport()">
                                 Export
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
{!! Html::script('assets/dist/js/export/export.js') !!}

@endsection

