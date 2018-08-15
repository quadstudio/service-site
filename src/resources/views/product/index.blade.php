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
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $items])@endpagination
        {{$items->render()}}
        <div class="row">
            @each('site::product.grid', $items, 'product', 'site::product.empty')
        </div>
        {{$items->render()}}
    </div>
@endsection
