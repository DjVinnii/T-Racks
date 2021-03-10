@extends('layouts.app')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@lang('app.dashboard')</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-server"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('app.hardware')</span>
                            <span class="info-box-number">{{ $hardware_count }} @lang('app.objects')</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-server"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('app.rackspace')</span>
                            <span class="info-box-number">{{ $rack_count }} Racks ({{ $rack_units_count }} HE)</span>
                        </div>
                    </div>
                </div>

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-server"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('app.ipv4')</span>
                            <span class="info-box-number">{{ $ipv4_network_count }} @lang('app.networks')</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-server"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('app.ipv6')</span>
                            <span class="info-box-number">{{ $ipv6_network_count }} @lang('app.networks')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
