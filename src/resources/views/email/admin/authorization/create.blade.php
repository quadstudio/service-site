@extends('layouts.email')

@section('title')
    @lang('site::authorization.email.title')
@endsection

@section('h1')
    @lang('site::authorization.email.h1')
@endsection

@section('body')
    <p><b>@lang('site::authorization.id')</b>: {{$authorization->id }}</p>
    <p><b>@lang('site::authorization.user_id')</b>: {{$authorization->user->name }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.authorizations.show', $authorization) }}">
            &#128194; @lang('site::messages.open') @lang('site::authorization.authorization')</a>
    </p>
@endsection