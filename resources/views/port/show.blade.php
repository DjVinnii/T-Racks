@extends('layouts.app')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@lang('app.ports')</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('port.edit', $port) }}" class="btn btn-app">
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
                            <dd class="col-sm-8">{{ $port->name }}</dd>

                            <dt class="col-sm-4">@lang('app.hardware')</dt>
                            <dd class="col-sm-8">{{ $port->hardware->name }}</dd>

                            <dt class="col-sm-4">@lang('app.mac_address')</dt>
                            <dd class="col-sm-8">{{ $port->mac_address }}</dd>

                            <dt class="col-sm-4">@lang('app.remote_port')</dt>
                            <dd class="col-sm-8">@if($port->remotePort != null){{ $port->remotePort->hardware->name }} - {{ $port->remotePort->name }}@endif</dd>

                            <dt class="col-sm-4">@lang('app.created_at')</dt>
                            <dd class="col-sm-8">{{ $port->created_at }}</dd>

                            <dt class="col-sm-4">@lang('app.updated_at')</dt>
                            <dd class="col-sm-8">{{ $port->updated_at }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
