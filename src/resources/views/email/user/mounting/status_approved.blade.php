@extends('layouts.email')

@section('title')
    @lang('site::mounting.email.status_approved.title')
@endsection

@section('h1')
    @lang('site::mounting.email.status_approved.h1')
@endsection

@section('body')
    <p><b>@lang('site::mounting.id')</b>: {{$mounting->id }}</p>
    <p><b>@lang('site::mounting.help.total')</b>: {{ $mounting->total}} {{ $mounting->user->currency->symbol_right }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.mountings.show', $mounting) }}">
            &#128194; @lang('site::messages.open') @lang('site::mounting.mounting')</a>
    </p>
@endsection