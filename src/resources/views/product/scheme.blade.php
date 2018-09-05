@extends('layouts.app')

@section('header')
    @include('site::header.front',[
        'h1' => $product->name. ' '.__('site::scheme.schemes'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('products.show', $product), 'name' => $product->name],
            ['url' => route('products.schemes', [$product, $scheme]), 'name' => __('site::scheme.schemes')],
            ['name' => $scheme->block->name],
        ]
    ])
@endsection

@section('content')
    <div class="container">
        @alert()@endalert

        <ul class="nav bg-light nav-pills nav-fill">
            @foreach($datasheets as $datasheet)
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        {{$datasheet->date_from}} - {{$datasheet->date_to}}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="card mb-2 mt-4">
            <div class="card-body d-flex align-items-start">
                <nav class="nav nav-fill flex-column" style="width:300px!important;">

                    @foreach($datasheet->schemes as $datasheet_scheme)
                        <a class="nav-link @if($datasheet_scheme->id == $scheme->id) bg-ferroli text-white @else border-bottom bg-light @endif"
                           href="{{route('products.scheme', [$product, $datasheet_scheme])}}">
                            {{$datasheet_scheme->block->name}}
                        </a>
                        @if($datasheet_scheme->id == $scheme->id)
                            <div class="nav-item">
                                <table id="block-elements" style="width:300px!important;"
                                       class="table m-0 table-sm table-bordered table-hover">
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
                        @endif
                    @endforeach
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
                                      {{--onmouseleave="pointerLeave()"--}}
                                      {{--onmouseover="pointerOver(this.dataset.number)"--}}
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
                               {{--onmouseleave="pointerLeave()"--}}
                               {{--onmouseover="pointerOver(this.dataset.number)"--}}
                               style="top:{{$pointer->y}}px;left:{{$pointer->x}}px"
                               href="#">{{$pointer->element->number}}</a>
                        @endforeach
                    @endforeach

                </div>`

            </div>
        </div>
    </div>
@endsection