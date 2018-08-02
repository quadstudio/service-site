@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('orders.index') }}">@lang('site::order.breadcrumb_index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::order.breadcrumb_show', ['order' => $order->id, 'date' => $order->created_at->format(config('shop.time_format', 'd.m.Y H:i')) ])</li>
        </ol>
        <h1 class="header-titlemb-4">@lang('site::order.order') № {{ $order->id }}</h1>
        <hr/>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">@lang('site::order.info')</div>
                    <div class="card-body">
                        <div class="m-b-20">
                            <strong>@lang('site::order.created_at')</strong>
                            <br>
                            <p class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="m-b-20">
                            <strong>@lang('site::order.status_id')</strong>
                            <br>
                            <p style="color: {{ $order->status['color'] }};">{{ $order->status['name'] }}</p>
                        </div>
                        <div class="m-b-20">
                            <strong>@lang('site::order.comment')</strong>
                            <br>
                            <p class="text-muted">{!! $order->comment !!}</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">@lang('site::product.products')</div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>Наименование</th>
                                <th class="text-center">Количество</th>
                                <th class="text-right">Цена</th>
                                <th class="text-right">Всего</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->items as $orderItem)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.products.show', $orderItem->product) }}">
                                            {!!  htmlspecialchars_decode($orderItem->name) !!} {{ $orderItem->manufacturer }}
                                            ({{ $orderItem->sku }})
                                        </a>
                                    </td>

                                    <td class="text-center">{{ $orderItem->quantity }}</td>
                                    <td class="text-right">{{ Site::format($orderItem->price) }}</td>
                                    <td class="text-right">{{ Site::format($orderItem->subtotal()) }}</td>
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
