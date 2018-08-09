<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 my-2">
    <div class="card h-100 product-item">
        <a href="{{ route('products.show', ['id' => $product->id]) }}">
            <img class="card-img-top" src="{{ $product->image()->src() }}" alt="">
        </a>
        <div class="card-body">
            <div class="row">
                @if($product->price()->exists)
                    <div class="col-8 h4">{{ $product->price()->format() }}</div>
                @endif
                <div class="col-4 text-right">
                    @auth
                    @if(Auth::user()->hasPermission('buy'))
                        @include('site::cart.add', $product->toCart())
                    @endif
                    @endauth
                </div>
            </div>

            <h6 class="card-title">
                <a href="{{ route('products.show', ['id' => $product->id]) }}">{!!  htmlspecialchars_decode($product->name) !!}
                    ({{ $product->sku }})</a>
            </h6>
            @if($product->quantity > 0)
                <span class="badge badge-success d-block d-md-inline-block">@lang('site::product.in_stock')</span>
            @else
                <span class="badge badge-light d-block d-md-inline-block">@lang('site::product.not_available')</span>
            @endif
        </div>
        <div class="card-footer">
            <p class="card-text">{{ $product->relation_equipments()->implode('name', ', ') }}</p>
        </div>
    </div>
</div>