@extends('layouts.email')

@section('title')
    FERROLI. Заказ № {{$order->id }} от {{ $order->created_at(true) }} {{$order->user->name }}
@endsection

@section('h1')
    Заказ № {{$order->id }} от {{ $order->created_at(true) }} {{$order->user->name }}
@endsection

@section('body')
    <p><b>№ заказа</b>: {{$order->id }} от {{ $order->created_at(true) }}</p>
    <p><b>Компания</b>: {{$order->user->name }} &nbsp; ({{$order->user->email }}
        @foreach($order->user->addresses as $address)
            @foreach($address->phones as $phone)
                ,&nbsp; {{ $phone->format() }}
            @endforeach
        @endforeach

    </p>
    <p><b>Склад отгрузки</b>: {{ $order->address->name }} </p>

    <p><b>@lang('site::order.items')</b></p>
    <table>
        <tr>
            <th>Наименование</th>
            <th>Кол-во</th>
            <th>Ед</th>
            <th>Цена</th>
            <th>Стоимость</th>
        </tr>
        @foreach($order->items as $item)
            <tr>
                <td>{!! $item->product->name !!}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product->unit }}</td>
                <td>{{ Site::format($item->price) }}</td>
                <td>{{ Cart::price_format($item->subtotal()) }}</td>

            </tr>

        @endforeach

    </table>

    @if($order->messages->isNotEmpty())
        <hr/>
        <div class="chat-messages p-4 ps">
            @foreach($order->messages as $message)
                <div class="@if($message->user_id == Auth::user()->id) chat-message-right @else chat-message-left @endif mb-4">

                    <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == Auth::user()->id) mr-3 @else ml-3 @endif">
                        <div class="mb-1"><b>Комментарий {{$message->user->name}}</b></div>
                        <span class="text-big">{!! $message->text !!}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <hr/>
    @endif

@endsection