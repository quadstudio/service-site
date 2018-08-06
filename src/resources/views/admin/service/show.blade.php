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
                <a href="{{ route('admin.services.index') }}">@lang('site::service.services')</a>
            </li>
            <li class="breadcrumb-item active">{{ $service->name }}</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::service.icon')"></i> {{ $service->name }}</h1>
    </div>
@endsection
