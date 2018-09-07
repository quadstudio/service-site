@if($products->isNotEmpty())

    <ul>
        @foreach($products as $key => $product)
            @if($key < config('site.datasheet.products.count', 5))
                <li>
                    <a class="mr-3" href="{{route('products.show', $product)}}">{!! $product->name !!}</a>
                    @if($datasheet->schemes()->count() > 0)
                        <a class=""
                           href="{{route('products.scheme', [$product, $datasheet->schemes()->first()])}}">
                            (@lang('site::messages.open') @lang('site::scheme.scheme'))
                        </a>
                    @endif
                </li>
            @else
                <li class="text-muted">... подходит еще к {{$products->count() - config('site.datasheet.products.count', 5)}} {{numberof($products->count() - config('site.datasheet.products.count', 5), 'товар', ['у', 'ам', 'ам'])}} </li>
                <li><a href="{{route('datasheets.show', $datasheet)}}">Показать все товары</a></li>
                @break
            @endif
        @endforeach
    </ul>

@endif