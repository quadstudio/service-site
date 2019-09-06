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
                <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-3">@lang('site::messages.edit') {{ $user->name }}</h1>

        @alert()@endalert()

        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <form id="user-form" method="POST"
                      action="{{ route('admin.users.update', $user) }}">

                    @csrf
                    @method('PUT')
                    <div class="card mb-4">
                        <div class="card-body">

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="user_warehouse_id">@lang('site::user.warehouse_id')</label>
                                    <select class="form-control
                                            {{$errors->has('user.warehouse_id') ? ' is-invalid' : ''}}"
                                            required
                                            name="user[warehouse_id]"
                                            id="user_warehouse_id">
                                        @foreach($warehouses as $warehouse)
                                            <option
                                                    @if(old('user.warehouse_id') == $warehouse->id || $user->warehouse_id == $warehouse->id) selected
                                                    @endif
                                                    value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('user.warehouse_id') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="user_region_id">@lang('site::user.region_id')</label>
                                    <select class="form-control
                                            {{$errors->has('user.region_id') ? ' is-invalid' : ''}}"
                                            required
                                            name="user[region_id]"
                                            id="user_region_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($districts as $district)
                                            <optgroup label="{{$district->name}}">
                                                @foreach($district->regions()->orderBy('name')->get() as $region)
                                                    <option
                                                            @if(old('user.region_id', $user->region_id) == $region->id)
                                                            selected
                                                            @endif
                                                            value="{{ $region->id }}">{{ $region->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('user.region_id') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="user_active">@lang('site::user.active')</label>
                                    <div class="custom-control custom-radio  custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.active') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[active]"
                                               required
                                               @if(old('user.active', $user->active) == 1) checked @endif
                                               id="user_active_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="user_active_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.active') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[active]"
                                               required
                                               @if(old('user.active', $user->active) == 0) checked @endif
                                               id="user_active_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="user_active_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>
                            <fieldset>
                                <div class="form-row required">
                                    <div class="col mb-3">
                                        <label class="control-label d-block"
                                               for="user_display">@lang('site::user.display')</label>
                                        <div class="custom-control custom-radio  custom-control-inline">
                                            <input class="custom-control-input
                                                    {{$errors->has('user.display') ? ' is-invalid' : ''}}"
                                                   type="radio"
                                                   name="user[display]"
                                                   required
                                                   @if(old('user.display', $user->display) == 1) checked @endif
                                                   id="user_display_1"
                                                   value="1">
                                            <label class="custom-control-label"
                                                   for="user_display_1">@lang('site::messages.yes')</label>
                                        </div>
                                        <div class="custom-control custom-radio  custom-control-inline">
                                            <input class="custom-control-input
                                                    {{$errors->has('user.display') ? ' is-invalid' : ''}}"
                                                   type="radio"
                                                   name="user[display]"
                                                   required
                                                   @if(old('user.display', $user->display) == 0) checked @endif
                                                   id="user_display_0"
                                                   value="0">
                                            <label class="custom-control-label"
                                                   for="user_display_0">@lang('site::messages.no')</label>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="user_verified">@lang('site::user.verified')</label>
                                    <div class="custom-control custom-radio  custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.verified') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[verified]"
                                               required
                                               @if(old('user.verified', $user->verified) == 1) checked @endif
                                               id="user_verified_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="user_verified_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.verified') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[verified]"
                                               required
                                               @if(old('user.verified', $user->verified) == 0) checked @endif
                                               id="user_verified_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="user_verified_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="user_dealer">@lang('site::user.dealer')</label>
                                    <div class="custom-control custom-radio  custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.dealer') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[dealer]"
                                               required
                                               @if(old('user.dealer', $user->dealer) == 1) checked @endif
                                               id="user_dealer_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="user_dealer_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.dealer') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[dealer]"
                                               required
                                               @if(old('user.dealer', $user->dealer) == 0) checked @endif
                                               id="user_dealer_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="user_dealer_0">@lang('site::messages.no')</label>
                                    </div>
                                    <div class="text-muted">@lang('site::user.dealer_comment')</div>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="user_only_ferroli">@lang('site::user.only_ferroli')</label>
                                    <div class="custom-control custom-radio  custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.only_ferroli') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[only_ferroli]"
                                               required
                                               @if(old('user.only_ferroli', $user->only_ferroli) == 1) checked @endif
                                               id="user_only_ferroli_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="user_only_ferroli_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('user.only_ferroli') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="user[only_ferroli]"
                                               required
                                               @if(old('user.only_ferroli', $user->only_ferroli) == 0) checked @endif
                                               id="user_only_ferroli_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="user_only_ferroli_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('rbac::role.roles')</h5>
                            <div class="form-row">
                                <div class="col mb-3">
                                    @foreach($roles->all() as $role)

                                        <div class="custom-control custom-checkbox"
                                             style="@if($role->name == 'admin') display:none;@endif">
                                            <input name="roles[]"
                                                   value="{{ $role->id }}"
                                                   type="checkbox"
                                                   @if($user->roles->contains('id', $role->id))
                                                   checked
                                                   @endif
                                                   class="custom-control-input" id="role-{{ $role->id }}">
                                            <label class="custom-control-label"
                                                   for="role-{{ $role->id }}">{{ $role->title }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-ferroli">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.save')</span>
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-close"></i>
                                        <span>@lang('site::messages.cancel')</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection