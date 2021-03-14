@extends('layouts.app')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@lang('app.hardware')</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('hardware.create') }}" class="btn btn-app">
                        <i class="fa fa-plus"></i>
                        @lang('app.create')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--TODO show rack--}}

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>@lang('app.name')</th>
                                    <th>@lang('app.hardware_type')</th>
                                    <th>@lang('app.label')</th>
                                    <th>@lang('app.asset_tag')</th>
                                    <th>@lang('app.rack')</th>
                                    <th>@lang('app.actions')</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        $('#datatable').DataTable({
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: '{!! route('hardware.datatable') !!}',
            columns : [
                { data: 'name' , name: 'name' },
                { data: 'hardware_type' , name: 'hardware_type' },
                { data: 'label' , name: 'label' },
                { data: 'asset_tag' , name: 'asset_tag' },
                { data: 'rack' , name: 'rack' },
                { data: function(e) {
                        let returnval = '';
                        let view = '{{ route('hardware.show', -1) }}'.replace('-1', e.id);
                        let edit = '{{ route('hardware.edit', -1) }}'.replace('-1', e.id);
                        let view_link = '<a href="'+view+'" class="btn btn-app" data-tooltip="@lang('app.show')"><i class="fas fa-eye"></i>@lang('app.show')</a>';
                        let edit_link = '<a href="'+edit+'" class="btn btn-app" data-tooltip="@lang('app.edit')"><i class="fas fa-pencil-alt"></i>@lang('app.edit')</a>';
                        returnval += view_link;
                        returnval += edit_link;
                        return returnval;
                    } , name: 'actions', sortable: false, searchable: false },
            ],
        });
    });
</script>
@endsection
