@extends('layouts.app')
@section('title'){!! $equipment->title ?: $equipment->catalog->parentRoot()->name. ' '.$equipment->name !!} @lang('site::messages.title_separator')@endsection
@section('description'){!! $equipment->metadescription ?: $equipment->catalog->parentRoot()->name. ' '.$equipment->name !!}@endsection
@section('header')
    @include('site::header.front',[
        'h1' => '',
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
                                         src="{{ $image->src() }}"
                                         alt="{{$equipment->name}}">
                                </div>
                            @endforeach

                        </div>
                        @if($equipment->images()->count() > 1)
                            <a class="carousel-control-prev" href="#carouselEquipmentIndicators" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon dark" aria-hidden="true"></span>
                                <span class="sr-only">@lang('site::messages.prev')</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselEquipmentIndicators" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon dark" aria-hidden="true"></span>
                                <span class="sr-only">@lang('site::messages.next')</span>
                            </a>
                        @endif
                    </div>
                    <div class="media-body p-md-5 px-4 pt-5 pb-4 col-md-9 col-lg-8">

                        <h1>{!! $equipment->h1 ?: $equipment->catalog->parentRoot()->name. ' '.$equipment->name !!}</h1>
                        @admin()
                        <p>
                            <a href="{{route('admin.equipments.show', $equipment)}}">
                                <i class="fa fa-folder-open"></i>
                                @lang('site::messages.open') @lang('site::messages.in_admin')
                            </a>
                        </p>
                        @endadmin()
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
                           aria-controls="description" aria-selected="true">@lang('site::equipment.description')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="specification-tab" data-toggle="tab" href="#specification" role="tab"
                           aria-controls="specification"
                           aria-selected="false">@lang('site::equipment.specification')</a>
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
                        @foreach($equipment->products()->where('enabled', 1)->where('active', 1)->orderBy('name')->get() as $product)
                            <div class="row border-bottom py-2">
                                <div class="col-12 col-md-6">
                                    <a class="d-block text-large"
                                       href="{{route('products.show', $product)}}">{{$product->name}}</a>
                                </div>
                                <div class="col-12 col-md-3 mb-2 mb-md-0">
                                    @if($product->hasPrice)
                                        <div class="text-tiny text-muted">{{ $product->price->type->display_name ?: __('site::price.price')}}</div>
                                        <div class="text-large">{{ Site::format($product->price->value) }}</div>
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
                    <div class="tab-pane fade p-3" id="description" role="tabpanel"
                         aria-labelledby="home-tab">{!!$equipment->description!!}</div>
                    <div class="tab-pane fade p-3" id="specification" role="tabpanel"
                         aria-labelledby="specification-tab">{!! $equipment->specification !!}</div>
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
                    <div class="tab-pane fade p-3" id="datasheet" role="tabpanel" aria-labelledby="datasheet-tab">
                      
                            @foreach($datasheets as $datasheet)
                                <div class="card item-hover mb-1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a class="text-large mb-1"
                                                   href="{{ route('datasheets.show', $datasheet) }}">{{ $datasheet->name ?: $datasheet->file->name }}</a>
                                                {{--<span class="text-lighter d-block">{{ $datasheet->name }}</span>--}}
                                                <span class="text-muted d-block">@include('site::datasheet.date')</span>
												@if(!($products = $datasheet->products()->where('enabled', 1)->orderBy('equipment_id')->orderBy('name')->get())->isEmpty())
													@include('site::datasheet.index.row.products')
												@endif
                                            </div>

                                        <div class="col-sm-3 text-right">
                                                @if($datasheet->schemes()->count() > 0)
                                                @if($products->count() > 1)
													@if($products->isNotEmpty())
														<div class="dropdown">
															<a class="btn btn-ferroli dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																@lang('site::scheme.schemes') ({{$products->count() }})
															</a>

															<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
																@foreach($products as $product)
																<a class="dropdown-item" href="{{route('products.scheme', [$product, $datasheet->schemes()->first()])}}">{!! $product->name !!}</a>
																@endforeach
															</div>
														</div>
													@endif

                                                                                               
												@else
												
												<a class="btn btn-ferroli"
                                                   href="{{route('products.scheme', [$product, $datasheet->schemes()->first()])}}">@lang('site::messages.open') @lang('site::scheme.scheme')</a>
                                                @endif 
												@endif
                                            </div>
                                            <div class="col-sm-3 text-right">
                                                @include('site::file.download', ['file' => $datasheet->file])
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                      
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
