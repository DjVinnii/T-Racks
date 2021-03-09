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
                                <dd class="col-sm-8">{{ $rack->rackUnits->count() }} / {{ $rack->height }} HE</dd>
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;"></th>
                                        <th style="width: 20%;">@lang('app.front')</th>
                                        <th style="width: 50%;">@lang('app.interior')</th>
                                        <th style="width: 20%;">@lang('app.back')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = $rack->height; $i > 0; $i--)
                                        <tr>
                                            <th>{{ $i }}</th>

                                            @php
                                                $rack_unit = $rack->rackUnits->where('unit_no', $i)->first();
                                            @endphp

                                            @if($rack_unit)
                                                @if($rack_unit->front == 1)
                                                    <th>{{ $rack_unit->hardware->name }}</th>
                                                @else
                                                    <th></th>
                                                @endif

                                                @if($rack_unit->interior == 1)
                                                    <th>{{ $rack_unit->hardware->name }}</th>
                                                @else
                                                    <th></th>
                                                @endif

                                                @if($rack_unit->back == 1)
                                                    <th>{{ $rack_unit->hardware->name }}</th>
                                                @else
                                                    <th></th>
                                                @endif
                                            @else
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            @endif
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
