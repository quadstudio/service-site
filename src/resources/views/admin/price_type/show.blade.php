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
                <a href="{{ route('admin.price_types.index') }}">@lang('site::price_type.price_types')</a>
            </li>
            <li class="breadcrumb-item active">{{ $price_type->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $price_type->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.price_types.edit', $price_type) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::price_type.price_type')</span>
            </a>
            <a href="{{ route('admin.price_types.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::price_type.name')</dt>
                    <dd class="col-sm-8">{!! $price_type->name !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::price_type.display_name')</dt>
                    <dd class="col-sm-8">{!! $price_type->display_name !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::price_type.currency_id')</dt>
                    <dd class="col-sm-8">{{$price_type->currency->title}} ({{$price_type->currency->name}})</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::price_type.enabled')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $price_type->enabled == 1])@endbool</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
