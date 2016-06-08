@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    {{ trans('home.titletext') }}

                    You are logged in! 
                    @if(Auth::user())
                    {{ Auth::user()->email }}
                    {{ Auth::user()->name}}
                    {{ Auth::user()->company_code }}
                    {{ Auth::user()->company_id }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
