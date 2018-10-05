@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.schemes.index') }}">@lang('site::scheme.schemes')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.schemes.show', $scheme) }}">{{ $scheme->block->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::shape.shapes')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::shape.shapes')</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.schemes.pointers', $scheme) }}"
               role="button">
                <i class="fa fa-@lang('site::pointer.icon')"></i>
                <span>@lang('site::pointer.pointers')</span>
            </a>
            <a href="{{ route('admin.schemes.show', $scheme) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::scheme.help.back')</span>
            </a>
        </div>
        <form id="shape-create-form" class="mb-2"
              action="{{route('admin.shapes.store')}}"
              method="POST">
            @csrf
            <input type="hidden" id="shape" name="shape" value="">
        </form>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-fill mb-3">
                    @foreach($scheme->datasheet->schemes as $datasheet_scheme)
                        <li class="nav-item">
                            <a class="nav-link mx-1 @if($datasheet_scheme->id == $scheme->id) bg-ferroli text-white @else bg-light @endif"
                               href="{{route('admin.schemes.shapes', $datasheet_scheme)}}">{{$datasheet_scheme->block->name}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex align-items-start">
                    <nav class="nav nav-fill flex-column" style="width:300px!important;">
                        <div class="nav-item">

                            <div class="mb-2 text-left">
                                <div><span class="badge badge-dark">1</span> @lang('site::shape.help.element_id')</div>
                                <div><span class="badge badge-dark">2</span>
                                    @lang('site::shape.help.link')
                                    <a class="d-inline-block" target="_blank"
                                       href="http://summerstyle.github.com/summer/">@lang('site::shape.help.here')</a>
                                </div>
                                <div class="mb-2"><span
                                            class="badge badge-dark">3</span> @lang('site::shape.help.coords')</div>
                                <textarea form="shape-create-form"
                                          placeholder="@lang('site::shape.placeholder.coords')"
                                          rows="5"
                                          class="form-control w-100"
                                          name="coords"
                                          title=""></textarea>
                                <a href="javascript:void(0);"
                                   class="save-shape-button btn btn-sm btn-ferroli">@lang('site::messages.save')</a>
                            </div>
                            <table data-empty="@lang('site::shape.error.element_id')"
                                   data-scheme="{{$scheme->id}}"
                                   data-action="{{route('admin.shapes.create')}}"
                                   id="block-elements" style="width:300px!important;"
                                   class="table m-0 table-sm table-bordered table-hover">
                                <tbody>
                                @foreach($elements as $element)
                                    <tr class="pointer table-pointer"
                                        data-number="{{$element->number}}">
                                        <td class="number">{{$element->number}}</td>
                                        <td class="">{{$element->product->sku}}</td>

                                        <td class="text-left">
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                       id="element-{{$element->id}}"
                                                       name="element_id"
                                                       form="shape-create-form"
                                                       value="{{$element->id}}"
                                                       data-scheme="{{$element->scheme_id}}"
                                                       class="custom-control-input m-0">
                                                <label class="custom-control-label" for="element-{{$element->id}}">
                                                    {{str_limit($element->product->name, 18)}}
                                                </label>
                                            </div>
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
                            <div id="shapes">
                                @foreach($elements as $element)
                                    @foreach($element->shapes as $shape)
                                        @include('site::admin.scheme.shapes.row', ['shape' => $shape, 'element' => $element])
                                    @endforeach
                                @endforeach
                            </div>
                        </map>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
