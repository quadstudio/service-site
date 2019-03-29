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
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::authorization_role.authorization_role')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.authorization-roles.store') }}">
                    @csrf
                    <div class="form-group required">
                        <label class="control-label"
                               for="role_id">@lang('site::authorization_role.role_id')</label>
                        <select class="form-control{{ $errors->has('authorization_role.role_id') ? ' is-invalid' : '' }}"
                                required
                                name="authorization_role[role_id]"
                                id="role_id">
                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('authorization_role.role_id') }}</span>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::authorization_role.name')</label>
                            <input type="text" name="authorization_role[name]"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('authorization_role.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::authorization_role.placeholder.name')"
                                   value="{{ old('authorization_role.name') }}">
                            <span class="invalid-feedback">{{ $errors->first('authorization_role.name') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="title">@lang('site::authorization_role.title')</label>
                            <input type="text" name="authorization_role[title]"
                                   id="title"
                                   required
                                   class="form-control{{ $errors->has('authorization_role.title') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::authorization_role.placeholder.title')"
                                   value="{{ old('authorization_role.title') }}">
                            <span class="invalid-feedback">{{ $errors->first('authorization_role.title') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3 required">

                            <label class="control-label" for="address_type_id">@lang('site::authorization_role.address_type_id')</label>
                            <select class="form-control{{  $errors->has('authorization_role.address_type_id') ? ' is-invalid' : '' }}"
                                    name="authorization_role[address_type_id]"
                                    required
                                    id="address_type_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($address_types as $address_type)
                                    <option
                                            @if(old('authorization_role.address_type_id') == $address_type->id)
                                            selected
                                            @endif
                                            value="{{ $address_type->id }}">{{ $address_type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('authorization_role.address_type_id') }}</span>
                        </div>
                    </div>
                </form>
                <hr/>
                <div class="form-row">
                    <div class="col text-right">
                        <button form="form-content" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.authorization-roles.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection