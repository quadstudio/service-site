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
                        @if($product->images()->count() > 1)
                            <ol class="carousel-indicators">
                                @foreach($product->images as $key => $image)
                                    <li data-target="#carouselEquipmentIndicators" data-slide-to="{{$key}}"
                                        @if($key == 0) class="active" @endif></li>
                                @endforeach
                            </ol>
                        @endif
                        <div class="carousel-inner">
                            @foreach($product->images as $key => $image)
                                <div class="carousel-item @if($key == 0) active @endif">
                                    <img class="d-block w-100"
                                         src="{{ Storage::disk($image->storage)->url($image->path) }}"
                                         alt="{{$product->name}}">
                                </div>
                            @endforeach

                        </div>
                        @if($product->images()->count() > 1)
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


                    <div class="media-body col-sm-9 p-md-5 px-4 pt-5 pb-4">
                        <h1>{!! $product->name!!}</h1>

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
                        <dl class="row">
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
                                <dt class="col-sm-4">{{ $product->price()->type->display_name ?: __('site::price.price')}}</dt>
                                <dd class="col-sm-8 h2">{{ $product->price()->format() }}</dd>
                            @endif
                            @auth
                            @can('buy', $product)
                                <dt class="col-sm-4"></dt>
                                <dd class="col-sm-8">
                                    @include('site::cart.buy.large', $product->toCart())
                                </dd>
                            @endcan
                            @endauth
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
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab"
                           aria-controls="description" aria-selected="true">Описание</a>
                    </li>
                    @if($equipments->isNotEmpty())
                        <li class="nav-item">
                            <a class="nav-link" id="relation-tab" data-toggle="tab" href="#relation" role="tab"
                               aria-controls="relation" aria-selected="false">Подходит к <span
                                        class="badge badge-secondary">{{$product->back_relations()->count()}}</span></a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" id="analog-tab" data-toggle="tab" href="#analog" role="tab"
                           aria-controls="analog" aria-selected="false">Аналоги <span
                                    class="badge badge-secondary">{{$product->analogs()->whereEnabled(1)->count()}}</span></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="description" role="tabpanel"
                         aria-labelledby="home-tab">
                        <p>Элементы политического процесса, превозмогая сложившуюся непростую экономическую ситуацию,
                            рассмотрены исключительно в разрезе маркетинговых и финансовых предпосылок. Идейные
                            соображения высшего порядка, а также понимание сути ресурсосберегающих технологий
                            способствует повышению качества распределения внутренних резервов и ресурсов. Лишь
                            стремящиеся вытеснить традиционное производство, нанотехнологии формируют глобальную
                            экономическую сеть и при этом - объединены в целые кластеры себе подобных.</p>
                        <p>Безусловно, экономическая повестка сегодняшнего дня напрямую зависит от позиций, занимаемых
                            участниками в отношении поставленных задач. Современные технологии достигли такого уровня,
                            что современная методология разработки играет важную роль в формировании позиций, занимаемых
                            участниками в отношении поставленных задач.</p>
                    </div>
                    @if($equipments->isNotEmpty())
                        <div class="tab-pane fade p-3" id="relation" role="tabpanel" aria-labelledby="relation-tab">
                            <table class="table">
                                <tbody>
                                @foreach($equipments as $equipment)
                                    <tr>
                                        <td>
                                            <a class="d-block text-large"
                                               href="{{route('equipments.show', $equipment)}}">{!! $equipment->name !!}</a>
                                        </td>
                                        <td>
                                            @foreach($product->back_relations()->orderBy('name')->get() as $relation)
                                                @if($relation->equipment_id == $equipment->id)
                                                    <a class="d-block"
                                                       href="{{route('products.show', $relation)}}">{!! $relation->name !!}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="tab-pane fade p-3" id="analog" role="tabpanel" aria-labelledby="analog-tab">
                        @if($product->analogs()->count() > 0)
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('site::product.name')</th>
                                    <th scope="col">@lang('site::product.sku')</th>
                                    <th scope="col">@lang('site::product.brand_id')</th>
                                    <th scope="col">@lang('site::product.quantity')</th>
                                    <th scope="col">@lang('site::price.price')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product->analogs()->where('enabled', 1)->orderBy('name')->get() as $analog)
                                    <tr>
                                        <td>
                                            <a href="{{route('products.show', $analog)}}"
                                               class="">{{$analog->name}}</a>
                                        </td>
                                        <td>{{$analog->sku}}</td>
                                        <td>{!! $analog->brand->name !!}</td>
                                        <td>
                                            @if($analog->quantity > 0)
                                                <span class="badge badge-success d-block d-md-inline-block">@lang('site::product.in_stock')</span>
                                            @else
                                                <span class="badge badge-light d-block d-md-inline-block">@lang('site::product.not_available')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($analog->price()->exists)
                                                {{ $analog->price()->format() }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
