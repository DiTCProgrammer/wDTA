@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/persabsence/nav.css') !!}
@endsection
@section('content')


<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="absence--nav">
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

                <div class="col-md-12 text-center">
                    {!! Form::open(array('url' => '/dataoverview','class'=>'','id'=>'','files' => true)) !!}
                    <div class="search">
                        <label>Search</label>
                        <input type="text" id="search" name="search" value="<?php echo ($search ? $search : ''); ?>">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    {!! Form::close() !!}

                </div>

            </div>

            <div class="row">
                <div class="col-md-12 col-lg-8 col-lg-offset-2 ">

                    <?php
                    if ($data && count($data) > 0) {
                        $i = 0;
                        foreach ($data as $key => $row) {

                            if ($i == 0 || $i % 4 == 0) {
                                ?>
                                <div class="row">
                                    <?php
                                    if ($i == 0) {
                                        ?>
                                        <div class="col-md-3 box_nav">
                                            <a href="{{ url('dataoverview/all/users')}}" title="{{ trans('dataoverview.all') }}">
                                                <div class="box_img">
                                                    <img src="images/icon/human.png" alt="{{ trans('dataoverview.all') }}">
                                                </div>
                                                <span>{{ trans('dataoverview.all') }}</span>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                <div class="col-md-3 box_nav">
                                    <a href="{{ url('dataoverview/'.$row->id.'/users')}}" title="{{$row->name}}">
                                        <div class="box_img">
                                            <img src="images/icon/{{($row->icon?'human.png':'')}}" alt="{{$row->name}}">
                                        </div>
                                        <span>{{$row->name}}</span>
                                    </a>
                                </div>
                                <?php
                                if ($i == count($data) || $i % 4 == 3) {
                                    ?>
                                </div>
                                <?php
                            }

                            if ($key == 0) {
                                $i+=2;
                            } else {
                                $i++;
                            }
                        }
                    } else {
                        ?>
<!--                        <div class="col-md-3 box_nav">
                            <a href="#" title="{{ trans('dataoverview.all') }}">
                                <img src="images/icon/human.png" alt="{{ trans('dataoverview.all') }}">
                                <span>{{ trans('dataoverview.all') }}</span>
                            </a>
                        </div>-->
                        <?php
                    }
                    ?>


                </div>
            </div>



        </div>
    </div>
</div>



@endsection
@section('footer')
{!! Html::script('assets/dist/js/dataoverview/detatime/daterangepicker.js') !!}
{!! Html::script('assets/dist/js/dataoverview/script.js') !!}

@endsection
