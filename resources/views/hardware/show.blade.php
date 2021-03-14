@extends('layouts.app')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@lang('app.hardware')</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('hardware.edit', $hardware) }}" class="btn btn-app">
                        <i class="fa fa-edit"></i>
                        @lang('app.edit')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--TODO Show rack assignment--}}

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('app.summary')</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">@lang('app.name')</dt>
                                <dd class="col-sm-8">{{ $hardware->name }}</dd>

                                <dt class="col-sm-4">@lang('app.hardware_type')</dt>
                                <dd class="col-sm-8">{{ $hardware->hardwareType->name }}</dd>

                                <dt class="col-sm-4">@lang('app.label')</dt>
                                <dd class="col-sm-8">{{ $hardware->label }}</dd>

                                <dt class="col-sm-4">@lang('app.asset_tag')</dt>
                                <dd class="col-sm-8">{{ $hardware->asset_tag }}</dd>

                                <dt class="col-sm-4">@lang('app.created_at')</dt>
                                <dd class="col-sm-8">{{ $hardware->created_at }}</dd>

                                <dt class="col-sm-4">@lang('app.updated_at')</dt>
                                <dd class="col-sm-8">{{ $hardware->updated_at }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('app.ports')</h3>
                        </div>
                        <div class="card-body">
                            @foreach($hardware->ports as $port)
                                <div class="row">
                                    <dt class="col-sm-4">@lang('app.name')</dt>
                                    <dd class="col-sm-8">{{ $port->name }}</dd>

                                    <dt class="col-sm-4">@lang('app.mac_address')</dt>
                                    <dd class="col-sm-8">{{ $port->mac_address }}</dd>
                                </div>
                                <hr />
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('app.rackspace_allocation')</h3>
                        </div>
                        <div class="card-body">
                            <x-rack-diagram :rack="$hardware->rackUnits->first()->Rack" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
