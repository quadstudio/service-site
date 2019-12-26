@extends('layouts.email')

@section('title')
    @lang('site::digift.email.exception.title')
@endsection

@section('h1')
    @lang('site::digift.email.exception.h1')
@endsection

@section('body')
    <p><b>@lang('site::digift.email.exception.message', ['method' => $method])</b>: {{ $exception }}</p>
@endsection