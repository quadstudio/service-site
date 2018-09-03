@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => '',
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('products.index'), 'name' => __('site::product.products')],
            ['name' => $product->name],
        ]
    ])
@endsection
@section('content')
    <div class="container">
        <div class="card border-0 mb-3">
            <div class="card-body">
                <div class="media flex-wrap flex-lg-nowrap">

                    <div id="carouselEquipmentIndicators" class="carousel slide col-12 col-sm-3 col-lg-5 p-0"
                         data-ride="carousel">

                        <ol class="carousel-indicators">
                            @if($images->isNotEmpty())
                                @foreach($images as $key => $image)
                                    <li data-target="#carouselEquipmentIndicators" data-slide-to="{{$key}}"
                                        @if($key == 0) class="active" @endif></li>
                                @endforeach
                            @endif
                        </ol>
                        <div class="carousel-inner">
                            @if($images->isNotEmpty())
                                @foreach($images as $key => $image)
                                    <div class="carousel-item @if($key == 0) active @endif">
                                        <img class="d-block w-100"
                                             src="{{ Storage::disk($image->storage)->url($image->path) }}"
                                             alt="{{$product->name}}">
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <img class="d-block border w-100"
                                         src="{{ $product->image()->src() }}"
                                         alt="{{$product->name}}">
                                </div>
                            @endif

                        </div>
                        @if($images->count() > 1)
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


                    <div class="row">
                        <div class="media-body col-sm-9 pl-md-5 px-4 pb-4">
                            <h1>{!! $product->name!!}</h1>

                            <dl class="row">

                                @admin()
                                <dd class="col-sm-12"><a href="{{route('admin.products.show', $product)}}"><i class="fa fa-folder-open"></i> @lang('site::messages.open') @lang('site::messages.in_admin')</a></dd>
                                @endadmin()

                                <dt class="col-sm-4">@lang('site::product.sku')</dt>
                                <dd class="col-sm-8">{{$product->sku}}</dd>

                                <dt class="col-sm-4">@lang('site::product.brand_id')</dt>
                                <dd class="col-sm-8">{!! $product->brand->name !!}</dd>

                                <dt class="col-sm-4">@lang('site::product.type_id')</dt>
                                <dd class="col-sm-8">{{$product->type->name}}</dd>

                                <dt class="col-sm-4">@lang('site::product.quantity')</dt>
                                <dd class="col-sm-8">
                                    @if($product->quantity > 0)
                                        <span class="badge badge-success d-block d-md-inline-block">@lang('site::product.in_stock')</span>
                                    @else
                                        <span class="badge badge-light d-block d-md-inline-block">@lang('site::product.not_available')</span>
                                    @endif
                                </dd>

                                @if($product->hasPrice)
                                    <dt class="col-sm-4">{{ $product->price->type->display_name ?: __('site::price.price')}}</dt>
                                    <dd class="col-sm-8 h2">{{ Site::format($product->price->value) }}</dd>
                                @endif
                                <dt class="col-sm-4"></dt>
                                <dd class="col-sm-8">
                                    @include('site::cart.buy.large')
                                </dd>

                            </dl>
                            {{--@if(!$equipment->products->isEmpty())--}}
                            {{--<h5 class="mt-4">Оборудование</h5>--}}

                            {{--<ul class="list-group mt-1">--}}
                            {{--@foreach($equipment->products as $product)--}}
                            {{--<li class="list-group-item p-1 border-bottom">{{$product->name}}</li>--}}
                            {{--@endforeach--}}
                            {{--</ul>--}}
                            {{--@endif--}}
                        </div>
                    </div>

                </div>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab"
                           aria-controls="description" aria-selected="true">
                            @lang('site::product.description')
                        </a>
                    </li>
                    @if($equipments->isNotEmpty())
                        <li class="nav-item">
                            <a class="nav-link" id="back-relation-tab" data-toggle="tab" href="#back-relation"
                               role="tab"
                               aria-controls="back-relation"
                               aria-selected="false">@lang('site::relation.header.back_relations')
                                <span class="badge badge-secondary">
                                    {{$back_relations->count()}}
                                </span>
                            </a>
                        </li>
                    @endif
                    @if($relations->isNotEmpty())
                        <li class="nav-item">
                            <a class="nav-link" id="relation-tab" data-toggle="tab" href="#relation" role="tab"
                               aria-controls="relation" aria-selected="false">@lang('site::relation.header.relations')
                                <span class="badge badge-secondary">
                                {{$relations->count()}}
                            </span>
                            </a>
                        </li>
                    @endif
                    @if($analogs->isNotEmpty())
                        <li class="nav-item">
                            <a class="nav-link" id="analog-tab" data-toggle="tab" href="#analog" role="tab"
                               aria-controls="analog" aria-selected="false">@lang('site::analog.analogs')
                                <span class="badge badge-secondary">
                                {{$analogs->count()}}
                            </span>
                            </a>
                        </li>
                    @endif

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="description" role="tabpanel"
                         aria-labelledby="home-tab">{!! $product->description !!}
                    </div>
                    @if($equipments->isNotEmpty())
                        <div class="tab-pane fade p-3" id="back-relation" role="tabpanel"
                             aria-labelledby="back-relation-tab">
                            <table class="table">
                                <tbody>
                                @foreach($equipments as $equipment)
                                    <tr>
                                        <td>
                                            <a class="d-block text-large"
                                               href="{{route('equipments.show', $equipment)}}">{!! $equipment->name !!}</a>
                                        </td>
                                        <td>
                                            @foreach($back_relations as $back_relation)
                                                @if($back_relation->equipment_id == $equipment->id)
                                                    <a class="d-block"
                                                       href="{{route('products.show', $back_relation)}}">{!! $back_relation->name !!}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($relations->isNotEmpty())
                        <div class="tab-pane fade p-3" id="relation" role="tabpanel" aria-labelledby="relation-tab">
                            @foreach($relations as $relation)
                                <div class="row border-bottom p-1">
                                    <div class="col-sm-8">
                                        <span>{{$relation->sku}}</span>
                                        <a href="{{route('products.show', $relation)}}">{!! $relation->name !!}</a>
                                    </div>
                                    <div class="col-sm-2">
                                        @if($relation->quantity > 0)
                                            <span class="badge badge-success d-block d-md-inline-block">@lang('site::product.in_stock')</span>
                                        @else
                                            <span class="badge badge-light d-block d-md-inline-block">@lang('site::product.not_available')</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-2 text-left text-sm-right">
                                        @if($relation->hasPrice)
                                            {{ Site::format($relation->price->value) }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($analogs->isNotEmpty())
                        <div class="tab-pane fade p-3" id="analog" role="tabpanel" aria-labelledby="analog-tab">

                            @foreach($analogs as $analog)
                                <div class="row border-bottom p-1">
                                    <div class="col-sm-8">
                                        <span>{{$analog->sku}}</span>
                                        <a href="{{route('products.show', $analog)}}">{!! $analog->name !!}</a>
                                    </div>
                                    <div class="col-sm-2">
                                        @if($analog->quantity > 0)
                                            <span class="badge badge-success d-block d-md-inline-block">@lang('site::product.in_stock')</span>
                                        @else
                                            <span class="badge badge-light d-block d-md-inline-block">@lang('site::product.not_available')</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-2 text-left text-sm-right">
                                        @if($analog->hasPrice)
                                            {{ Site::format($analog->price->value) }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
