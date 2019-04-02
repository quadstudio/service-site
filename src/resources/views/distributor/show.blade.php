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
                <a href="{{ route('distributors.index') }}">@lang('site::order.distributors')</a>
            </li>
            <li class="breadcrumb-item active">№ {{ $order->id }}</li>
        </ol>
        <h1 class="header-title mb-4">№ {{ $order->id }}</h1>
        @alert()@endalert()

        <div class=" border p-3 mb-2">

            <a href="{{ route('distributors.excel', ['order' => $order]) }}"
               class="d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-primary">
                <i class="fa fa-download"></i>
                <span>@lang('site::messages.download') @lang('site::messages.to_excel')</span>
            </a>
            <a href="{{ route('distributors.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
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
                                    <a href="{{route('products.show', $item->product)}}">
                                        {!! $item->product->name !!}
                                    </a>
                                    <span class="text-muted">
                                            ({{ $item->quantity }} {{ $item->product->unit }}
                                        x
                                        {{number_format($item->price, 0, '.', ' ')}}
                                        {{ $order->user->currency->symbol_right }})
                                        </span>
                                    <div class="text-big">
                                        {{number_format($item->subtotal(), 0, '.', ' ')}}
                                        {{ $order->user->currency->symbol_right }}
                                    </div>
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


            <div class="card-body border-top">
                <h5 class="card-title">@lang('site::order.help.change_status')</h5>
                @if($order_statuses->isNotEmpty())
                    @foreach($order_statuses as $order_status)
                        <button type="submit"
                                form="order-edit-form"
                                name="order[status_id]"
                                value="{{$order_status->id}}"
                                class="btn btn-{{$order_status->color}} d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0">
                            <i class="fa fa-{{$order_status->icon}}"></i>
                            <span>{{$order_status->name}}</span>
                        </button>
                    @endforeach
                @endif
                <form id="order-edit-form"
                      action="{{route('distributors.update', $order)}}"
                      method="POST">
                    @csrf
                    @method('PUT')
                </form>
            </div>
        </div>
    </div>
@endsection
