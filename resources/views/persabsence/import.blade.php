@extends('layouts.app')

@section('css')
{!! Html::style('assets/dist/css/persabsence/import.css') !!}
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="absence_import">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="title">Absence Import</h1>
            </div>
        </div>

        <div class="box-body">
            <div class="col-md-6">
                <h3>
                    Persabsence
                </h3>               
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box_upload_file">
                    <form action="" id="upload_excel" enctype="MULTIPART/FORM-DATA">
                        <div class="field_upload">
                            <input type="file" name="input_file">
                            <input type="text" class="name_file" id="name_file" readonly="readonly" value="">
                            <button class="btn_browser" type="button">Browse</button>
                            <button type="button" class="btn_remove" style="display:none;">Remove</button>
                            <button type="button" class="btn_upload" style="display:none;">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('popup')
<div class="absence_popup " style="display:none;">
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
{!! Html::script('assets/dist/js/persabsence/xls.js') !!}
{!! Html::script('assets/dist/js/persabsence/import_file.js') !!}
{!! Html::script('assets/dist/js/persabsence/import.js') !!}

@endsection
