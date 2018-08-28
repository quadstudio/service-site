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
                <a href="{{ route('admin.difficulties.index') }}">@lang('site::difficulty.difficulties')</a>
            </li>
            <li class="breadcrumb-item active">{{ $difficulty->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $difficulty->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.difficulties.edit', $difficulty) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::difficulty.difficulty')</span>
            </a>
            <a href="{{ route('admin.difficulties.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::difficulty.cost')</dt>
                    <dd class="col-sm-8">{{ Site::format($difficulty->cost) }}</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
