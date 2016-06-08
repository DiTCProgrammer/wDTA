@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/management/scheduletime.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="management--scheduletime">
    <div class="col-md-12">
        <div class="containner">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="title">SETTINGS</h1>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body from-view">
                <div class="col-md-6">
                    <h3>
                        Schedule Time Menu
                    </h3>
                  
                </div>                
                <div class="col-md-8 col-md-offset-2">
                    <div class="col-md-4 col-md-offset-1 border-scheduletime">
                        <a href="{{url('scheduletime/view')}}"><img src="{{url('images/icon/account.png')}}" >
                            <h3>Schedule Time View</h3></a>
                    </div>
                    <div class="col-md-4 col-md-offset-1 border-scheduletime">
                        <a href="{{url('scheduletime/create')}}"><img src="{{url('images/icon/account.png')}}" ><h3>Add Schedule Time</h3></a>
                    </div>
                    
                </div>

            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
</div>

@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/scheduletime.js') !!}

@endsection

