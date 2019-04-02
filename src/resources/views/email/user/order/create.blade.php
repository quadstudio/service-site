@extends('layouts.email')

@section('title')
    @lang('site::order.email.create.title')
@endsection

@section('h1')
    @lang('site::order.email.create.title')
@endsection

@section('body')
    <p><b>@lang('site::order.id')</b>: {{$order->id }}</p>
    <p><b>@lang('site::messages.created_at')</b>: {{ $order->created_at->format('d.m.Y H:i') }}</p>
    <p><b>@lang('site::order.user_id')</b>: {{$order->user->name }}</p>
    <p><b>@lang('site::user.email')</b>: {{$order->user->email }}</p>
    <p><b>@lang('site::phone.phones')</b>:</p>
    <ul>
        @foreach($order->user->addresses as $address)
            @foreach($address->phones as $phone)
                <li>{{ $phone->country->phone }} {{ $phone->number }}</li>
            @endforeach
        @endforeach
    </ul>
    <p><b>{{ $order->address->type->name }}</b>: {{ $order->address->name }} </p>
    <p><b>@lang('site::order.contacts_comment')</b>: {{$order->contacts_comment }}</p>
    <p><b>@lang('site::order.items')</b></p>
    <table>
        <tr>
            <th>@lang('site::product.name')</th>
            <th>@lang('site::product.help.quantity')</th>
            <th>@lang('site::product.unit')</th>
            <th>@lang('site::price.price')</th>
            <th>@lang('site::price.help.cost')</th>
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
        <div class="chat-messages p-4 ps">
            @foreach($order->messages as $message)
                <div class="@if($message->user_id == auth()->user()->getAuthIdentifier()) chat-message-right @else chat-message-left @endif mb-4">

                    <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == auth()->user()->getAuthIdentifier()) mr-3 @else ml-3 @endif">
                        <div class="mb-1"><b>Комментарий {{$message->user->name}}</b></div>
                        <span class="text-big">{!! $message->text !!}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection