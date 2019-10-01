@extends('layouts.email')

@section('title')
   @lang('site::order.email.create.title')
@endsection

@section('h1')
    @lang('site::order.email.create.h1')
@endsection

@section('body')
    <p><b>@lang('site::order.id')</b>: {{$order->id }}</p>
    <p><b>@lang('site::order.user_id')</b>: {{$order->user->name }}</p>
    <p><b>{{ $order->address->type->name }}</b>: {{ $order->address->name }} </p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('orders.index') }}">
            &#128194; @lang('site::order.orders')</a>
    </p>
@endsection