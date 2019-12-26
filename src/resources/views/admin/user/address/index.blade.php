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
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.show', $user) }}">{{$user->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::address.addresses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::address.icon')"></i> @lang('site::address.addresses') {{$user->name}}</h1>

        @alert()@endalert
        <div class="border p-3 mb-2">
            <a href="{{ route('admin.users.addresses.create', $user) }}"
               class="d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-ferroli">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.add') @lang('site::address.address')</span>
            </a>
            <a href="{{ route('admin.users.show', $user) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_user')</span>
            </a>
        </div>

        <div class="row items-row-view mb-4">
            @each('site::admin.user.address.index.row', $addresses, 'address')
        </div>

    </div>
@endsection
