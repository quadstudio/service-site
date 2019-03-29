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
            <li class="breadcrumb-item active">@lang('site::authorization.authorizations')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::authorization.icon')"></i> @lang('site::authorization.authorizations')
        </h1>

        @alert()@endalert
        <div class="border p-3 mb-2">
            {{--<a href="{{ route('admin.users.authorizations.create', $user) }}"--}}
            {{--class="d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-ferroli">--}}
            {{--<i class="fa fa-pencil"></i>--}}
            {{--<span>@lang('site::messages.add') @lang('site::authorization.authorization')</span>--}}
            {{--</a>--}}
            <a href="{{ route('admin.users.show', $user) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_user')</span>
            </a>
        </div>
        <style>
            .vertical-text {
                width: 1px;
                word-wrap: break-word;
                white-space: pre-wrap;
            }
        </style>

        <table class="table bg-white table-sm table-bordered">
            <thead class="thead-light">
            <tr>
                <th scope="col"></th>
                @foreach($authorization_roles as $authorization_role)
                    <th class="text-center" scope="col">{{$authorization_role->name}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($authorization_types as $authorization_type)
                <tr>
                    <td class="text-right">{{$authorization_type->name}} {{$authorization_type->brand->name}}</td>
                    @foreach($authorization_roles as $authorization_role)
                        <td class="text-center">
                            @if($authorization_accepts->contains(function ($accept) use ($authorization_role, $authorization_type) {
                                return $accept->type_id == $authorization_type->id && $accept->role_id == $authorization_role->role_id;
                            }))
                                <span class="badge text-normal badge-success"><i class="fa fa-check"></i></span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col mb-4">
                @foreach($authorizations as $authorization)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div>{{$authorization->created_at->format('d.m.Y H:i')}}</div>
                                    <span class="badge text-normal badge-{{$authorization->status->color}}">{{$authorization->status->name}}</span>
                                </div>
                                <div class="col-sm-4">
                                    <a class="d-block"
                                       href="{{route('admin.authorizations.show', $authorization)}}">{{$authorization->role->authorization_role->name}}</a>
                                    @foreach($authorization->types as $authorization_type)
                                        <div>{{$authorization_type->name}} {{$authorization_type->brand->name}}</div>
                                    @endforeach
                                </div>
                                <div class="col-sm-4">
                                    <a class="d-block"
                                       href="{{route('admin.users.show', $authorization->user)}}">{{$authorization->user->name}}</a>
                                    <div>{{$authorization->user->region->name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
