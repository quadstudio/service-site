@extends('layouts.app')

@section('title')@lang('site::unsubscribe.unsubscribe')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::unsubscribe.unsubscribe'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::unsubscribe.unsubscribe')]
        ]
    ])
@endsection
@section('content')
    <div class="container mb-4">
        <div class="jumbotron">
            <h4 class="text-large text-success">@lang('site::unsubscribe.success', compact('email'))</h4>
        </h4>
    </div>
@endsection
