@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::catalog.catalogs')</li>
        </ol>
        <h1 class="header-titlemb-4"><i class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::catalog.catalogs')</h1>
        <hr/>

        @alert()@endalert

        <div class="row">
            <div class="col-12 mb-2">
                <a class="btn btn-success" href="{{ route('admin.catalogs.create') }}" role="button">
                    <i class="fa fa-plus"></i>
                    <i class="fa fa-folder-open"></i>
                    <span>@lang('site::messages.add') @lang('site::catalog.catalog')</span>
                </a>
                <a href="{{ route('admin.catalogs.tree') }}" class="btn btn-secondary">
                    <i class="fa fa-bars"></i>
                    <span>@lang('site::messages.open') @lang('site::catalog.tree')</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

        @include('repo::filter')

        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th class="text-center" scope="col"></th>
                        <th scope="col">@lang('site::catalog.name')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::catalog.catalog_id')</th>
                        <th scope="col">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.catalog.row', $items, 'catalog')
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
    </div>
@endsection
