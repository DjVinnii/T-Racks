@extends('layouts.app')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@lang('app.hardware_type')</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('hardwareType.edit', $hardwareType) }}" class="btn btn-app">
                        <i class="fa fa-edit"></i>
                        @lang('app.edit')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('app.summary')</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">@lang('app.name')</dt>
                            <dd class="col-sm-8">{{ $hardwareType->name }}</dd>

                            <dt class="col-sm-4">@lang('app.created_at')</dt>
                            <dd class="col-sm-8">{{ $hardwareType->created_at }}</dd>

                            <dt class="col-sm-4">@lang('app.updated_at')</dt>
                            <dd class="col-sm-8">{{ $hardwareType->updated_at }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
