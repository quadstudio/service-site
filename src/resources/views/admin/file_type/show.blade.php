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
                <a href="{{ route('admin.file_types.index') }}">@lang('site::file_type.file_types')</a>
            </li>
            <li class="breadcrumb-item active">{{ $file_type->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $file_type->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.file_types.edit', $file_type) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::file_type.file_type')</span>
            </a>
            <a href="{{ route('admin.file_types.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file_type.name')</dt>
                    <dd class="col-sm-8">{!! $file_type->name !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file_type.comment')</dt>
                    <dd class="col-sm-8">{!! $file_type->comment !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file_type.group_id')</dt>
                    <dd class="col-sm-8">
                        <a class="mb-1 d-block"
                           href="{{ route('admin.file_groups.show', $file_type->group) }}">{{ $file_type->group->name }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file_type.enabled')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $file_type->enabled == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file_type.required')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $file_type->required == 1])@endbool</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
