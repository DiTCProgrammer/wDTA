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
                        Schedule Time Menu {{ trans('scheduletime.titletext') }}
                    </h3>    
                    <h3>
                        Schedule Time View
                    </h3>

                </div>

                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <h3>No Group</h3>
                    </div>

                    <div class="col-md-8 col-md-offset-2">
                        <table class="table table-bordered table-striped tab-scheduletime">
                            <thead>
                                <tr>
                                    <th></th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>
                                            @foreach($nogroup['name'] as $row)                                         
                                            <span class="label label-primary">{{$row}}</span>
                                            @endforeach
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>                    
                    </div>
                </div>
                @foreach($group as $i=> $row) 
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <h3>ช่วงเวลาการทำงาน GROUP {{$i}}</h3>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <table class="table table-bordered table-striped tab-scheduletime">
                            <thead>
                                <tr>
                                    <th>Schedule Type</th>
                                    <th>In 1</th>
                                    <th>Out 1</th>
                                    <th>In 2</th>
                                    <th>Out 2</th>
                                    <th>In 3</th>
                                    <th>Out 3</th> 
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($row['group'] as $ii=> $rows) 

                                <tr>
                                    <td>
                                        {{$row['name'][$ii]}}
                                    </td>
                                    <td>
                                        {{isset($row['timeinout'][$ii]->t1) ? $row['timeinout'][$ii]->t1:''}}
                                    </td>
                                    <td>
                                        {{isset($row['timeinout'][$ii]->t2) ? $row['timeinout'][$ii]->t2:''}}
                                    </td>
                                    <td>
                                        {{isset($row['timeinout'][$ii]->t3)?$row['timeinout'][$ii]->t3:''}}
                                    </td>
                                    <td>
                                        {{isset($row['timeinout'][$ii]->t4)?$row['timeinout'][$ii]->t4:''}}
                                    </td>
                                    <td>
                                        {{isset($row['timeinout'][$ii]->t5)?$row['timeinout'][$ii]->t5:''}}
                                    </td>
                                    <td>
                                        {{isset($row['timeinout'][$ii]->t6)?$row['timeinout'][$ii]->t6:''}}
                                    </td>
                                    <td>
                                        <p>
                                            <a href="{{ url('scheduletime/'.$row['id'][$ii].'/edit')}}" class="btn btn-edit">
                                                <i class="fa fa-edit"></i>
                                                View/Edit                                        
                                            </a>
                                        </p>
                                        <p>
                                            <a  onclick="delScheduletimeCheck('<?= $row['id'][$ii] ?>')" class="btn btn-del">
                                                <i class="fa fa-trash"></i>
                                                Delete                                        
                                            </a>
                                        </p>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>                    
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-4">
                            <h3>กลุ่มที่ใช้ช่วงเวลาการทำงาน</h3>
                        </div>
                        <div class="col-md-6">

                            @foreach($row['depgroup'] as $rows) 
                            @if(isset($rows['id']))
                            @foreach($rows['id'] as $x=> $depgroup) 

                            <span   class="label label-scheduletime">

                                {{$rows['name'][$x]}}   
                                <a  onclick="delGroupScheduletime('<?= $depgroup ?>')" class="btn">
                                    <i  class="fa fa-trash"></i>
                                </a>

                            </span>

                            @endforeach
                            @endif
                            @endforeach


                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModalScheduletime" data-datagroup="{{$i}}"     >
                                View  <i class="fa fa-plus"></i>
                            </button>

                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="modal fade" id="myModalScheduletime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Add Department</h4>
                </div>
                {!! Form::open(array('url' => '/scheduletime/updatedep','class'=>'','id'=>'form_scheduletime','files' => true)) !!}
                <div class="modal-body">                   

                    {!!Form::select('groupmodel',$groupmodel,null,['class' => 'form-control','id'=>'groupmodel']); !!}
                    <input type="hidden" name="datagroup" class="modal-datagroup">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!} 
            </div>
        </div>
    </div>

    <!-- /.box -->
</div>




@endsection
@section('footer')
{!! Html::script('assets/dist/js/management/scheduletime.js') !!}

@endsection

