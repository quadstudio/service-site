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
            <li class="breadcrumb-item active">@lang('site::authorization_role.authorization_roles')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::authorization_role.icon')"></i> @lang('site::authorization_role.authorization_roles')
        </h1>
        @alert()@endalert
        <div class="border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">@lang('site::authorization_role.role_id')</th>
                        <th scope="col"></th>
                        <th scope="col">@lang('site::authorization_role.name')</th>
                        <th scope="col">@lang('site::authorization_role.title')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$role->title}}</td>
                            @if(($authorization_role = $authorization_roles->where('role_id', $role->id)->first()))
                                <td class="text-left">

                                    <button type="submit"
                                            form="authorization_role-delete-form-{{$authorization_role->id}}"
                                            class="btn btn-danger btn-block btn-sm d-block"
                                            title="@lang('site::messages.delete')">
                                        <i class="fa fa-close"></i> <span
                                                class="d-none d-sm-inline-block">@lang('site::messages.delete')</span>
                                    </button>

                                    <form id="authorization_role-delete-form-{{$authorization_role->id}}"
                                          action="{{route('admin.authorization-roles.destroy', $authorization_role)}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                                <td><a href="{{route('admin.authorization-roles.edit', $authorization_role)}}">{{$authorization_role->name}}</a></td>
                                <td>
                                    <div>{{$authorization_role->title}}</div>
                                    <div class="text-muted">{{$authorization_role->address_type->name}}</div>
                                </td>

                            @else
                                <td class="text-left">
                                    <a class="btn btn-sm btn-block btn-success"
                                       href="{{route('admin.authorization-roles.create', $role)}}">
                                        <i class="fa fa-plus"></i> @lang('site::messages.add')
                                    </a>
                                </td>
                                <td colspan="2"></td>

                            @endif

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
