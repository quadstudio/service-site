@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::act.acts')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $acts])@endpagination
        {{$acts->render()}}
        <div class="row items-row-view">
            @each('site::act.index.row', $acts, 'act')
        </div>
        {{$acts->render()}}
    </div>
@endsection
