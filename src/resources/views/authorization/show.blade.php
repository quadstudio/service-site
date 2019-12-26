@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('authorizations.index') }}">@lang('site::authorization.authorizations')</a>
            </li>
            <li class="breadcrumb-item active">№ {{$authorization->id}}</li>

        </ol>
        <h1 class="header-title mb-4">@lang('site::authorization.header.authorization') № {{$authorization->id}}</h1>

        @alert()@endalert
        @include('site::message.create', ['messagable' => $authorization])

        <div class="card mb-4">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::authorization.id')</dt>
                    <dd class="col-sm-8">{{ $authorization->id }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::authorization.status_id')</dt>
                    <dd class="col-sm-8"><span
                                class="badge text-normal badge-{{ $authorization->status->color }}">{{ $authorization->status->name }}</span>
                    </dd>

                    

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::authorization.role_id')</dt>
                    <dd class="col-sm-8">{{ $authorization->role->authorization_role->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">{{ $authorization->role->authorization_role->title }}</dt>
                    <dd class="col-sm-8">
                        <ul class="list-group">
                            @foreach($authorization->types as $authorization_type)
                                <li class="list-group-item p-1">{{ $authorization_type->name }} {{ $authorization_type->brand->name }}</li>
                            @endforeach
                        </ul>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
