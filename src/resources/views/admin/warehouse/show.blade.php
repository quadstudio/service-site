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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.warehouses.index') }}">@lang('site::warehouse.warehouses')</a>
            </li>
            <li class="breadcrumb-item active">{{ $warehouse->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $warehouse->name }}</h1>
        <div class="justify-content-start border p-3 mb-2">

            <a href="{{ route('admin.warehouses.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::warehouse.name')</dt>
                    <dd class="col-sm-8">{{ $warehouse->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::warehouse.active')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $warehouse->active])@endbool</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
