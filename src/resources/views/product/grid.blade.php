<div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
    <div class="card h-100 product-item">
        <a href="{{ route('products.show', ['id' => $item->id]) }}">
            <img class="card-img-top" src="{{ asset('storage/images/products/'.$item->image) }}" alt="">
        </a>
        <div class="card-body">
            <div class="row">
                <div class="col h4" style="min-width: 125px;">
                    @if($item->price())
                        {{ Shop::format_price($item->price()->price()) }}
                    @endif
                </div>
                <div class="col" style="max-width: 100px;">
                    @auth
                    @if($current_user->hasPermission('buy'))
                        @includeIf('cart::add', [
                            'product_id' => $item->id,
                            'name' => $item->name,
                            'price'=> $item->price()->price(),
                            'currency_id'=> config('shop.currency'),
                            'image' => config('shop.cart_storage').$item->image,
                            'manufacturer' => $item->manufacturer,
                            'weight' => $item->weight,
                            'unit' => $item->unit,
                            'sku' => $item->sku,
                            'url' => route('products.show', ['id' => $item->id]),
                            'availability' => $item->quantity > 0,
                            'quantity' => 1
                        ])
                    @endif
                    @endauth
                </div>
            </div>

            <h6 class="card-title">
                <a href="{{ route('products.show', ['id' => $item->id]) }}">{!!  htmlspecialchars_decode($item->name) !!}
                    ({{ $item->sku }})</a>
            </h6>
            @if($item->quantity > 0)
                <span class="badge badge-success d-block d-md-inline-block">@lang('shop::messages.in_stock')</span>
            @else
                <span class="badge badge-light d-block d-md-inline-block">@lang('shop::messages.not_available')</span>
            @endif
        </div>
        <div class="card-footer">
            <p class="card-text">Подходит к:</p>
        </div>
    </div>
</div>