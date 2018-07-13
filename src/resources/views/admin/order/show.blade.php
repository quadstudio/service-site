@extends('center::layouts.page')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('shop::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('orders.index') }}">@lang('shop::order.breadcrumb_index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('shop::order.breadcrumb_show', ['order' => $order->id, 'date' => $order->created_at->format(config('shop.time_format', 'd.m.Y H:i')) ])</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">@lang('shop::order.order') № {{ $order->id }}</h1>
        <hr/>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">@lang('shop::order.info')</div>
                    <div class="card-body">
                        <div class="m-b-20">
                            <strong>@lang('shop::order.created_at')</strong>
                            <br>
                            <p class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="m-b-20">
                            <strong>@lang('shop::order.status_id')</strong>
                            <br>
                            <p style="color: {{ $order->status['color'] }};">{{ $order->status['name'] }}</p>
                        </div>
                        <div class="m-b-20">
                            <strong>@lang('shop::order.comment')</strong>
                            <br>
                            <p class="text-muted">{!! $order->comment !!}</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">@lang('shop::product.products')</div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th colspan="2">Наименование</th>
                                <th class="text-center">Количество</th>
                                <th class="text-right">Цена</th>
                                <th class="text-right">Всего</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->items as $orderItem)
                                <tr>
                                    <td class="text-center d-none d-xl-block" style="width:60px;">
                                        <img class="img-fluid img-thumbnail" src="{{ url($orderItem->image) }}">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $orderItem->product) }}">
                                            {!!  htmlspecialchars_decode($orderItem->name) !!} {{ $orderItem->manufacturer }}
                                            ({{ $orderItem->sku }})
                                        </a>
                                    </td>

                                    <td class="text-center">{{ $orderItem->quantity }}</td>
                                    <td class="text-right">{{ Shop::format_price($orderItem->price) }}</td>
                                    <td class="text-right">{{ Shop::format_price($orderItem->subtotal()) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
