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
                <a href="{{ route('admin.authorization-roles.index') }}">@lang('site::authorization_role.authorization_roles')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit') {{$authorization_role->name}}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$authorization_role->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="authorization-role-edit-form"
                              action="{{ route('admin.authorization-roles.update', $authorization_role) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-group required">
                                <label class="control-label"
                                       for="role_id">@lang('site::authorization_role.role_id')</label>
                                <select class="form-control{{ $errors->has('authorization_role.role_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="authorization_role[role_id]"
                                        id="role_id">
                                    <option value="{{ $authorization_role->role_id }}">{{ $authorization_role->role->title }}</option>
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('authorization_role.role_id') }}</span>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="name">@lang('site::authorization_role.name')</label>
                                    <input type="text" name="authorization_role[name]"
                                           id="name"
                                           required
                                           class="form-control{{ $errors->has('authorization_role.name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::authorization_role.placeholder.name')"
                                           value="{{ old('authorization_role.name', $authorization_role->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('authorization_role.name') }}</span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="title">@lang('site::authorization_role.title')</label>
                                    <input type="text" name="authorization_role[title]"
                                           id="title"
                                           required
                                           class="form-control{{ $errors->has('authorization_role.title') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::authorization_role.placeholder.title')"
                                           value="{{ old('authorization_role.title', $authorization_role->title) }}">
                                    <span class="invalid-feedback">{{ $errors->first('authorization_role.title') }}</span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3 required">

                                    <label class="control-label"
                                           for="address_type_id">@lang('site::authorization_role.address_type_id')</label>
                                    <select class="form-control{{  $errors->has('authorization_role.address_type_id') ? ' is-invalid' : '' }}"
                                            name="authorization_role[address_type_id]"
                                            required
                                            id="address_type_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($address_types as $address_type)
                                            <option
                                                    @if(old('authorization_role.address_type_id', $authorization_role->address_type_id) == $address_type->id)
                                                    selected
                                                    @endif
                                                    value="{{ $address_type->id }}">{{ $address_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('authorization_role.address_type_id') }}</span>
                                </div>
                            </div>

                            <hr/>
                            <div class=" text-right">
                                <button form="authorization-role-edit-form" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.authorization-roles.index') }}"
                                   class="d-block d-sm-inline btn btn-secondary">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
