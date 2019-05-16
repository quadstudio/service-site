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
                <a href="{{ route('admin.event_types.index') }}">@lang('site::event_type.event_types')</a>
            </li>
            <li class="breadcrumb-item active">{{ $event_type->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $event_type->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.event_types.edit', $event_type) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::event_type.event_type')</span>
            </a>
            <a href="{{ route('admin.event_types.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_ferroli')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $event_type->show_ferroli == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_lamborghini')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $event_type->show_lamborghini == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event_type.name')</dt>
                    <dd class="col-sm-8">{!! $event_type->name !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event_type.annotation')</dt>
                    <dd class="col-sm-8">{!! $event_type->annotation !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event_type.image_id')</dt>
                    <dd class="col-sm-8">
                        @include('site::admin.image.preview', ['image' => $event_type->image])
                    </dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
