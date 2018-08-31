@extends('layouts.app')
@push('styles')
<style type="text/css">
    #product-row .product-col {
        border: 1px solid #f9f9f9;
    }

    #product-row .product-col:hover {
        border: 1px solid #FFECB3;
        background-color: #fcf3d8;
    }
</style>
@endpush
@section('header')
    @include('site::header.front',[
        'h1' => __('site::product.products'). ' '. __('site::product.view.list'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::product.products'). ' '. __('site::product.view.list')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        @can('product_list', Auth::user())
            <div class=" border p-3 mb-2">
                <a href="{{route('products.index')}}" class="d-block d-sm-inline btn btn-ferroli">
                    <i class="fa fa-@lang('site::product.icon')"></i> @lang('site::messages.show') @lang('site::product.view.shop')
                </a>
            </div>
        @endcan
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $products])@endpagination
        {{$products->render()}}
        <div class="row mt-2 mb-4" id="product-row">
            @foreach($products as $key => $product)
                <div class="col-12 product-col">
                    @can('buy', $product)
                        <div class="d-inline-block mr-2">
                            @include('site::cart.buy.small', $product->toCart())
                        </div>
                    @endcan
                    <span class="width-20 mr-1">
                        <i data-toggle="tooltip"
                           data-placement="top"
                           title="@if($product->quantity > 0) @lang('site::product.in_stock') @else @lang('site::product.not_available') @endif"
                           class="fa fa-circle text-@if($product->quantity > 0) text-success @else text-light @endif"></i>
                    </span>
                    <span>{{$product->sku}}</span>
                    <a href="{{route('products.show', $product)}}">{!! $product->name !!}</a>
                        @if($product->hasPrice)
                            <span class="d-inline-block pull-right product-price font-weight-bold text-big">{{ Site::format($product->price->value) }}</span>
                        @endif
                </div>
            @endforeach
        </div>
        {{--<div id="product-row" class="row grid">--}}
        {{--@foreach($products as $key => $product)--}}
        {{--<div class="product-col mt-3">--}}
        {{--<div class="row p-2 mx-2">--}}

        {{--<div class="product-image">--}}
        {{--<a href="{{route('products.show', $product)}}">--}}
        {{--<img class="img-fluid" src="{{ $product->image()->src() }}" alt="{{$product->name}}">--}}
        {{--</a>--}}
        {{--</div>--}}

        {{--<div class="product-content pl-2 pl-sm-0 pt-sm-2">--}}
        {{--<div class="product-name">--}}
        {{--<a class="text-dark"--}}
        {{--href="{{route('products.show', $product)}}">{!! str_limit($product->name, 60) !!}</a>--}}
        {{--<div class="text-muted mb-2">@lang('site::product.sku')--}}
        {{--: {{$product->sku}}</div>--}}
        {{--<div class="product-relations">--}}
        {{--@if( $product->relation_equipments()->count() > 0)--}}
        {{--@lang('site::relation.header.back_relations')--}}
        {{--: {{ $product->relation_equipments()->implode('name', ', ') }}--}}
        {{--@endif--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="product-cart">--}}
        {{--@if($product->price()->exists)--}}
        {{--<div class="product-price font-weight-bold text-xlarge my-3">{{ $product->price()->format() }}</div>--}}
        {{--@endif--}}
        {{--@auth--}}
        {{--@if(Auth::user()->hasPermission('buy'))--}}
        {{--<div class="product-button">--}}
        {{--@include('site::cart.add', $product->toCart())--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--@endauth--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--@endforeach--}}
        {{--@each('site::product.grid', $items, 'product', 'site::product.empty')--}}
        {{--</div>--}}
        {{$products->render()}}
    </div>
@endsection