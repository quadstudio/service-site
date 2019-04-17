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
            <li class="breadcrumb-item active">@lang('site::warehouse.warehouses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::warehouse.icon')"></i> @lang('site::warehouse.warehouses')</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-page d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @pagination(['pagination' => $warehouses])@endpagination
        {{$warehouses->render()}}
        <div class="row items-row-view">
            @each('site::admin.warehouse.index.row', $warehouses, 'warehouse')
        </div>
        {{$warehouses->render()}}

    </div>
@endsection
