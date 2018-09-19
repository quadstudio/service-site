@extends('layouts.app')

@section('header')
    @include('site::header.front',[
        'h1' => $scheme->block->name. ' '.$product->name,
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            $url,
            ['name' => $scheme->block->name],
        ]
    ])
@endsection

@section('content')
    <div class="container">
        @alert()@endalert
        @foreach($datasheets as $datasheet)
            <ul class="nav nav-pills nav-fill">
                @foreach($datasheet->schemes as $datasheet_scheme)
                    <li class="nav-item">
                        <a class="nav-link mx-1 @if($datasheet_scheme->id == $scheme->id) bg-ferroli text-white @else bg-light @endif"
                           href="{{route('products.scheme', [$product, $datasheet_scheme])}}">{{$datasheet_scheme->block->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endforeach
        <div class="card mb-2 mt-4">
            <div class="card-body d-flex align-items-start">
                <nav class="nav nav-fill flex-column" style="width:300px!important;">

                    <div class="nav-item">
                        <b>Период производства</b>
                        <ul class="mb-2 nav bg-light nav-pills nav-fill">
                            @foreach($datasheets as $datasheet)
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{route('products.scheme', [$product, $datasheet->schemes()->where('block_id', $scheme->block_id)->first()])}}">
                                        @include('site::datasheet.date')
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <table id="block-elements" style="width:300px!important;"
                               class="table m-0 table-sm table-bordered table-hover">
                            <tbody>
                            @foreach($elements as $element)
                                <tr class="pointer table-pointer"
                                    data-number="{{$element->number}}">
                                    <td class="number">{{$element->number}}</td>
                                    <td class="">{{$element->product->sku}}</td>
                                    <td>
                                        @if($element->product->canBuy)
                                            <a href="{{route('products.show', $element->product)}}">
                                                {{str_limit($element->product->name, 22)}}
                                            </a>
                                        @else
                                            <span class="text-muted">{{str_limit($element->product->name, 22)}}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </nav>
                <div class="scheme content d-inline-block p-0" style="position:relative;">
                    <canvas class="scheme" height="1040" width="740"
                            style="position:absolute;left:0;top:0;padding:0;border:none;opacity:1;"></canvas>
                    <img class="map" usemap="#map"
                         style=" position: absolute; left: 0; top: 0; padding: 0; border: 0;"
                         src="{{$scheme->image->src()}}">
                    <map name="map">
                        @foreach($elements as $element)
                            @foreach($element->shapes as $shape)
                                <area data-number="{{$element->number}}"
                                      class="shape-pointer"
                                      shape="{{$shape->shape}}"
                                      coords="{{$shape->coords}}"
                                      data-maphilight='{"strokeColor":"428bca","strokeWidth":2,"fillColor":"428bca","fillOpacity":0.3}'/>
                            @endforeach
                        @endforeach
                    </map>
                    @foreach($elements as $element)
                        @foreach($element->pointers as $pointer)
                            <a class="pointer img-pointer"
                               data-number="{{$element->number}}"
                               style="top:{{$pointer->y}}px;left:{{$pointer->x}}px"
                               href="@if($element->product->canBuy) {{route('products.show', $element->product)}} @else javascript:void(0); @endif">{{$pointer->element->number}}</a>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection