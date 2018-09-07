@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => __('site::datasheet.datasheets'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::datasheet.datasheets')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $datasheets])@endpagination
        {{$datasheets->render()}}
        <div class="row items-row-view">
            @each('site::datasheet.index.row', $datasheets, 'datasheet')
        </div>
        {{$datasheets->render()}}
    </div>
@endsection
