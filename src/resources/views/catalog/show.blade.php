@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => $catalog->name_plural,
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('catalogs.index'), 'name' => __('site::catalog.catalogs')],
            ['name' => $catalog->name_plural]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        @can('equipment_list', Auth::user())
            <div class=" border p-3 mb-2">
                <a href="{{route('catalogs.list', $catalog)}}" class="d-block d-sm-inline btn btn-ferroli">
                    <i class="fa fa-list-alt"></i> @lang('site::messages.show') @lang('site::catalog.view.list')
                </a>
            </div>
        @endcan
        @include('site::catalog.show.children', ['catalog' => $catalog])
    </div>
@endsection
