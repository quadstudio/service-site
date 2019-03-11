@extends('layouts.app')

@section('title')@lang('site::event.events')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::event.events'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::event.events')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $events])@endpagination
        {{$events->render()}}
        <div class="row news-list">
            @each('site::event.index.row', $events, 'event')
        </div>
        {{$events->render()}}
    </div>
@endsection
