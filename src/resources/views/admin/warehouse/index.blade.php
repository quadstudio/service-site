@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::warehouse.warehouses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::warehouse.icon')"></i> @lang('site::warehouse.warehouses')</h1>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">@lang('site::warehouse.name')</th>
                        <th scope="col" class="d-none d-sm-table-cell text-center">@lang('site::warehouse.id')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.warehouse.index.row', $warehouses, 'warehouse')
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
