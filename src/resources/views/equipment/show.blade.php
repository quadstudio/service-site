@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => $equipment->name,
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
                    <div id="carouselEquipmentIndicators" class="carousel slide col-12 col-lg-5 p-0"
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


                    <div class="media-body p-md-5 px-4 pt-5 pb-4">

                        <h3>{{$equipment->catalog->parentTreeName()}} {{$equipment->name}}</h3>

                        <div class="mb-4">
                            <div class="ui-stars text-big">
                                <div class="d-inline-block">
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="d-inline-block">
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="d-inline-block">
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="d-inline-block">
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="d-inline-block filled">
                                    <i class="fa fa-star-half-full"></i>
                                </div>
                            </div>

                            <a href="javascript:void(0)" class="text-muted small">23 отзыва</a>
                        </div>
                        @if(!$equipment->products->isEmpty())
                            <h5 class="mt-4">@lang('site::equipment.equipments')</h5>

                            <table class="table table-hover mt-1">
                                <tbody>
                                @foreach($equipment->products()->where('enabled', 1)->orderBy('name')->get() as $product)
                                    <tr>
                                        <td class="p-1">{{$product->name}}</td>
                                        <td class="p-1"><a href="#">@lang('site::product.products')</a></td>
                                        <td class="p-1">
                                            @if(!$product->datasheets()->where('active', 1)->get()->isEmpty())
                                                <a href="#">@lang('site::datasheet.datasheets')</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab"
                           aria-controls="description" aria-selected="true">Описание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="spec-tab" data-toggle="tab" href="#spec" role="tab" aria-controls="spec"
                           aria-selected="false">Характеристики</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="parts-tab" data-toggle="tab" href="#parts" role="tab"
                           aria-controls="parts" aria-selected="false">@lang('site::product.products')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="datasheet-tab" data-toggle="tab" href="#datasheet" role="tab"
                           aria-controls="datasheet" aria-selected="false">@lang('site::datasheet.datasheets')</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="description" role="tabpanel"
                         aria-labelledby="home-tab">{!!$equipment->description!!}</div>
                    <div class="tab-pane fade p-3" id="spec" role="tabpanel" aria-labelledby="spec-tab">...</div>
                    <div class="tab-pane fade p-3" id="parts" role="tabpanel" aria-labelledby="parts-tab">...</div>
                    <div class="tab-pane fade p-3" id="datasheet" role="tabpanel" aria-labelledby="datasheet-tab">...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
