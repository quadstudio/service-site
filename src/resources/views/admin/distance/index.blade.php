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
            <li class="breadcrumb-item active">@lang('site::distance.distances')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::distance.icon')"></i> @lang('site::distance.distances')</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.distances.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::distance.distance')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $distances])@endpagination
        {{$distances->render()}}
        <div class="row items-row-view" data-target="{{route('admin.distances.sort')}}" id="sort-list">
            @each('site::admin.distance.index.row', $distances, 'distance')
        </div>
        {{$distances->render()}}
    </div>
@endsection
