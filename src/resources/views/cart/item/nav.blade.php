<a class="dropdown-item text-left" target="{{ config('cart.target', '_self') }}" href="{{$item->url()}}">
    <b>{!! htmlspecialchars_decode($item->name) !!}</b>
    <div class="dropdown-message text-left">
        {{ $item->quantity() }}<small>x</small>{{ Cart::price_format($item->price) }}
        {{--<small>=</small>--}}
        {{--{{ Cart::price_format($item->subtotal()) }}--}}
    </div>
</a>
<div class="dropdown-divider"></div>