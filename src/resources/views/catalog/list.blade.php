@extends('layouts.app')
@section('title'){!! $catalog->name_plural !!}@lang('site::messages.title_separator')@endsection
@push('styles')
<style type="text/css">
    #product-row .product-col {
        border: 1px solid #f9f9f9;
    }

    #product-row .product-col:hover {
        border: 1px solid #FFECB3;
        background-color: #fcf3d8;
    }
</style>
@endpush
@section('header')
    @include('site::header.front',[
        'h1' => $catalog->name_plural. ' '.__('site::catalog.view.list'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('catalogs.index'), 'name' => __('site::catalog.catalogs'). ' '.__('site::catalog.view.list')],
            ['name' => $catalog->name_plural]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        @can('equipment_list', Auth::user())
            <div class=" border p-3 mb-2">
                <a href="{{route('catalogs.show', $catalog)}}" class="d-block d-sm-inline btn btn-ferroli">
                    <i class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::messages.show') @lang('site::catalog.view.grid')
                </a>
            </div>
        @endcan
        <div class="row mt-2 mb-4" id="product-row">
            @include('site::catalog.list.children', ['catalog' => $catalog])
        </div>
    </div>
@endsection
