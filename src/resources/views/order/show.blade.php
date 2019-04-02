@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('orders.index') }}">@lang('site::order.breadcrumb_index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::order.breadcrumb_show', ['order' => $order->id, 'date' => $order->created_at->format('d.m.Y H:i') ])</li>
        </ol>
        <h1 class="header-title mb-4">№ {{ $order->id }}</h1>
        @alert()@endalert()

        <div class=" border p-3 mb-2">

            <button @cannot('delete', $order) disabled @endcannot
            class="btn btn-danger btn-row-delete"
                    data-form="#order-delete-form-{{$order->id}}"
                    data-btn-delete="@lang('site::messages.delete')"
                    data-btn-cancel="@lang('site::messages.cancel')"
                    data-label="@lang('site::messages.delete_confirm')"
                    data-message="@lang('site::messages.delete_sure') @lang('site::order.order')? "
                    data-toggle="modal" data-target="#form-modal"
                    href="javascript:void(0);" title="@lang('site::messages.delete')">
                @lang('site::messages.delete')
            </button>
            <a href="{{ route('orders.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            <form id="order-delete-form-{{$order->id}}"
                  action="{{route('orders.destroy', $order)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>

        @include('site::message.create', ['messagable' => $order])

        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::order.info')</h5>
                <dl class="row">
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.id')</dt>
                    <dd class="col-sm-8">{{ $order->id }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.status_id')</dt>
                    <dd class="col-sm-8">
                        <span class="badge text-normal badge-pill badge-{{ $order->status->color }}">
                            <i class="fa fa-{{ $order->status->icon }}"></i> {{ $order->status->name }}
                        </span>
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.created_at')</dt>
                    <dd class="col-sm-8">{{ $order->created_at->format('d.m.Y H:i') }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.user_id')</dt>
                    <dd class="col-sm-8">{{ $order->user->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.contragent_id')</dt>
                    <dd class="col-sm-8">{{ $order->contragent->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.contacts_comment')</dt>
                    <dd class="col-sm-8">{{ $order->contacts_comment }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.address_id')</dt>
                    <dd class="col-sm-8">{{ $order->address->name }}
                        <div>
                            @foreach($order->address->phones as $phone)
                                {{ $phone->country->phone }} {{ $phone->number }}
                            @endforeach
                        </div>
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.items')</dt>
                    <dd class="col-sm-8">
                        @foreach($order->items as $item)
                            <div class="row mb-1">
                                <div class="col-3 col-md-2">
                                    <img class="img-fluid img-thumbnail" src="{{ $item->product->image()->src() }}">
                                </div>
                                <div class="col-9 col-md-10">
                                    <div>
                                        <a href="{{route('products.show', $item->product)}}">
                                            {!! $item->product->name !!}
                                        </a>
                                        <span class="text-muted">
                                            ({{ $item->quantity }} {{ $item->product->unit }} x
                                            {{number_format($item->price, 0, '.', ' ')}}
                                            {{ $order->user->currency->symbol_right }})
                                        </span>
                                        <button class="btn btn-danger btn-sm py-0 btn-row-delete"
                                                @cannot('delete', $item->order) disabled @endcannot
                                                data-form="#order-item-delete-form-{{$item->id}}"
                                                data-btn-delete="@lang('site::messages.delete')"
                                                data-btn-cancel="@lang('site::messages.cancel')"
                                                data-label="@lang('site::messages.delete_confirm')"
                                                data-message="@lang('site::messages.delete_sure') {!! $item->product->name() !!}? "
                                                data-toggle="modal" data-target="#form-modal"
                                                href="javascript:void(0);" title="@lang('site::messages.delete')">
                                            @lang('site::messages.delete')
                                        </button>
                                    </div>
                                    <div class="text-big">
                                        {{number_format($item->subtotal(), 0, '.', ' ')}}
                                        {{ $order->user->currency->symbol_right }}
                                    </div>
                                    <form id="order-item-delete-form-{{$item->id}}"
                                          action="{{route('orders.items.destroy', $item)}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.total')</dt>
                    <dd class="col-sm-8 text-large">
                        {{number_format($order->total(), 0, '.', ' ')}}
                        {{ $order->user->currency->symbol_right }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
