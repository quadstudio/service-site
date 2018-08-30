@extends('layouts.app')
@push('styles')
<style type="text/css">
    #product-row.row.grid .product-col,
    #product-row.row.list .product-col {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
        border: 1px solid #f9f9f9;
    }

    #product-row.row .product-col:hover {
        border: 1px solid #FFECB3;
        background-color: #fcf3d8;
    }

    #product-row.row .product-col .product-image,
    #product-row.row .product-col .product-content {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }

    #product-row.row.grid .product-content {
        text-align: center;
    }

    #product-row.row.list .product-content {
        text-align: left;

    }

    #product-row.row .product-relations {
        display: none;
    }

    #product-row.row.list .product-content .product-name {
        width: 74%;
        display: inline-block;
    }

    #product-row.row.list .product-content .product-cart {
        text-align: right;
        display: inline-block;
        width: 24%;
    }

    @media (min-width: 576px) {

        #product-row.row.list .product-relations {
            display: block;
        }

        #product-row.row.grid .product-col {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        #product-row.row.grid .product-col .product-image,
        #product-row.row.grid .product-col .product-content {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        #product-row.row.list .product-col .product-image {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        #product-row.row.list .product-col .product-content {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }
    }

    @media (min-width: 768px) {
        #product-row.row.grid .product-col {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.33333333%;
            flex: 0 0 33.33333333%;
            max-width: 33.33333333%;
        }

        #product-row.row.list .product-col .product-image {
            -ms-flex: 0 0 20%;
            flex: 0 0 20%;
            max-width: 20%;
        }
    }

    @media (max-width: 992px) {

        #product-row.row.list .product-content .product-name,
        #product-row.row.list .product-content .product-cart {
            width: 100%;
            display: block;
        }
    }

    @media (min-width: 1200px) {
        #product-row.row.grid .product-col {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        #product-row.row.list .product-col .product-image {
            -ms-flex: 0 0 22.7%;
            flex: 0 0 22.7%;
            max-width: 22.7%;
        }

        #product-row.row.list .product-col .product-content {
            -ms-flex: 0 0 77.3%;
            flex: 0 0 77.3%;
            max-width: 77.3%;
        }

    }
</style>
@endpush
@section('header')
    @include('site::header.front',[
        'h1' => __('site::product.products'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::product.products')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        @can('product_list', Auth::user())
            <div class=" border p-3 mb-2">
                <a href="{{route('products.list')}}" class="d-block d-sm-inline btn btn-ferroli">
                    <i class="fa fa-list-alt"></i> @lang('site::messages.show') @lang('site::product.view.list')
                </a>
            </div>
        @endcan
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $products])@endpagination
        {{$products->render()}}
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-ferroli active" onclick="gridView()">
                <input type="radio"
                       name="options" id="option2" autocomplete="off" checked>
                <i class="fa fa-th-large"></i> Таблица
            </label>
            <label class="btn btn-ferroli" onclick="listView()">
                <input type="radio"
                       name="options" id="option1" autocomplete="off">
                <i class="fa fa-bars"></i> Список
            </label>
        </div>
        <div id="product-row" class="row grid">
            @foreach($products as $key => $product)
                <div class="product-col mt-3">
                    <div class="row p-2 mx-2">

                        <div class="product-image">
                            <a href="{{route('products.show', $product)}}">
                                <img class="img-fluid" src="{{ $product->image()->src() }}" alt="{{$product->name}}">
                            </a>
                        </div>

                        <div class="product-content pl-2 pl-sm-0 pt-sm-2">
                            <div class="product-name">
                                <a class="text-dark"
                                   href="{{route('products.show', $product)}}">{!! str_limit($product->name, 60) !!}</a>
                                <div class="text-muted mb-2">@lang('site::product.sku')
                                    : {{$product->sku}}</div>
                                <div class="product-relations">
                                    @if( $product->relation_equipments()->count() > 0)
                                        @lang('site::relation.header.back_relations')
                                        : {{ $product->relation_equipments()->implode('name', ', ') }}
                                    @endif
                                </div>
                            </div>
                            <div class="product-cart">
                                @if($product->hasPrice)

                                    <div class="product-price font-weight-bold text-xlarge mt-3">{{ Site::format($product->price->value) }}</div>
                                    <span class="d-block text-muted mb-3">{{ $product->price->type->display_name ?: __('site::price.price')}}</span>
                                @endif
                                @include('site::cart.buy.large')
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{--@each('site::product.grid', $items, 'product', 'site::product.empty')--}}
        </div>
        {{$products->render()}}
    </div>
@endsection
@push('scripts')
<script type="text/javascript">

    let product_row = document.getElementById("product-row");

    // List View
    function listView() {

        product_row.classList.remove("grid");
        product_row.classList.add("list");
    }

    // Grid View
    function gridView() {
        product_row.classList.remove("list");
        product_row.classList.add("grid");
    }
</script>
@endpush