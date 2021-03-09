<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
{{--                <li class="nav-item d-none d-sm-inline-block">--}}
{{--                    <a href="{{ route('dashboard') }}" class="nav-link">@lang('app.dashboard')</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item d-none d-sm-inline-block">--}}
{{--                    <a href="#" class="nav-link">@lang('app.objects')</a>--}}
{{--                </li>--}}
            </ul>
            <ul class="navbar-nav ml-auto">
{{--                TODO Some user stuff--}}
                @guest
                @else
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="https://via.placeholder.com/160" class="user-image" alt="@lang('app.user_image')" />
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-footer">
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    @lang('app.logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                @endguest
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">--}}
{{--                        <i class="fas fa-expand-arrows-alt"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">--}}
{{--                        <i class="fas fa-th-large"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">T-Racks</span>
            </a>
            @auth
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-server"></i>
                                <p>@lang('app.dashboard')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hardware.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-server"></i>
                                <p>@lang('app.hardware')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rack.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-server"></i>
                                <p>@lang('app.rackspace')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-server"></i>
                                <p>@lang('app.ipv4')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-server"></i>
                                <p>@lang('app.ipv6')</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            @endauth
        </aside>

        <div class="content-wrapper">
            @yield('content_header')

            @if(session()->has('success'))
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i>@lang('app.success')</h5>
                                {{ session()->get('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </div>
    @yield('script')
</body>
</html>
