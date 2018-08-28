@foreach($catalog->catalogs()->where('enabled', 1)->orderBy(config('site.sort_order.catalog'))->get() as $children)
    @if($children->catalogs()->count() == 0 && $children->equipments()->where('enabled', 1)->count() > 0)
        <div class="col-12">
            <h4 class="my-4">{{ $children->parentTreeName() }}</h4>
        </div>
        @foreach($children->equipments()->where('enabled', 1)->orderBy(config('site.sort_order.equipment'))->get() as $equipment)
            <div class="col-12">
                <h5 class="my-2">{{$equipment->name}}</h5>
            </div>
            @if(!$equipment->products->isEmpty())
                @foreach($equipment->products()->where('enabled', 1)->orderBy('name')->get() as $product)
                    <div class="col-12 product-col align-middle">

                        <div class="d-inline-block mr-2">
                            {{--{{dump($product->canBuy)}}--}}
                            @can('buy', $product)
                                @include('site::cart.buy.small', $product->toCart())
                            @else
                                @include('site::product.ask.small')
                            @endcan

                        </div>
                        <span class="width-20 mr-1">
                            <i data-toggle="tooltip"
                               data-placement="top"
                               title="@if($product->quantity > 0) @lang('site::product.in_stock') @else @lang('site::product.not_available') @endif"
                               class="fa fa-circle text-@if($product->quantity > 0) text-success @else text-light @endif"></i>
                        </span>
                        <span>{{$product->sku}}</span>
                        <a href="{{route('products.show', $product)}}">{!! $product->name !!}</a>
                        @can('buy', $product)
                            <span class=" pull-right font-weight-bold text-big">{{ $product->price()->format() }}</span>
                        @endcan
                    </div>
                @endforeach
            @endif
        @endforeach
    @else
        @include('site::catalog.list.children', ['catalog' => $children])
    @endif
@endforeach