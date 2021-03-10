@extends('layouts.app')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@lang('app.ipv4_network')</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {!! form_start($form) !!}
                    {!! form_until($form, 'name') !!}
                        <div class="row">
                            <div class="col-6">
                                {!! form_until($form, 'network') !!}
                            </div>
                            <div class="col-2 text-center align-self-center">
                                <h4>/</h4>
                            </div>
                            <div class="col-4">
                                {!! form_until($form, 'mask') !!}
                            </div>
                        </div>
                    {!! form_rest($form) !!}
                    {!! form_end($form) !!}
                </div>
            </div>
        </div>
    </section>
@endsection
