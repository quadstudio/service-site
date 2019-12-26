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
                <a href="{{ route('admin.users.show', $contragent->user) }}">{{$contragent->user->name}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.contragents', $contragent->user) }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.contragents.show', $contragent) }}">{{$contragent->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::address.addresses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::address.icon')"></i> @lang('site::address.addresses') {{$contragent->name}}</h1>

        @alert()@endalert
        <div class="border p-3 mb-2">
            <a href="{{ route('admin.contragents.addresses.create', $contragent) }}"
               class="disabled d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-ferroli">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.add') @lang('site::address.address')</span>
            </a>
            <a href="{{ route('admin.contragents.show', $contragent) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::contragent.help.back')</span>
            </a>
        </div>

        <div class="row items-row-view mb-4">
            @each('site::admin.contragent.address.index.row', $addresses, 'address')
        </div>

    </div>
@endsection
