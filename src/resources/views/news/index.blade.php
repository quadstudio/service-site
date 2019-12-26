@extends('layouts.app')

@section('title')@lang('site::news.news')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::news.news'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::news.news')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        {{$news->render()}}
        <div class="row news-list">
            @each('site::news.index.row', $news, 'item')
        </div>
        {{$news->render()}}
    </div>
@endsection