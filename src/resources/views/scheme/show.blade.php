@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => $scheme->block->name,
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('schemes.index'), 'name' => __('site::scheme.schemes')],
            ['name' => $scheme->block->name]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        @alert()@endalert
        <div class="card mb-2">
            <div class="card-body d-flex align-items-stretch">
                <div class="d-inline-block" style="width:300px!important;">
                    <table id="block-elements" style="width:300px!important;"
                           class="table table-sm table-bordered table-hover">
                        <tbody>
                        @foreach($elements as $element)
                            <tr class="pointer table-pointer"
                                {{--onmouseleave="pointerLeave()"--}}
                                {{--onmouseover="pointerOver(this.dataset.number)"--}}
                                data-number="{{$element->number}}">
                                <td class="number">{{$element->number}}</td>
                                <td class="">{{$element->product->sku}}</td>
                                <td>
                                    <a href="{{route('products.show', $element->product)}}">
                                        {{str_limit($element->product->name, 22)}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
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
                                      {{--onmouseleave="pointerLeave()"--}}
                                      {{--onmouseover="pointerOver(this.dataset.number)"--}}
                                      shape="{{$shape->shape}}"
                                      coords="{{$shape->coords}}"
                                      data-maphilight='{"strokeColor":"ed9068","strokeWidth":2,"fillColor":"ed9068","fillOpacity":0.3}'/>
                            @endforeach
                        @endforeach
                    </map>
                    @foreach($elements as $element)
                        @foreach($element->pointers as $pointer)
                            <a class="pointer img-pointer"
                               data-number="{{$element->number}}"
                               {{--onmouseleave="pointerLeave()"--}}
                               {{--onmouseover="pointerOver(this.dataset.number)"--}}
                               style="top:{{$pointer->y}}px;left:{{$pointer->x}}px"
                               href="#">{{$pointer->element->number}}</a>
                        @endforeach
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection