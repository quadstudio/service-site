@extends('layouts.email')

@section('title')
    Регистрация нового @lang('site::user.user')
@endsection

@section('h1')
    Регистрация нового @lang('site::user.user')
@endsection

@section('body')
    <p><b>Компания</b>: {{$user->name }}</p>
    <p><b>Адрес сервисного центра</b>: {{$user->addresses()->where('type_id', 2)->first()->name }}</p>
    <p><b>Юридический адрес</b>: {{ $user->contragents()->first()->addresses()->where('type_id', 1)->first()->name }}
    </p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.users.show', $user) }}">
            &#128194; Открыть карточку сервисного центра</a>
    </p>
@endsection