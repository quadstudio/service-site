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

        <div class=" border p-3 mb-4">

            @if($order->messages->isNotEmpty())
                <a href="#messages-list" role="button"
                   class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-@lang('site::message.icon')"></i>
                    <span>
                        @lang('site::messages.show') @lang('site::message.messages')
                        <span class="badge badge-light">{{$order->messages()->count()}}</span>
                    </span>
                </a>
            @endif
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
            <a href="{{ route('orders.index') }}" class="d-block d-sm-inline btn btn-secondary">
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

        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::order.info')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.id')</dt>
                    <dd class="col-sm-8">{{ $order->id }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.address_id')</dt>
                    <dd class="col-sm-8">{{ $order->address->name }}
					<div>
					@foreach($order->address->phones as $phone)
					{{ $phone->format() }}
					@endforeach
					</div>
					</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.created_at')</dt>
                    <dd class="col-sm-8">{{ $order->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.status_id')</dt>
                    <dd class="col-sm-8" style="color:{{$order->status->color}}"><i
                                class="fa fa-{{$order->status->icon}}"></i> {{ $order->status->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::order.total')</dt>
                    <dd class="col-sm-8 text-large">{{ Site::format($order->total()) }}</dd>

                </dl>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">@lang('site::order.items')</h5>
                @foreach($order->items as $item)
                    <hr class="m-1"/>
                    <div class="row mb-sm-1">

                        <div class="col-sm-1 d-none d-md-block">
                            <img class="img-fluid img-thumbnail" src="{{ $item->product->image()->src() }}">
                        </div>
                        <div class="col-sm-8">
                            <a class="d-block"
                               href="{{route('products.show', $item->product)}}">{!! $item->product->name !!}</a>
                            <div class="text-muted">
                                {{ $item->quantity }} {{ $item->product->unit }} x {{ Site::format($item->price) }}
                            </div>
                            <div class="mt-2">
                                <button @cannot('delete', $item->order) disabled @endcannot
                                class="btn btn-danger btn-sm btn-row-delete"
                                        data-form="#order-item-delete-form-{{$item->id}}"
                                        data-btn-delete="@lang('site::messages.delete')"
                                        data-btn-cancel="@lang('site::messages.cancel')"
                                        data-label="@lang('site::messages.delete_confirm')"
                                        data-message="@lang('site::messages.delete_sure') {!! $item->product->name() !!}? "
                                        data-toggle="modal" data-target="#form-modal"
                                        href="javascript:void(0);" title="@lang('site::messages.delete')">
                                    @lang('site::messages.delete')
                                </button>
                                <form id="order-item-delete-form-{{$item->id}}"
                                      action="{{route('orders.items.destroy', $item)}}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4 mb-sm-0 text-large text-left text-sm-right">{{ Cart::price_format($item->subtotal()) }}</div>
                    </div>

                @endforeach
            </div>
        </div>

        <hr id="messages-list"/>
        <div class="card mt-5 mb-4">
            <div class="card-body flex-grow-1 position-relative overflow-hidden">
                <h5 class="card-title">@lang('site::message.messages')</h5>
                @if($order->messages->isNotEmpty())
                    <div class="row no-gutters h-100">
                        <div class="d-flex col flex-column">
                            <div class="flex-grow-1 position-relative">

                                <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                                <div class="chat-messages p-4 ps">
                                    @foreach($order->messages as $message)
                                        <div class="@if($message->user_id == auth()->user()->getAuthIdentifier()) chat-message-right @else chat-message-left @endif mb-4">
                                            <div>
                                                <img src="{{$message->user->logo}}" style="width: 40px!important;"
                                                     class="rounded-circle" alt="">
                                                <div class="text-muted small text-nowrap mt-2">{{ $message->created_at->format('d.m.Y H:i') }}</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == auth()->user()->getAuthIdentifier()) mr-3 @else ml-3 @endif">
                                                <div class="mb-1"><b>{{$message->user->name}}</b></div>
                                                <span class="text-big">{!! $message->text !!}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- / .chat-messages -->
                            </div>
                        </div>
                    </div>
                    <hr/>
                @endif
                <form action="{{route('orders.message', $order)}}" method="post">
                    @csrf

                    <div class="row no-gutters">
                        <div class="d-flex col flex-column">
                            <div class="flex-grow-1 position-relative">
                                <div class="form-group">
                                    <input type="hidden" name="message[receiver_id]" value="1">
                                    <textarea name="message[text]"
                                              id="message_text"
                                              rows="3"
                                              placeholder="@lang('site::message.placeholder.text')"
                                              class="form-control{{  $errors->has('message.text') ? ' is-invalid' : '' }}"></textarea>
                                    <span class="invalid-feedback">{{ $errors->first('message.text') }}</span>
                                </div>
                                <button type="submit"
                                        class="btn btn-success d-block d-sm-inline-block">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.send')</span>
                                </button>

                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
