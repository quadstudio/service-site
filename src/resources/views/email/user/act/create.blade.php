@extends('layouts.email')

@section('title')
    Сформированы акты выполненных работ
@endsection

@section('h1')
    Сформированы акты выполненных работ
@endsection

@section('body')

    @foreach($acts as $act)
        <p>
            <a class="btn btn-ferroli btn-lg" href="{{ route('acts.show', $act) }}">
                &#128194; Открыть @lang('site::act.act') № {{$act->id}}</a>
        </p>
    @endforeach

@endsection