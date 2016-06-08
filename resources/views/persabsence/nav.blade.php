@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/persabsence/nav.css') !!}
@endsection
@section('content')

<div class="absence--nav">
    <div class="col-xs-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class='title'>{{ trans('absence.absence_management')}}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h3 class="sub_title">{{ trans('absence.absence_title')}}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-8 col-lg-offset-2">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-0 col-sm-offset-1 col-sm-10 box_nav">
                            <a href="{{ url('persabsence/view')}}" title="{{ trans('absence.absence_view')}}">
                                <img src="images/icon/account.png" alt="{{ trans('absence.absence_view')}}">
                                <span>{{ trans('absence.absence_view')}}</span>
                            </a>
                        </div>
                        <div class="col-md-5 col-md-offset-2 col-sm-offset-1 col-sm-10 box_nav">
                            <a href="{{ url('persabsence/create')}}" title="{{ trans('absence.absence_add')}}">
                                <img src="images/icon/account.png" alt="{{ trans('absence.absence_add')}}">
                                <span>{{ trans('absence.absence_add')}}</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-md-12 col-lg-8 col-lg-offset-2">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-0 col-sm-offset-1 col-sm-10 box_nav">
                            <a href="{{ url('persabsence/import')}}" title="{{ trans('absence.absence_import')}}">
                                <img src="images/icon/account.png" alt="{{ trans('absence.absence_import')}}">
                                <span>{{ trans('absence.absence_import')}}</span>
                            </a>
                        </div>
                       
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>


@endsection
@section('footer')
{!! Html::script('assets/dist/js/persabsence/persabsence.js') !!}

@endsection
