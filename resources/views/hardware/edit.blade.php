@extends('layouts.app')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">@lang('app.hardware')</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                {!! form_start($form) !!}
                {!! form_until($form, 'asset_tag') !!}
            </div>
            <div class="col-md-4">
                {!! form_until($form, 'back') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! form_rest($form) !!}
                {!! form_end($form) !!}
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('select').select2();
        });
    </script>
@endsection
