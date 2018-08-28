@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::difficulty.difficulties')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::difficulty.icon')"></i> @lang('site::difficulty.difficulties')</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.difficulties.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::difficulty.difficulty')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $difficulties])@endpagination
        {{$difficulties->render()}}
        <div class="row items-row-view" data-target="{{route('admin.difficulties.sort')}}" id="sort-list">
            @each('site::admin.difficulty.index.row', $difficulties, 'difficulty')
        </div>
        {{$difficulties->render()}}
    </div>
@endsection
