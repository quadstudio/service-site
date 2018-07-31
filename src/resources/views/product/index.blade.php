@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => __('site::product.products'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::product.products')]
        ]
    ])
@endsection
@section('content')
    <div class="container">

        @include('repo::filter')
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
        <div class="row">
            @each('site::product.grid', $items, 'item', 'site::product.empty')
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

    </div>
@endsection
