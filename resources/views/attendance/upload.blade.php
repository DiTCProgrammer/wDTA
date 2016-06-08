@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="attendance--upload_form">
    <div class="containner">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class='title'>attendance management</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="sub_title">upload file</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box_upload_file">
                    <form action="">

                        <input id="calendar" readonly="readonly" class="pull-right calendar" style="float:none !important;" type="text" name="date_length" value="<?php echo date('Y-m-d') ?> - <?php echo date('Y-m-d', strtotime("+1 month", strtotime(date('Y-m-d')))); ?>" />
                        <i class="fa fa-calendar calendar_icon" aria-hidden="true"></i>
                        <div class="field_upload">
                            <input type="file" id="input_file">
                            <input type="text" class="name_file" id="name_file" readonly="readonly" value="">
                            <button type="button" class="btn_browser">Browse</button>
                            <button type="button" class="btn_remove" style="display:none;">Remove</button>
                            <button type="button" class="btn_upload" style="display:none;">Upload</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="system_message">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#error_time" aria-controls="error_time" role="tab" data-toggle="tab">Error Time&nbsp;&nbsp;<span class="badge">0</span></a></li>
                        <li role="presentation"><a href="#ready" aria-controls="ready" role="tab" data-toggle="tab">Ready&nbsp;&nbsp;<span class="badge">0</span></a></li>
                        <li role="presentation"><a href="#no_employee" aria-controls="no_employee" role="tab" data-toggle="tab">No Employee&nbsp;&nbsp;<span class="badge">0</span></a></li>
                        <li role="presentation"><a href="#error_upload" aria-controls="error_upload" role="tab" data-toggle="tab">Error Upload&nbsp;&nbsp;<span class="badge">0</span></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="error_time">
                            <div class="detail">
                                <table>
                                    <thead>
                                        <tr>
                                            <th width="25%">Employee Code</th>
                                            <th width="25%">Date</th>
                                            <th width="50%">Error Times</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>


                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="ready">
                            <div class="detail">
                                <table>
                                    <thead>
                                        <tr>
                                            <th width="50%">Employee Code</th>
                                            <th width="50%">Message</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="no_employee">
                            <div class="detail">

                                <table>
                                    <thead>
                                        <tr>
                                            <th width="50%">Employee Code</th>
                                            <th width="50%">Message</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="error_upload">
                            <div class="detail">

                                <table>
                                    <thead>
                                        <tr>
                                            <th width="50%">Employee Code</th>
                                            <th width="50%">Message</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="process_view text-center">
                    <button type="button">Calculate</button>
                </div>
            </div>
        </div>

    </div>

</div>



@endsection

@section('popup')
<div class="attendance_popup " style="display:none;">
    <div class="popup_detail">
        <h2 class="title">Upload Process</h2>
        <div class="popup_table">
            <table>

            </table>
        </div>

    </div>  
</div>
@endsection

@section('footer')

{!! Html::script('assets/dist/js/attendance/detatime/daterangepicker.js') !!}

<script src="assets/dist/js/attendance/attendance_upload.js" type="text/javascript"></script>
<script src="assets/dist/js/attendance/upload.js" type="text/javascript"></script>


@endsection
@section('css')
<link href="assets/dist/css/attendance/attendance_upload.css" rel="stylesheet" type="text/css">
<!--<link href="assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css">-->
@endsection

