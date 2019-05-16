@extends('layouts.app')

@section('title')@lang('site::announcement.announcements')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::announcement.announcement'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::announcement.announcement')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        {{$announcements->render()}}
        <div class="row announcement-list">
            @each('site::announcement.index.row', $announcements, 'announcement')
        </div>
        {{$announcements->render()}}
    </div>
@endsection