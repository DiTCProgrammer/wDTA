@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/persabsence/nav.css') !!}
@endsection
@section('content')

<div class="absence--nav personals_users">
    <div class="col-xs-12">
        <div class="containner">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class='title'>{{ trans('dataoverview.dataoverview')}}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h3 class="sub_title">{{ trans('dataoverview.personalsinformation') }}</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">

                    <form class="filter" method="post" action="{{url('dataoverview/users/search')}}">
                        <input id="calendar" readonly="readonly" class="pull-right calendar" style="float:none !important;" type="text" name="date_length" value="{{$date}}" />
                        <i class="fa fa-calendar calendar_icon" aria-hidden="true"></i>
                        <button type='submit'>Search&nbsp;&nbsp;&nbsp;<i class="fa fa-search" aria-hidden="true"></i></button>
                            <input type="hidden" name="dept_id" value="{{$dept_id}}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    </form>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <?php
                    if ($data) {
                        foreach ($data as $key => $val) {
                            if ($key % 3 == 0) {
                                ?>
                                <div class="row">
                                    <?php
                                }
                                ?>
                                <div class="col-md-4 col-xs-12 box_nav">
                                    <a href="{{url('dataoverview/'.$val->empcode.'/'.$val->dept_id.'/'.$date.'/user')}}">
                                        <div class="box_user">
                                            <div class="row">
                                                <div class="col-md-5 col-xs-12">
                                                    <div class="box_img" style="background:url(<?php echo ($val->picture ? $val->picture : url('images/picture_human.png')); ?>);">
            <!--                                                    <img src="<?php echo ($val->picture ? $val->picture : url('images/picture_human.png')); ?>" alt="<?php echo $val->prefix . $val->firstname . ' ' . $val->lastname; ?>">-->
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-xs-12">
                                                    <div class="name">
                                                        <?php echo $val->prefix . ' ' . $val->firstname . ' ' . $val->lastname; ?>
                                                    </div>
                                                    <table>
                                                        <tr>
                                                            <td>ทำงาน</td>
                                                            <td class="text-center">:</td>
                                                            <td class="text-right"><?php echo number_format($val->workingday); ?>&nbsp;วัน</td>
                                                        </tr>

                                                        <tr>
                                                            <td>ขาด</td>
                                                            <td class="text-center">:</td>
                                                            <td class="text-right"><?php echo number_format($val->absence); ?>&nbsp;วัน</td>
                                                        </tr>

                                                        <tr>
                                                            <td>ลา</td>
                                                            <td class="text-center">:</td>
                                                            <td class="text-right"><?php echo number_format($val->absence_comment); ?>&nbsp;วัน</td>
                                                        </tr>

                                                        <tr>
                                                            <td>สาย</td>
                                                            <td class="text-center">:</td>
                                                            <td class="text-right"><?php echo number_format($val->late); ?>&nbsp;วัน</td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="box_footer">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center">
                                                        <div class="total"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;รวมสาย&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($val->latetotal); ?>&nbsp;&nbsp;&nbsp;&nbsp;นาที</div>
                                                        <div class="total"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;รวมโอที&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($val->ottotal); ?>&nbsp;&nbsp;&nbsp;&nbsp;นาที</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                if ($key % 3 == 2 || $key == count($data) - 1) {
                                    ?>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection
@section('footer')
{!! Html::script('assets/dist/js/attendance/detatime/daterangepicker.js') !!}
{!! Html::script('assets/dist/js/persabsence/persabsence.js') !!}
@endsection
