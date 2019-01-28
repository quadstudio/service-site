@extends('layouts.email')

@section('title')
    Подтвердите свой E-mail адрес
@endsection

@section('h1')
    Заявка на мероприятие {{$member->type->name}}
@endsection

@section('body')
    <p>Вы подали заявку на участие в мероприятии {{$member->type->name}} в городе {{$member->city}} от имени {{$member->name }} на сайте
        <a target="_blank" href="{{route('index')}}">{{env('APP_URL')}}</a>
    </p>
    <p>Для завершения регистрации необходимо подтвердить свой E-mail: {{ $member->email }}</p>
    <p>Для этого вам необходимо пройти по ссылке:</p>
    <p>
        <a class="btn btn-ferroli btn-lg" target="_blank" href="{{ url("members/confirm/{$member->verify_token}") }}">
            ✔ Подтвердить E-mail</a>
    </p>
    <p>Если вы не подавали заявку на участие, то, скорее всего, это письмо пришло вам по ошибке, просто
        проигнорируйте его.</p>
@endsection