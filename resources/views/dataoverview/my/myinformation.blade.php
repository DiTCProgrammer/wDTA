@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/persabsence/nav.css') !!}
@endsection
@section('content')

<?php
$total_data = null;
?>
<div class="absence--nav personals_user">
    <div class="col-xs-12">
        <div class="containner">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class='title'>{{ trans('dataoverview.dataoverview')}}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <h3 class="sub_title">{{ trans('dataoverview.myinformation') }}</h3>
                </div>
                <div class="col-md-5 form">
                    <form class="filter" method="post" action="{{url('dataoverview/myinformation2')}}">
                        <input id="calendar" readonly="readonly" class="pull-right calendar" style="float:none !important;" type="text" name="date_length" value="{{$date}}" />
                        <i class="fa fa-calendar calendar_icon" aria-hidden="true"></i>
                        <button type='submit'>Search&nbsp;&nbsp;&nbsp;<i class="fa fa-search" aria-hidden="true"></i></button>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    </form>
                </div>
            </div>

            <?php if ($data && isset($data)) { ?>
                <div class="profile">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="box_img" style="background:url({{url('images/picture_human.png')}});">
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-1">
                            <h3 class="name">{{$data[0]->prefix.'&nbsp;'.$data[0]->firstname.'&nbsp;'.$data[0]->lastname}}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="profile">
                                        <tr>
                                            <td>Company</td>
                                            <td class="text-center">:</td>
                                            <td><?php echo $user->company_code; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Employee</td>
                                            <td class="text-center">:</td>
                                            <td>{{$data[0]->empcode}}</td>
                                        </tr>
                                        <tr>
                                            <td>Time Start</td>
                                            <td class="text-center">:</td>
                                            <td>{{$data[0]->date_working}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="profile">
                                        <tr>
                                            <td>Dept</td>
                                            <td class="text-center">:</td>
                                            <td>{{$data[0]->dept_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Position</td>
                                            <td class="text-center">:</td>
                                            <td>{{$data[0]->position}}</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td class="text-center">:</td>
                                            <td>
                                                <?php
                                                if ($data[0]->paytype == 1) {
                                                    echo 'Monthly';
                                                } else {
                                                    echo 'Daily';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="group"><span>CONDITION</span><span>GROUP 1</span></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <table class="data-list">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th class="hidden-xs">Day</th>
                                        <th class="hidden-xs">Time-in1</th>
                                        <th class="hidden-xs">Time-out1</th>
                                        <th class="hidden-xs">Time-in2</th>
                                        <th class="hidden-xs">Time-out2</th>
                                        <th class="hidden-xs">Time-in3</th>
                                        <th class="hidden-xs">Time-out3</th>
                                        <th class="hidden-xs">
                                            OT Hour
                                            <table>
                                                <tr>
                                                    <td>OT-1</td>
                                                    <td>OT-1.5</td>
                                                    <td>OT-2</td>
                                                    <td>OT-3</td>
                                                </tr>
                                            </table>
                                        </th>
                                        <th >Totals late</th>
                                        <th>Totals Hour</th>
                                        <th class="hidden-xs">Condition</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data as $key => $val):
                                        $total_data['work_hour'][$key] = ($val->total ? number_format((float) $val->total, 2) : 0);
                                        $total_data['late'][$key] = ($val->late ? number_format((float) $val->late, 2) : 0);
                                        $total_data['time_error'][$key] = ($val->txt_error ? 1 : 0);
                                        $total_data['ot-1'][$key] = ($val->OT_1 ? $val->OT_1 : 0);
                                        $total_data['ot-2'][$key] = ($val->OT_2 ? $val->OT_2 : 0);
                                        $total_data['ot-3'][$key] = ($val->OT_3 ? $val->OT_3 : 0);
                                        $total_data['ot-4'][$key] = ($val->OT_4 ? $val->OT_4 : 0);
                                        ?>
                                        <tr class="
                                        <?php
                                        if ($val->late) {
                                            echo 'late';
                                        } else if ($val->txt_error) {
                                            echo 'error';
                                        } else if (!$val->total && ($val->holidayoff_id || $val->holidaybus_id || $val->weekendcompany || $val->weekenddept)) {
                                            echo 'holiday';
                                        } else if (!$val->total && $val->status_error == 0 && $val->abs_id == 0) {
                                            echo 'absence';
                                        } else if (!$val->total && $val->status_error == 0 && $val->abs_id > 0) {
                                            echo 'leave';
                                        }
                                        ?>
                                            ">
                                            <td>{{date('d/m/Y',strtotime($val->ddate))}}</td>
                                            <td class="hidden-xs">{{($val->name_date?$val->name_date:-'')}}</td>

                                            <?php
                                            if ($val->txt_error) {
                                                ?>
                                                <td colspan="6" class="hidden-xs">
                                                    <?php
                                                    $txt_error = explode(',', $val->txt_error);
                                                    $txt_error2 = null;
                                                    foreach ($txt_error as $terror) {
                                                        $txt_error2[] = DATE('H:i:s', strtotime($terror));
                                                    }
                                                    echo implode(',', $txt_error2);
                                                    ?>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td class="hidden-xs">{{($val->timein1 && $val->timein1 != '00:00:30'?date('H:i',strtotime($val->timein1)):'-')}}</td>
                                                <td class="hidden-xs">{{($val->timeout1 && $val->timeout1 != '00:00:30'?date('H:i',strtotime($val->timeout1)):'-')}}</td>
                                                <td class="hidden-xs">{{($val->timein2 && $val->timein2 != '00:00:30'?date('H:i',strtotime($val->timein2)):'-')}}</td>
                                                <td class="hidden-xs">{{($val->timeout2 && $val->timeout2 != '00:00:30'?date('H:i',strtotime($val->timeout2)):'-')}}</td>
                                                <td class="hidden-xs">{{($val->timein3 && $val->timein3 != '00:00:30'?date('H:i',strtotime($val->timein3)):'-')}}</td>
                                                <td class="hidden-xs">{{($val->timeout3 && $val->timeout3 != '00:00:30' ?date('H:i',strtotime($val->timeout3)):'-')}}</td>
                                                <?php
                                            }
                                            ?>

                                            <td class="hidden-xs">
                                                <table>
                                                    <tr>
                                                        <td>{{($val->OT_1?checkzero(floor($val->OT_1 / 60)).'.'.checkzero((int)$val->OT_1%60):'-')}}</td>
                                                        <td>{{($val->OT_2?checkzero(floor($val->OT_2 / 60)).'.'.checkzero((int)$val->OT_2%60):'-')}}</td>
                                                        <td>{{($val->OT_3?checkzero(floor($val->OT_3 / 60)).'.'.checkzero((int)$val->OT_3%60):'-')}}</td>
                                                        <td>{{($val->OT_4?checkzero(floor($val->OT_4 / 60)).'.'.checkzero((int)$val->OT_4%60):'-')}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>{{($val->late?number_format((float)$val->late,2):'-')}}</td>
                                            <td>{{($val->total?number_format((float)$val->total,2):'-')}}</td>
                                            <td class="hidden-xs">{{($val->condition?$val->condition:'-')}}</td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="12" class="hidden-xs"></td>
                                        <td colspan="4" class="visible-xs"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="total_data">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h3 class="title text-center">GRAND TOTAL DATA</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <table>
                                <tr>
                                    <td>Working Day</td>
                                    <td>
                                        <?php
                                        echo count(array_filter($total_data['work_hour']));
                                        ?>
                                    </td>
                                    <td>Days</td>
                                </tr>
                                <tr>
                                    <td>Total working Hour</td>
                                    <td>{{number_format(array_sum((array_filter($total_data['work_hour']))),2)}}</td>
                                    <td>Times</td>
                                </tr>
                                <tr>
                                    <td>Late Time</td>
                                    <td>
                                        <?php
                                        echo count(array_filter($total_data['late']));
                                        ?>
                                    </td>
                                    <td>Times</td>
                                </tr>
                                <tr>
                                    <td>Total late time</td>
                                    <td>{{number_format(array_sum((array_filter($total_data['late']))),2)}}</td>
                                    <td>Minutes</td>
                                </tr>
                                <tr>
                                    <td>Run time Error</td>
                                    <td>{{array_sum((array_filter($total_data['time_error'])))}}</td>
                                    <td>Times</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table>
                                <tr>
                                    <td>OT-1</td>
                                    <td>

                                        {{checkzero(array_sum((array_filter($total_data['ot-1']))) / 60).'.'.checkzero(array_sum((array_filter($total_data['ot-1']))) % 60)}}
                                    </td>
                                    <td>Hour</td>
                                </tr>
                                <tr>
                                    <td>OT-1.5</td>
                                    <td>{{checkzero(array_sum((array_filter($total_data['ot-2'])))/60).'.'.checkzero(array_sum((array_filter($total_data['ot-2'])))%60)}}</td>
                                    <td>Hour</td>
                                </tr>
                                <tr>
                                    <td>OT-2</td>
                                    <td>{{checkzero(array_sum((array_filter($total_data['ot-3'])))/60).'.'.checkzero(array_sum((array_filter($total_data['ot-3'])))%60)}}</td>
                                    <td>Hour</td>
                                </tr>
                                <tr>
                                    <td>OT-3</td>
                                    <td>{{checkzero(array_sum((array_filter($total_data['ot-4'])))/60).'.'.checkzero(array_sum((array_filter($total_data['ot-4'])))%60)}}</td>
                                    <td>Hour</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            <?php } else {
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="no_data text-center">
                            No Employee Data Between<BR/>{{$date}}
                        </h3>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</div>

<?php

function checkzero($pr) {
    if (strlen($pr) == 1) {
        $pr = '0' . $pr;
    }
    return $pr;
}
?>
@endsection
@section('footer')
{!! Html::script('assets/dist/js/attendance/detatime/daterangepicker.js') !!}
{!! Html::script('assets/dist/js/persabsence/persabsence.js') !!}
@endsection
