@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::launch.launches')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::launch.icon')"></i> @lang('site::launch.launches')</h1>

        @alert()@endalert
        <div class=" border p-3 mb-4">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('launches.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::launch.launch')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        <div class="row items-row-view">
            @each('site::launch.index.row', $launches, 'launch')
        </div>
        {{----}}
        {{--<div class="row">--}}
        {{--<div class="col-12 mb-2">--}}
        {{--<nav class="nav nav-pills flex-column flex-sm-row">--}}
        {{--<a class="flex-sm text-sm-center nav-link btn-success" href="{{ route('launches.create') }}" role="button">--}}
        {{--<i class="fa fa-plus"></i>--}}
        {{--<span>@lang('site::messages.add')</span>--}}
        {{--</a>--}}
        {{--</nav>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="card mb-4">--}}
        {{--<div class="card-body">--}}
        {{--{{$items->render()}}--}}
        {{--@filter(['repository' => $repository])@endfilter--}}
        {{--<table class="table table-hover table-sm">--}}
        {{--<thead>--}}
        {{--<tr>--}}
        {{--<th scope="col"></th>--}}
        {{--<th scope="col">@lang('site::launch.name')</th>--}}
        {{--<th scope="col" class="d-none d-sm-table-cell">@lang('site::launch.country_id')</th>--}}
        {{--<th scope="col" class="d-none d-sm-table-cell">@lang('site::launch.phone')</th>--}}
        {{--<th scope="col" class="d-none d-md-table-cell">@lang('site::launch.address')</th>--}}
        {{--<th scope="col"></th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--@each('site::launch.row', $items, 'item')--}}
        {{--</tbody>--}}
        {{--</table>--}}
        {{--{{$items->render()}}--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection
