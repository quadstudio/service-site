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
            <h1>@lang('site::unsubscribe.email', compact('email'))</h1>
            @isset($success)
                <div class="text-large badge badge-success">@lang('site::unsubscribe.success')</div>
            @else
                <p class="lead">@lang('site::unsubscribe.answer')</p>
                <hr class="my-4">
                <p>@lang('site::unsubscribe.text')</p>
                <form id="unsubscribe-form" method="post" action="{{route('unsubscribe', [$email, 'signature' => $signature])}}">
                    @csrf
                </form>
                <button form="unsubscribe-form" class="btn btn-ferroli btn-lg" type="submit">@lang('site::unsubscribe.buttons.yes')</button>
                <a class="btn btn-secondary btn-lg" href="/" role="button">@lang('site::unsubscribe.buttons.no')</a>
            @endisset

        </div>
    </div>
@endsection
