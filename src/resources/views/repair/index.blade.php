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
            <li class="breadcrumb-item active">@lang('site::repair.repairs')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('repairs.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::repair.repair')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $repairs])@endpagination
        {{$repairs->render()}}
        <div class="row items-row-view">
            @each('site::repair.index.row', $repairs, 'repair')
        </div>
        {{$repairs->render()}}
    </div>
@endsection
