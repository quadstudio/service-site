@extends('layouts.email')

@section('title')
    @lang('site::message.email.title')
@endsection

@section('h1')
    @lang('site::message.email.h1')
@endsection

@section('body')

    <p><b>@lang('site::message.user_id')</b>: {{$mail_message->user->name }}</p>
    <p><b>@lang('site::message.subject')</b>: {{$mail_message->messagable->messageSubject()}}</p>
    <p><b>@lang('site::message.text')</b>: {!! $mail_message->text !!}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ $mail_message->messagable->messageMailRoute() }}">
            &#128194; @lang('site::messages.open') @lang('site::message.message')</a>
    </p>
@endsection