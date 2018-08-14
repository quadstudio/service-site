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
            <li class="breadcrumb-item active">@lang('site::contact.contacts')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contact.icon')"></i> @lang('site::contact.contacts') {{$user->name}}</h1>

        @alert()@endalert
        <div class="border p-3 mb-4">
            <a href="{{ route('admin.users.show', $user) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_user')</span>
            </a>
        </div>

        <div class="row items-row-view">
            @each('site::admin.user.contact.row', $contacts, 'contact')
        </div>

    </div>
@endsection
