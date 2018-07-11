@extends('layouts.app')
@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::user.login')</li>
        </ol>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-login mx-auto mt-5">
                    <div class="card-header">@lang('site::user.login')</div>

                    <div class="card-body">

                        @alert()@endalert

                        <form method="POST" action="{{ route('login') }}">

                            @csrf

                            <div class="form-group {{ $errors->has('login') ? 'has-error' : '' }}">
                                <label for="email">@lang('site::user.email')</label>
                                <input class="form-control {{ $errors->has('email')?' is-invalid':''}}"
                                       name="email"
                                       id="email"
                                       type="email"
                                       required autofocus
                                       aria-describedby="emailHelp" value="{{ old('email') }}"
                                       placeholder="@lang('site::user.placeholder.email')">
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password">@lang('site::user.password')</label>
                                <input name="password"
                                       id="password"
                                       class="form-control {{ $errors->has('email')?' is-invalid':''}}"
                                       required
                                       type="password"
                                       placeholder="@lang('site::user.placeholder.password')">

                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input name="remember" type="checkbox"
                                           {{ old('remember') ? 'checked' : '' }}
                                           class="custom-control-input"
                                           id="remember">
                                    <label class="custom-control-label"
                                           for="remember">@lang('site::user.remember')</label>
                                </div>
                            </div>
                            <div class="form-group account-btn text-site m-t-10">
                                <div class="col-xs-12">
                                    <button class="btn btn-lg btn-block btn-primary"
                                            type="submit">@lang('site::user.sign_in')</button>
                                </div>
                            </div>
                        </form>
                        <div class="text-site">
                            <a class="d-block small"
                               href="{{route('password.request')}}">@lang('site::user.forgot')</a>
                        </div>
                        <div class="text-left">
                            <table class="table table-sm">
                                <caption>Пароль: 123456</caption>
                                <tbody>
                                <tr>
                                    <td>Администратор</td>
                                    <td>admin@test.ru</td>
                                </tr>
                                <tr>
                                    <td>Зарегистрированный пользователь</td>
                                    <td>user@test.ru</td>
                                </tr>
                                <tr>
                                    <td>Авторизованный сервисный центр</td>
                                    <td>asc@test.ru</td>
                                </tr>
                                <tr>
                                    <td>Менеджер</td>
                                    <td>manager@test.ru</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card card-register mx-auto mt-5">
                    <div class="card-header">@lang('site::user.register')</div>
                    <div class="card-body">
                        <h5 class="card-title">@lang('site::messages.advantages')</h5>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">@lang('site::messages.advantages_1')</li>
                            <li class="list-group-item">@lang('site::messages.advantages_2')</li>
                            <li class="list-group-item">@lang('site::messages.advantages_3')</li>
                        </ul>
                        <hr/>
                        <a href="{{route('register')}}"
                           class="btn btn-block btn-lg btn-primary">@lang('site::user.sign_up')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
