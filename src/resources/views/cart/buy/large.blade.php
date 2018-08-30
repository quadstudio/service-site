@extends('site::cart.buy.button')
@section('button')
    <div class="input-group">
        <input name="quantity"
               type="number"
               min="1"
               max="{{config('cart.item_max_quantity')}}"
               class="form-control"
               value="1"
               placeholder="@lang('site::cart.quantity')">
        <div class="input-group-append">
            <button type="submit" class="add-to-cart btn btn-ferroli">
                <i class="fa fa-shopping-cart"></i>
                <span class="d-none d-sm-inline-block">@lang('site::cart.to_cart')</span>
            </button>
        </div>
    </div>
@endsection