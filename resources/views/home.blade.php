@extends('layouts.app')

@section('content')
<div class="home">
    <img src="{{url('assets/dist/img/DTA-Logo-3.png')}}" class="web-logo">

    @if(Session::has('mycompany'))
    <div class="company">
        <h2 class="compant_name text-center">{{ Session::get('mycompany')->name }}</h2>
        <div class="img">
            <img src="{{ Session::get('mycompany')->logo }}" class="img-responsive company_logo">
        </div>
    </div>


    @endif
</div>
@endsection

@section('css')
<link href="assets/dist/css/home.css" rel="stylesheet" type="text/css">
@endsection
