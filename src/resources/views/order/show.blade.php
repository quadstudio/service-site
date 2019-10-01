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
            <a href="{{ route('orders.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>

        <div class="row mb-2">
            <div class="col-xl-4">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::order.info')</span>
                    </h6>
                    <div class="card-body">

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.created_at'):</span>&nbsp;
                            <span class="text-dark">{{$order->created_at->format('d.m.Y H:i' )}}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.status_id'):</span>&nbsp;
                            <span class="badge text-normal badge-pill text-white"
                                  style="background-color: {{ $order->status->color }}">
                                <i class="fa fa-{{ $order->status->icon }}"></i> {{ $order->status->name }}
                            </span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.user_id'):</span>&nbsp;
                            <span class="text-dark">{{ $order->user->name }}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.contragent_id'):</span>&nbsp;
                            <span class="text-dark">{{ $order->contragent->name }}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.address_id'):</span>&nbsp;
                            <span class="text-dark">{{ optional($order->address)->name }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.in_stock_type'):</span>&nbsp;
                            <span class="text-dark">@lang('site::order.help.in_stock_type.'.$order->in_stock_type)</span>
                        </div>

                        <hr class="p-0"/>

                        <div class="mb-2">
                            <div class="font-weight-bold mb-0">@lang('site::order.total'):</div>&nbsp;
                            <div class="text-dark display-6 font-weight-bolder">
                                @include('site::order.total')
                            </div>
                        </div>
                        @if($order->file)
                            <hr class="p-0"/>
                            <div class="mb-2">
                                <div class="font-weight-bold mb-0">@lang('site::order.help.payment')</div>&nbsp;
                                <div class="form-row bg-white">
                                    @include('site::file.download', ['file' => $order->file])
                                </div>
                            </div>
                        @endif
                        <hr class="p-0"/>
                        <div>
                            <form action="{{route('orders.update', $order)}}"
                                  method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="d-flex flex-column justify-content-between">


                                    @if($order->in_stock_type == 2)
                                        @if($order->status_id == 7)
                                            <div class="alert alert-warning" role="alert">
                                                @lang('site::order.help.confirm')
                                            </div>
                                            <button name="order[status_id]"
                                                    value="8"
                                                    type="submit"
                                                    class="btn btn-success mb-1">
                                                @lang('site::order.button.status.8')
                                            </button>
                                        @endif
                                    @endif
                                    @if(in_array($order->status_id, array(1,7,8)) )
                                        <button name="order[status_id]"
                                                value="6"
                                                type="submit"
                                                class="btn btn-danger">
                                            @lang('site::order.button.status.6')
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::order.items')</span>
                    </h6>
                    <div class="card-body">
                        @foreach($order->items as $item)
                            <hr class="mb-3"/>
                            <div class="row mb-sm-1">

                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-3 d-none d-md-block">
                                            <img class="img-fluid img-thumbnail"
                                                 src="{{ $item->product->image()->src() }}">
                                        </div>
                                        <div class="col-sm-9">
                                            <a class="d-block"
                                               href="{{route('products.show', $item->product)}}">{!! $item->product->name() !!}</a>
                                            <div class="text-muted">
                                                {{ $item->quantity }} {{ $item->product->unit }} x
                                                {{Site::convert($item->price, $item->currency_id, $item->currency_id, 1, false, true)}}
                                                @if ($item->currency_id != 643)
                                                    ({{Site::convert($item->price, $item->currency_id, 643, 1, false, true)}}
                                                    )
                                                @endif
                                            </div>
                                            @if($order->in_stock_type == 2)
                                                <div class="text-muted">
                                                    @lang('site::order_item.weeks_delivery'):
                                                    @if($item->weeks_delivery > 0)
                                                        {{numberof($item->weeks_delivery, $item->weeks_delivery, trans('site::messages.weekends'))}}
                                                    @else
                                                        @lang('site::messages.not_indicated_m')
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="my-2">

                                                <button @cannot('delete', $item) disabled @endcannot
                                                class="py-0 px-1 btn btn-danger btn-sm btn-row-delete"
                                                        data-form="#order-item-delete-form-{{$item->id}}"
                                                        data-btn-delete="@lang('site::messages.delete')"
                                                        data-btn-cancel="@lang('site::messages.cancel')"
                                                        data-label="@lang('site::messages.delete_confirm')"
                                                        data-message="@lang('site::messages.delete_sure') {!! $item->product->name() !!}? "
                                                        data-toggle="modal" data-target="#form-modal"
                                                        href="javascript:void(0);"
                                                        title="@lang('site::messages.delete')">
                                                    <i class="fa fa-close"></i> @lang('site::messages.delete')
                                                </button>
                                                <form id="order-item-delete-form-{{$item->id}}"
                                                      action="{{route('order-items.destroy', $item)}}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-sm-4 mb-4 mb-sm-0 text-large text-left text-sm-right">
                                    {{Site::convert($item->price, $item->currency_id, $item->currency_id, $item->quantity, false, true)}}
                                    @if ($item->currency_id != 643)
                                        ({{Site::convert($item->price, $item->currency_id, 643, $item->quantity, true, true)}}
                                        )
                                    @endif
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
                @include('site::message.create', ['messagable' => $order])
            </div>
        </div>
    </div>
@endsection
