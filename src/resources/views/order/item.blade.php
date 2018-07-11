<div class="col-12 mb-2">
    <div class="card">
        {{--<h5 class="card-header">@lang('shop::order.breadcrumb_show', ['order' => $item->id, 'date' => $item->created_at->format(config('shop.time_format', 'd.m.Y')) ])</h5>--}}
        <div class="card-body">
            <h5 class="card-title">Заказ № {{ $item->id() }}
                <span class="badge" style="color:#fff;background-color: {{ $item->status['color'] }};">{{ $item->status['name'] }}</span>
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">от {{ $item->created_at->format('d.m.Y H:i:s') }}</h6>

            <a data-toggle="collapse" href="#order-items-{{ $item->id() }}" role="button" aria-expanded="false"
               aria-controls="order-items-{{ $item->id() }}" class="card-link"><i class="fa fa-chevron-down"></i>
                Подробнее</a>
            <div class="collapse mt-2" id="order-items-{{ $item->id() }}">
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
                    @foreach($item->items as $orderItem)
                        <tr>
                            <td class="text-center d-none d-xl-block" style="width:60px;">
                                <img class="img-fluid img-thumbnail" src="{{ $orderItem->image }}">
                            </td>
                            <td>{!!  htmlspecialchars_decode($orderItem->name) !!} {{ $orderItem->manufacturer }} ({{ $orderItem->sku }})</td>

                            <td class="text-center">{{ $orderItem->quantity }}</td>
                            <td class="text-right">{{ Shop::format_price($orderItem->price) }}</td>
                            <td class="text-right">{{ Shop::format_price($orderItem->subtotal()) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <p class="card-text mt-2 text-right">Сумма
                к оплате: <span
                        class="h4 pl-3">{{ Shop::format_price($item->total()) }}</span>
            </p>
        </div>
    </div>
</div>
