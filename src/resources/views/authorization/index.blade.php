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
            <li class="breadcrumb-item active">@lang('site::authorization.authorizations')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::authorization.authorizations')</h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a href="{{ route('home') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        <div class="card my-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::authorization.request.title')</h5>
                <p class="card-text">@lang('site::authorization.request.text')</p>
                @foreach($authorization_roles as $authorization_role)
                    <a href="{{route('authorizations.create', $authorization_role->role)}}"
                       class="btn d-block d-sm-inline-block mb-1 @if($authorization_role->canCreate()) btn-ferroli @else btn-light @endif">{{$authorization_role->name}}</a>
                @endforeach
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::authorization.authorizations')</h5>
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
                                    @elseif($authorizations->contains(function($authorization) use ($authorization_role, $authorization_type){
                                        return $authorization->types->contains(function($a_type) use ($authorization_type){
                                            return $a_type->id == $authorization_type->id;
                                        })  && $authorization->role_id == $authorization_role->role_id;
                                    }))
                                        <span class="badge text-normal badge-info"><i class="fa fa-question"></i></span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-deck mb-4">
            @foreach($authorizations as $authorization)
                <div class="card mb-2">
                    <div class="card-body">
                        <h4 class="card-title">{{$authorization->role->authorization_role->name}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">{{$authorization->created_at->format('d.m.Y H:i')}}</h6>
                        <p class="card-text">
                            <b>{{$authorization->role->authorization_role->title}}</b>
                            @foreach($authorization->types as $authorization_type)
                                <span class="d-block">{{$authorization_type->name}} {{$authorization_type->brand->name}}</span>
                            @endforeach
                        </p>
                    </div>
                    <div class="card-footer">
                        <span class="badge text-normal badge-{{$authorization->status->color}}">{{$authorization->status->name}}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection