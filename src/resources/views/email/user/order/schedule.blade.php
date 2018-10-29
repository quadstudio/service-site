@extends('layouts.email')

@section('title')
    Заказ № {{$order->id }} обрабатывается менеджером
@endsection

@section('h1')
    Заказ № {{$order->id }} обрабатывается менеджером
@endsection

@section('body')
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('orders.show', $order) }}">
            &#128194; Открыть @lang('site::order.order')</a>
    </p>
@endsection