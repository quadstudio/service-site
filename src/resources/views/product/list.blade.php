<div class="product hover-style product-list">
    <a class="product-image" href="{{ route('products.show', ['id' => $item->id]) }}">
        <img class="card-img-top" src="{{ asset('storage/images/thumbs/'.$item->image) }}" alt="">
    </a>
    <div class="product-body">
        <a style="font-size: 18px;"
           href="{{ route('products.show', ['id' => $item->id]) }}">{!!  htmlspecialchars_decode($item->name) !!}
            ({{ $item->sku }})</a>
        <div class="row">
            <div class="col-6">
                @if($item->price())
                    {{ Shop::format_price($item->price()->price()) }}
                @endif
            </div>
            <div class="col-6">
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
        <p>{{ $item->description }}</p>

    </div>
</div>