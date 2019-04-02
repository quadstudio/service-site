@extends('layouts.email')

@section('title')
    @lang('site::order.email.status_change.title')
@endsection

@section('h1')
    @lang('site::order.email.status_change.h1')
@endsection

@section('body')
    <p><b>@lang('site::order.id')</b>: {{$order->id }}</p>
    <p><b>@lang('site::order.status_id')</b>: {{$order->status->name }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('orders.show', $order) }}">
            &#128194; @lang('site::messages.open') @lang('site::order.order')</a>
    </p>
@endsection