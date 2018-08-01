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
        @include('site::catalog.show.children', ['catalog' => $catalog])
    </div>
@endsection
