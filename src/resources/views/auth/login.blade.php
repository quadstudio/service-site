@extends('layouts.app')

@section('header')
    @include('site::header.front',[
        'h1' => __('site::user.login'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::user.login')]
        ]
    ])
@endsection

@section('content')

    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        @alert()@endalert
                        <form method="POST" autocomplete="off" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group {{ $errors->has('email') ? 'has-error':'' }}">
                                <label for="email">@lang('site::user.email')</label>
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid':''}}"
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
                            <div class="form-group {{ $errors->has('password') ? 'has-error':'' }}">
                                <label for="password">@lang('site::user.password')</label>
                                <input name="password"
                                       id="password"
                                       class="form-control {{ $errors->has('password') ? 'is-invalid':''}}"
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
                                           {{ old('remember') ? 'checked':'' }}
                                           class="custom-control-input"
                                           id="remember">
                                    <label class="custom-control-label" for="remember">@lang('site::user.remember')</label>
                                </div>
                            </div>
                            <div class="form-group account-btn text-site m-t-10">
                                <div class="col-xs-12">
                                    <button class="btn btn-ferroli" type="submit">@lang('site::user.sign_in')</button>
                                </div>
                            </div>
                        </form>
                        <div class="text-site">
                            <a class="d-block" href="{{route('password.request')}}">@lang('site::user.forgot')</a>
                            <a class="d-block" href="{{route('register')}}">@lang('site::user.sign_up')</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
