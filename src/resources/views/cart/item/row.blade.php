<tr class="cart-item" id="cart-item-{{ $item->product_id }}">

    <td class="text-left">
        <div class="row">
            @if(config('cart.image', false))
                <div class="col item-img d-none d-xl-block">
                    <img class="img-fluid img-thumbnail" src="{{ $item->image }}">
                </div>
            @endif
            <div class="col item-info">
                <a href="{{ $item->url() }}">
                    <span class="item-name">{!! htmlspecialchars_decode($item->name) !!}</span>
                    @if(config('cart.brand', false) === true && $item->hasBrand())
                        <span class="item-manufacturer">{{ $item->brand }}</span>
                    @endif
                    @if(config('cart.sku', false) === true && $item->hasSku())
                        <span class="item-sku">({{ $item->sku }})</span>
                    @endif
                </a>
                <div>
                    @if(config('cart.availability', false) === true)

                        @if($item->availability)
                            <span class="item-availability badge badge-success">@lang('site::cart.in_stock')</span>
                        @else
                            <span class="item-availability badge badge-light">@lang('site::cart.out_of_stock')</span>
                        @endif

                    @endif

                    @if(config('cart.weight', false) === true && $item->hasWeight())
                        <small class="item-weight badge badge-light">{{ Cart::weight_format(Cart::weight_convert($item->weight)) }} @lang('site::cart.weight_unit.'.(config('cart.weight_output')))</small>
                    @endif
                </div>
                <a class="text-danger d-block btn-row-delete mt-3"
                   data-form="#cart-item-delete-form-{{$item->id}}"
                   data-btn-delete="@lang('site::messages.delete')"
                   data-btn-cancel="@lang('site::messages.cancel')"
                   data-label="@lang('site::messages.delete_confirm')"
                   data-message="@lang('site::messages.delete_sure') {{ $item->name }}?"
                   data-toggle="modal" data-target="#form-modal"
                   href="javascript:void(0);" title="@lang('site::messages.delete')"><i class="fa fa-close"></i> @lang('site::cart.item_delete')
                </a>
                <form id="cart-item-delete-form-{{$item->id}}"
                      action="{{route('removeCartItem')}}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                </form>

                {{--<form action="{{route('removeCartItem')}}" method="post">--}}
                    {{--@csrf--}}
                    {{--@method('delete')--}}
                    {{--<a data-toggle="modal" data-target="#confirm-delete" class="text-danger small"--}}
                       {{--href="javascript:void(0);">--}}
                        {{--<i class="fa fa-close"></i> @lang('site::cart.item_delete')--}}
                    {{--</a>--}}
                    {{--<input type="hidden" name="product_id" value="{{ $item->product_id }}">--}}
                {{--</form>--}}
            </div>
        </div>
    </td>
    <td class="text-center item-qty">
        <form action="{{route('updateCart')}}" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
            <button class="btn btn-light qty-btn btn-minus" @if($item->quantity() == 1) disabled @endif><i
                        class="fa fa-chevron-down"></i></button>
            <input data-toggle="popover" data-placement="top" data-trigger="focus"
                   title="@lang('site::cart.item_hint_title')" name="quantity"
                   data-content="@lang('site::cart.item_hint_content', ['max' => config('cart.item_max_quantity')])"
                   min="1" max="{{ config('cart.item_max_quantity') }}"
                   pattern="([1-9])|([1-9][0-9])" type="number" value="{{ $item->quantity() }}" required/>
            <button class="btn btn-light qty-btn btn-plus"
                    @if($item->quantity() == config('cart.item_max_quantity')) disabled @endif>
                <i class="fa fa-chevron-up"></i>
            </button>
        </form>
        @if(config('cart.unit', false) === true && $item->hasUnit())
            <small class="item-unit badge badge-light">{{ $item->unit }}</small>
        @endif
    </td>
    <td class="text-right item-price d-none d-xl-table-cell d-md-table-cell">
        {{ Cart::price_format($item->price) }}

    </td>
    <td class="text-right item-subtotal">
        {{ Cart::price_format($item->subtotal()) }}
    </td>
</tr>