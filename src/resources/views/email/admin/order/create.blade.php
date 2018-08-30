@extends('layouts.email')

@section('title')
    Оформлен новый @lang('site::order.order')
@endsection

@section('h1')
    Оформлен новый @lang('site::order.order')
@endsection

@section('body')
    <p><b>Компания</b>: {{$order->user->name }}</p>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.orders.show', $order) }}">
            &#128194; Открыть @lang('site::order.order')</a>
    </p>
@endsection