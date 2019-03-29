@extends('layouts.email')

@section('title')
    @lang('site::repair.email.status_change.title')
@endsection

@section('h1')
    @lang('site::repair.email.status_change.title')
@endsection

@section('body')
    <p><b>@lang('site::repair.id')</b>: {{$repair->id }}</p>
    <p><b>@lang('site::repair.status_id')</b>: {{$repair->status->name }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('repairs.show', $repair) }}">
            &#128194; @lang('site::messages.open') @lang('site::repair.repair')</a>
    </p>
@endsection