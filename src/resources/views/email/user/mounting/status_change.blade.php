@extends('layouts.email')

@section('title')
    @lang('site::mounting.email.status_change.title')
@endsection

@section('h1')
    @lang('site::mounting.email.status_change.h1')
@endsection

@section('body')
    <p><b>@lang('site::mounting.id')</b>: {{$mounting->id }}</p>
    <p><b>@lang('site::mounting.status_id')</b>: {{$mounting->status->name }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('mountings.show', $mounting) }}">
            &#128194; @lang('site::messages.open') @lang('site::mounting.mounting')</a>
    </p>
@endsection