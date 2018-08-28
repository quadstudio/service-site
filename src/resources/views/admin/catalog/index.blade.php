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
            <li class="breadcrumb-item active">@lang('site::catalog.catalogs') (@lang('site::catalog.grid'))</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::catalog.catalogs') (@lang('site::catalog.grid'))</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-4">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('admin.catalogs.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <i class="fa fa-folder-open"></i>
                <span>@lang('site::messages.add') @lang('site::catalog.catalog')</span>
            </a>
            <a href="{{ route('admin.catalogs.tree') }}" class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-secondary">
                <i class="fa fa-bars"></i>
                <span>@lang('site::messages.open') @lang('site::catalog.tree')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $catalogs])@endpagination
        {{$catalogs->render()}}
        <div class="row items-row-view">
            @each('site::admin.catalog.index.row', $catalogs, 'catalog')
        </div>
        {{$catalogs->render()}}
    </div>
@endsection
