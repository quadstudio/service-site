
@if(in_array($order->status_id, array(1,6,7,8)) && $order->in_stock_type == 2)
    {{ $order->total(978, false, true) }} ({{ $order->total(643, false, true) }})
@else
    {{ $order->total(643, true, true) }}
@endif