@extends('layouts.app')

@section('title')@lang('site::member.members')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::member.members'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::member.members')]
        ]
    ])
@endsection
@section('content')
    <div class="container mb-5">
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('members.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.leave') @lang('site::member.member')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $members])@endpagination
        {{$members->render()}}
        <div class="row my-1 d-none d-sm-flex py-1 border-bottom">
            <div class="col-sm-2">
                <b>@lang('site::member.region_id')</b>
            </div>
            <div class="col-sm-2">
                <b>@lang('site::member.city')</b>
            </div>
            <div class="col-sm-2">
                <b>@lang('site::member.type_id')</b>
            </div>
            <div class="col-sm-2">
                <b>@lang('site::member.header.date_from_to')</b>
            </div>
            <div class="col-sm-4">
                <b>@lang('site::member.name')</b>
            </div>
        </div>
        @each('site::member.index.row', $members, 'member')
        {{$members->render()}}
    </div>
@endsection