@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => $equipment->catalog->parentRoot()->name. ' '.$equipment->name,
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('catalogs.index'), 'name' => __('site::catalog.catalogs')],
            ['url' => route('catalogs.show', $equipment->catalog->parentRoot()),'name' => $equipment->catalog->parentRoot()->name_plural],
            ['name' => $equipment->name]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <div class="media flex-wrap flex-lg-nowrap">
                    <div id="carouselEquipmentIndicators" class="carousel slide col-12 col-md-3 col-lg-4 p-0"
                         data-ride="carousel">
                        @if($equipment->images()->count() > 1)
                            <ol class="carousel-indicators">
                                @foreach($equipment->images as $key => $image)
                                    <li data-target="#carouselEquipmentIndicators" data-slide-to="{{$key}}"
                                        @if($key == 0) class="active" @endif></li>
                                @endforeach
                            </ol>
                        @endif
                        <div class="carousel-inner">
                            @foreach($equipment->images as $key => $image)
                                <div class="carousel-item @if($key == 0) active @endif">
                                    <img class="d-block w-100"
                                         src="{{ Storage::disk($image->storage)->url($image->path) }}"
                                         alt="{{$equipment->name}}">
                                </div>
                            @endforeach

                        </div>
                        @if($equipment->images()->count() > 1)
                            <a class="carousel-control-prev" href="#carouselEquipmentIndicators" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon dark" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselEquipmentIndicators" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon dark" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        @endif
                    </div>
                    <div class="media-body p-md-5 px-4 pt-5 pb-4 col-md-9 col-lg-8">

                        <h3>{{$equipment->catalog->parentTreeName()}} {{$equipment->name}}</h3>
                        <p>{!! $equipment->annotation !!}</p>
                        {{--<div class="mb-4">--}}
                        {{--<div class="ui-stars text-big">--}}
                        {{--<div class="d-inline-block">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--</div>--}}
                        {{--<div class="d-inline-block">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--</div>--}}
                        {{--<div class="d-inline-block">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--</div>--}}
                        {{--<div class="d-inline-block">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--</div>--}}
                        {{--<div class="d-inline-block filled">--}}
                        {{--<i class="fa fa-star-half-full"></i>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        {{--<a href="javascript:void(0)" class="text-muted small">23 отзыва</a>--}}
                        {{--</div>--}}

                    </div>
                </div>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="equipments-tab" data-toggle="tab" href="#equipments" role="tab"
                           aria-controls="equipments" aria-selected="true">@lang('site::equipment.equipments')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab"
                           aria-controls="description" aria-selected="true">Описание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="spec-tab" data-toggle="tab" href="#spec" role="tab" aria-controls="spec"
                           aria-selected="false">Характеристики</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab"
                           aria-controls="products" aria-selected="false">@lang('site::product.products')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="datasheet-tab" data-toggle="tab" href="#datasheet" role="tab"
                           aria-controls="datasheet" aria-selected="false">@lang('site::datasheet.datasheets')</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active p-3"
                         id="equipments"
                         role="tabpanel"
                         aria-labelledby="equipments-tab">
                        @foreach($equipment->products()->where('enabled', 1)->orderBy('name')->get() as $product)
                            <div class="row border-bottom py-1">
                                <div class="col-12 col-md-6">
                                    <a class="d-block text-large"
                                       href="{{route('products.show', $product)}}">{{$product->name}}</a>
                                </div>
                                <div class="col-12 col-md-3 mb-2 mb-md-0">
                                    @if($product->hasPrice)
                                        <div class="text-tiny text-muted">{{ $product->price()->type->display_name ?: __('site::price.price')}}</div>
                                        <div class="text-large">{{ $product->price()->format() }}</div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-3">
                                    @can('buy', $product)
                                        @include('site::cart.buy.large', $product->toCart())
                                    @endcan
                                </div>
                            </div>

                        @endforeach
                    </div>
                    <div class="tab-pane fade p-3"
                         id="description"
                         role="tabpanel"
                         aria-labelledby="home-tab">{!!$equipment->description!!}</div>
                    <div class="tab-pane fade p-3"
                         id="spec"
                         role="tabpanel"
                         aria-labelledby="spec-tab">...
                    </div>
                    <div class="tab-pane fade p-3"
                         id="products"
                         role="tabpanel"
                         aria-labelledby="products-tab">

                        @foreach($products as $product)
                            <div class="row py-1 border-bottom">
                                <div class="col-sm-6">
                                    <span>@lang('site::product.products') {!! $product->name !!}</span>
                                </div>
                                <div class="col-sm-6 text-left text-sm-right">
                                    <a class="btn btn-sm btn-ferroli"
                                       href="{{route('products.index', ['filter[boiler_id]' => $product->id])}}">
                                        @lang('site::messages.show') <span
                                                class="badge badge-light">{{$product->relations()->whereEnabled(1)->whereActive(1)->count()}}</span></a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="tab-pane fade p-3"
                         id="datasheet"
                         role="tabpanel"
                         aria-labelledby="datasheet-tab">...

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
