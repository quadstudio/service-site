<h4 class="text-danger">@lang('site::messages.has_error')</h4>
<form method="POST" action="{{route('storehouses.url.load', request()->route('storehouse'))}}">
    @csrf
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <td class="text-left text-dark">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           checked
                           class="custom-control-input"
                           id="check-all"
                           name="check_all">
                    <label class="custom-control-label" for="check-all">
                        @lang('site::messages.mark')
                        @lang('site::messages.all')
                    </label>
                </div>
            </td>
            <td class="text-center text-dark">@lang('site::product.sku')</td>
            <td class="text-center text-dark">@lang('site::storehouse_product.quantity')</td>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $offer_id => $product)
            <tr>
                <td class="text-left">
                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox"
                               @if(isset($exceptions[$offer_id]))
                               disabled
                               @else
                               checked
                               @endif
                               class="custom-control-input storehouse-product-check @if(isset($exceptions[$offer_id])) disabled @endif"
                               id="check-{{$offer_id}}"
                               @if(!isset($exceptions[$offer_id]))
                               value="{{$product['quantity']}}"
                               name="check[{{$product['product_id']}}]"
                                @endif
                        >
                        <label class="custom-control-label" for="check-{{$offer_id}}">{{$product['name']}}</label>
                    </div>
                    @if(isset($exceptions[$offer_id])) <div class="text-big badge badge-danger text-white">{{$exceptions[$offer_id]}}</div> @endif
                </td>
                <td class="text-center text-big ">{{$product['sku']}}</td>
                <td class="text-right text-big">{{$product['quantity']}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="text-center">
                <button class="btn btn-ferroli" type="submit"><i class="fa fa-download"></i> @lang('site::storehouse_product.button.load')</button>
                <a href="{{route('storehouses.show', request()->route('storehouse'))}}" class="btn btn-secondary"><i class="fa fa-close"></i> @lang('site::messages.cancel')</a>
            </td>
        </tr>
        </tfoot>
    </table>
</form>
