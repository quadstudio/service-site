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
            <li class="breadcrumb-item active">
                @lang('site::messages.change') @lang('site::user.password')
            </li>
        </ol>
        <h1 class="header-title mb-4">
            @lang('site::messages.change') @lang('site::user.password')
        </h1>

        @alert()@endalert

        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <form id="change-password-form" method="POST" action="{{ route('admin.users.password.store', $user) }}">
                            @csrf


                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="password">@lang('site::user.password')</label>
                                    <input type="password"
                                           name="password"
                                           required
                                           id="password"
                                           minlength="6"
                                           maxlength="20"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::user.placeholder.password')"
                                           value="{{ old('password') }}">
                                    <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                            </span>

                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="password-confirmation">@lang('site::user.password_confirmation')</label>
                                    <input id="password-confirmation"
                                           type="password"
                                           required
                                           class="form-control"
                                           placeholder="@lang('site::user.placeholder.password_confirmation')"
                                           name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-ferroli">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.save')</span>
                                    </button>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                                        <i class="fa fa-close"></i>
                                        <span>@lang('site::messages.cancel')</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
