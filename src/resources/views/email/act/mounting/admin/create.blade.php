@extends('layouts.email')

@section('title')
    @lang('site::act.email.create.mounting.title')
@endsection

@section('h1')
    @lang('site::act.email.create.mounting.h1')
@endsection

@section('body')
    <p><b>@lang('site::act.user_id')</b>:
        <a href="{{ route('admin.users.show', $user) }}">
            {{$user->name }}
        </a>
    </p>
    @foreach($acts as $act)
        <p>
            <a class="btn btn-ferroli btn-lg" href="{{ route('admin.acts.show', $act) }}">
                &#128194; @lang('site::messages.open') @lang('site::act.act') № {{$act->id}}
            </a>
        </p>
    @endforeach

@endsection