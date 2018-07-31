<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 my-2">
    <div class="card h-100 product-item">
        <a href="{{ route('products.show', ['id' => $item->id]) }}">
            <img class="card-img-top" src="{{ $item->image()->src() }}" alt="">
        </a>
        <div class="card-body">
            <div class="row">
                @if($item->price()->exists)
                    <div class="col h4">{{ $item->price()->format() }}</div>
                @endif
                <div class="col text-right">
                    @auth
                    @if(Auth::user()->hasPermission('buy'))
                        @include('site::cart.add', [
                            'product_id' => $item->id,
                            'name' => $item->name,
                            'price'=> $item->price()->price(),
                            'currency_id'=> Site::currency()->id,
                            'image' => $item->image()->src(),
                            'brand_id' => $item->brand_id,
                            'brand' => $item->brand->name,
                            'weight' => $item->weight,
                            'unit' => $item->unit,
                            'sku' => $item->sku,
                            'url' => route('products.show', $item),
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
                <span class="badge badge-success d-block d-md-inline-block">@lang('site::product.in_stock')</span>
            @else
                <span class="badge badge-light d-block d-md-inline-block">@lang('site::product.not_available')</span>
            @endif
        </div>
        <div class="card-footer">
            <p class="card-text"><b>Подходит к:</b><br />{{ $item->relation_equipments()->implode('name', ', ') }}</p>
        </div>
    </div>
</div>