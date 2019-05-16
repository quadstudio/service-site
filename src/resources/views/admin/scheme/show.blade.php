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
            <li class="breadcrumb-item active">{{ $scheme->block->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $scheme->block->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.schemes.edit', $scheme) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::scheme.scheme')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.schemes.elements', $scheme) }}"
               role="button">
                <i class="fa fa-@lang('site::element.icon')"></i>
                <span>@lang('site::element.elements')</span>
                <span class="badge badge-light">{{$scheme->elements()->count()}}</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline-block @if($scheme->elements()->doesntExist()) disabled @endif mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.schemes.pointers', $scheme) }}"
               role="button">
                <i class="fa fa-@lang('site::pointer.icon')"></i>
                <span>@lang('site::pointer.pointers')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline-block @if($scheme->elements()->doesntExist()) disabled @endif mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.schemes.shapes', $scheme) }}"
               role="button">
                <i class="fa fa-@lang('site::shape.icon')"></i>
                <span>@lang('site::shape.shapes')</span>
            </a>
            <button type="submit" form="scheme-delete-form-{{$scheme->id}}"
                    class="btn btn-danger d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i> <span class="d-none d-sm-inline-block">@lang('site::messages.delete')</span>
            </button>
            <a href="{{ route('admin.schemes.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            <form id="scheme-delete-form-{{$scheme->id}}"
                  action="{{route('admin.schemes.destroy', $scheme)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-fill mb-3">
                    @foreach($scheme->datasheet->schemes as $datasheet_scheme)
                        <li class="nav-item">
                            <a class="nav-link mx-1 @if($datasheet_scheme->id == $scheme->id) bg-ferroli text-white @else bg-light @endif"
                               href="{{route('admin.schemes.show', $datasheet_scheme)}}">{{$datasheet_scheme->block->name}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex align-items-start">
                    <nav class="nav nav-fill flex-column" style="width:300px!important;">
                        <div class="nav-item">
                            <table id="block-elements" style="width:300px!important;"
                                   class="table m-0 table-sm table-bordered table-hover">
                                <tbody data-target="{{route('admin.elements.sort')}}"
                                       id="sort-list">
                                {{--<div class="col-12 p-1 sort-item" data-id="{{$image->id}}" id="image-{{$image->id}}">--}}
                                @foreach($elements as $element)
                                    <tr class="sort-item pointer table-pointer"
                                        data-id="{{$element->id}}" data-number="{{$element->number}}">
                                        <td class="text-center"><i class="fa fa-arrows"></i></td>
                                        <td class="number">{{$element->number}}</td>
                                        <td class="">{{$element->product->sku}}</td>

                                        <td data-toggle="tooltip" data-placement="top"
                                            title="{{$element->product->name}}" class="text-left">
                                            {{str_limit($element->product->name, 18)}}
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
                        <div id="pointers">
                            @foreach($elements as $element)
                                @foreach($element->pointers as $pointer)
                                    @include('site::admin.scheme.pointers.row', ['pointer' => $pointer, 'element' => $element])
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection