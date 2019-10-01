@extends('layouts.email')

@section('title')
   @lang('site::order.email.confirm.title')
@endsection

@section('h1')
    @lang('site::order.email.confirm.h1')
@endsection

@section('body')
    <p><b>@lang('site::order.id')</b>: {{$order->id }}</p>
    <p><b>@lang('site::order.user_id')</b>: {{$order->user->name }}</p>
    <p><b>{{ $order->address->type->name }}</b>: {{ $order->address->name }} </p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.orders.show', $order) }}">
            &#128194; @lang('site::messages.open') @lang('site::order.order')</a>
    </p>
@endsection