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
            <li class="breadcrumb-item active">@lang('site::authorization_type.authorization_types')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::authorization_type.icon')"></i> @lang('site::authorization_type.authorization_types')
        </h1>
        @alert()@endalert
        <div class="border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.authorization-types.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::authorization_type.authorization_type')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $authorization_types])@endpagination
        {{$authorization_types->render()}}
        <div class="row items-row-view">
            @each('site::admin.authorization_type.index.row', $authorization_types, 'authorization_type')
        </div>
        {{$authorization_types->render()}}
    </div>
@endsection
