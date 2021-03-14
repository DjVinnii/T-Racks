@extends('layouts.app')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@lang('app.rackspace')</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('rack.edit', $rack) }}" class="btn btn-app">
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('app.summary')</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">@lang('app.name')</dt>
                                <dd class="col-sm-8">{{ $rack->name }}</dd>

                                <dt class="col-sm-4">@lang('app.height')</dt>
                                <dd class="col-sm-8">{{ $rack->height }}</dd>

                                <dt class="col-sm-4">@lang('app.usage')</dt>
                                <dd class="col-sm-8">{{ $rack->rackUnits()->distinct('unit_no')->count() }} / {{ $rack->height }} HE</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('app.rack_diagram')</h3>
                        </div>
                        <div class="card-body">
                            <x-rack-diagram :rack="$rack" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
