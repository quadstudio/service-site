@if($products->isNotEmpty())
    <div class="card mb-2">
        <div class="card-body">
            <h3>@lang('site::storehouse.help.products')</h3>
            @filter(['repository' => $repository])@endfilter
            @pagination(['pagination' => $products])@endpagination
            {{$products->render()}}
            <table class="table table-sm table-hover">
                <thead>
                <tr>
                    <th>@lang('site::product.sku')</th>
                    <th>@lang('site::product.name')</th>
                    <th class="text-right">@lang('site::storehouse_product.quantity')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->product->sku}}</td>
                        <td>{{$product->product->name}}</td>
                        <td class="text-right">{{number_format($product->quantity, 0, '.', ' ')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$products->render()}}
        </div>
    </div>
@endif