@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/management/weekend.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="nav_main">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class='title'>SETTINGS</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3 class="sub_title">Week End</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-8 col-lg-offset-2">
            <div class="row">
                <div class="col-md-5 col-md-offset-0 col-sm-offset-1 col-sm-10 box_nav"><a href="{{url('weekend/company')}}" title="Company"><img src="{{url('images/icon/account.png')}}" alt="Company"><span>Company</span></a></div>
                <div class="col-md-5 col-md-offset-2 col-sm-offset-1 col-sm-10 box_nav"><a href="{{url('weekend/depertment')}}" title="Depertment"><img src="{{url('images/icon/account.png')}}" alt="{{ trans('absence.absence_add')}}"><span>Depertment</span></a></div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/weekend.js') !!}

@endsection

