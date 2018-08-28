@extends('site::cart.buy.button')
@section('button')
    <div class="input-group input-sm" style="width:112px!important;">
        <input name="quantity"
               type="number"
               min="1"
               max="{{config('cart.item_max_quantity')}}"
               class="form-control"
               value="1"
               placeholder="@lang('site::cart.quantity')"
               aria-label="@lang('site::cart.quantity')"
               aria-describedby="to-cart-btn-{{ $product_id }}">
        <div class="input-group-append">
            <button type="submit" id="to-cart-btn-{{ $product_id }}"
                    class="add-to-cart btn-sm btn btn-ferroli">
                <i class="fa fa-shopping-cart"></i>
            </button>
        </div>
    </div>
@endsection