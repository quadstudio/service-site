@extends('layouts.email')

@section('title')
    Оставлена новая @lang('site::member.help.member')
@endsection

@section('h1')
    Оставлена новая @lang('site::member.help.member')
@endsection

@section('body')
    <p><b>Пользователь</b>: {{$member->name }}</p>
    <p><b>Регион</b>: {{$member->region->name }}</p>
    <p><b>Город</b>: {{$member->city }}</p>
    <p><b>Тип мероприятия</b>: {{$member->type->name }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.members.show', $member) }}">
            &#128194; Открыть @lang('site::member.member')</a>
    </p>
@endsection