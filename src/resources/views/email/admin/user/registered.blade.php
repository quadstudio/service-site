@extends('layouts.email')

@section('title')
    Регистрация нового @lang('site::user.user')
@endsection

@section('h1')
    Регистрация нового @lang('site::user.user')
@endsection

@section('body')
    <p><b>Компания</b>: {{$user->name }}</p>
	@if(!empty($user->contragents()->first()))
	
    <p><b>Юридический адрес</b>: {{ $user->contragents()->first()->addresses()->where('type_id', 1)->first()->full }}
    </p> @endif
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.users.show', $user) }}">
            &#128194; Открыть карточку сервисного центра</a>
    </p>
@endsection