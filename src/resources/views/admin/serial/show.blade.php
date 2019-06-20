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
                <a href="{{ route('admin.serials.index') }}">@lang('site::serial.serials')</a>
            </li>
            <li class="breadcrumb-item active">{{ $serial->id }}</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::serial.icon')"></i> {{ $serial->id }}</h1>
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin.serials.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
    </div>
@endsection
