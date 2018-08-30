@extends('layouts.email')

@section('title')
    Исправлен @lang('site::repair.repair')
@endsection

@section('h1')
    Исправлен @lang('site::repair.repair')
@endsection

@section('body')
    <p><b>Компания</b>: {{$repair->user->name }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.repairs.show', $repair) }}">
            &#128194; Открыть @lang('site::repair.repair')</a>
    </p>
@endsection