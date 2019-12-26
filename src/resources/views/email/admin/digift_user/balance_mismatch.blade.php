@extends('layouts.email')

@section('title')
    @lang('site::digift_user.mail.balance_mismatch.title')
@endsection

@section('h1')
    @lang('site::digift_user.mail.balance_mismatch.h1')
@endsection

@section('body')
    <p><b>@lang('site::digift_user.user_id')</b>: {{ $digiftUser->user->name }}</p>
    <p><b>@lang('site::digift_user.mail.balance_mismatch.local')</b>: {{ $balance['local'] }}</p>
    <p><b>@lang('site::digift_user.mail.balance_mismatch.remote')</b>: {{ $balance['remote'] }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.users.show', $digiftUser->user) }}">
            &#128194; @lang('site::messages.open')</a>
    </p>
@endsection