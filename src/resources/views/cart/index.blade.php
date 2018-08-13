@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => __('site::cart.cart'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::cart.cart')]
        ]
    ])
@endsection
@section('content')
    <div class="container">

        @if(!Cart::isEmpty())

            <div class="row mb-3">
                <div class="col-12">
                    <table class="table">
                        <caption class="text-left">
                            @if(config('cart.shop_route') !== false)
                                <a class="btn btn-sm btn-warning" href="{{ route(config('cart.shop_route')) }}">
                                    <i class="fa fa-shopping-cart"></i> @lang('site::cart.add_form_cancel')</a>

                            @endif
                            <a class="btn btn-sm btn-warning" href="{{route('clearCart')}}">
                                <i class="fa fa-close"></i> @lang('site::cart.cart_clear')</a>
                        </caption>
                        <thead class="thead-light">
                        <tr>
                            <th class="text-left">@lang('site::cart.name')</th>
                            <th class="text-center">@lang('site::cart.quantity')</th>
                            <th class="text-right d-none d-xl-table-cell d-md-table-cell">@lang('site::cart.price')</th>
                            <th class="text-right">@lang('site::cart.subtotal')</th>
                        </tr>
                        </thead>
                        <tbody class="table-hover">
                        @each('site::cart.item.row', Cart::items(), 'item')
                        </tbody>
                    </table>
                    @include('site::cart.modal.delete')
                </div>
                <div class="col-12">
                    <form action="{{route(config('cart.checkout', 'orders.store'))}}" method="post">
                        @csrf
                        <div class="card text-center border-0">

                            <div class="card-body">

                                <div class="form-group text-right">
                                    <textarea placeholder="@lang('site::cart.order_comment')" class="form-control"
                                              name="message[text]"  rows="3"></textarea>
                                    <input type="hidden" name="message[receiver_id]" value="{{config('site.receiver_id')}}">
                                    <input type="hidden" name="status_id" value="1">
                                </div>
                                @if(config('cart.weight', false) === true)
                                    <h6 class="text-right">
                                        <span id="cart-weight">{{ Cart::weight_format() }}</span>
                                        <span id="cart-weight-unit">@lang('site::cart.weight_unit.' . (config('cart.weight_output')))</span>
                                    </h6>
                                @endif
                                <h5 class="text-right">@lang('site::cart.total'):</h5>
                                <h2 class="text-right">
                                    <span id="cart-total">{{ Cart::price_format(Cart::total()) }}</span>
                                </h2>
                            </div>
                            <div class="card-footer text-muted">
                                <button type="submit" class="btn btn-ferroli btn-lg ">
                                    <i class="fa fa-check"></i> @lang('site::cart.order_confirm')</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        @else
            <div class="row my-5">
                <div class="col text-center">

                    <div class="mb-3" style="transform: rotate(15deg);font-size: 2rem;">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <h1 class="font-weight-normal my-3">@lang('site::cart.cart_is_empty')</h1>
                    {{--<p>Add products to it. Check out our wide range of products!</p>--}}
                    @if(config('cart.shop_route') !== false)
                        <a href="{{ route(config('cart.shop_route')) }}" role="button" class="btn btn-ferroli">Перейти в каталог запчастей</a>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection