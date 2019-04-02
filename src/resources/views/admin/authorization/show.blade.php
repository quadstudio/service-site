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
                <a href="{{ route('admin.authorizations.index') }}">@lang('site::authorization.authorizations')</a>
            </li>
            <li class="breadcrumb-item active">№ {{$authorization->id}}</li>

        </ol>
        <h1 class="header-title mb-4">@lang('site::authorization.header.authorization') № {{$authorization->id}}</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            @if($statuses->isNotEmpty())
                @foreach($statuses as $status)
                    <button type="submit"
                            form="authorization-edit-form"
                            name="authorization[status_id]"
                            value="{{$status->id}}"
                            class="btn btn-{{$status->color}} d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0">
                        <i class="fa fa-{{$status->icon}}"></i>
                        <span>{{$status->button}}</span>
                    </button>
                @endforeach
            @endif
            <a href="{{ route('admin.authorizations.index') }}"
               class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>


        <form id="authorization-edit-form"
              action="{{route('admin.authorizations.update', $authorization)}}"
              method="POST">
            @csrf
            @method('PUT')
        </form>

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

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::authorization.user_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('admin.users.show', $authorization->user)}}">{{ $authorization->user->name }}</a>
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
