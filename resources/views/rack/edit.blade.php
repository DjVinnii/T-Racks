@extends('layouts.app')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">@lang('app.rackspace')</h1>
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
                {!! form_rest($form) !!}
                {!! form_end($form) !!}
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
{{--    TODO Select2 + Styling--}}
{{--<script type="text/javascript">--}}
{{--    $(function () {--}}
{{--        $('#hardware_type').select2();--}}
{{--    });--}}
{{--</script>--}}
@endsection
