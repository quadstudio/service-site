@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::launch.launches')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-@lang('site::launch.icon')"></i> @lang('site::launch.launches')</h1>
        <hr/>

        @include('alert')

        <div class="row">
            <div class="col-12 mb-2">
                <nav class="nav nav-pills flex-column flex-sm-row">
                    <a class="flex-sm-fill text-sm-center nav-link btn-success" href="{{ route('launches.create') }}" role="button">
                        <i class="fa fa-plus"></i>
                        <span>@lang('site::messages.add')</span>
                    </a>
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('engineers.index') }}">@lang('site::engineer.engineers')</a>
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('trades.index') }}">@lang('site::trade.trades')</a>
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('costs.index') }}">@lang('site::cost.costs')</a>

                </nav>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

        @include('repo::filter')

        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">@lang('site::launch.name')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::launch.country_id')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::launch.phone')</th>
                        <th scope="col" class="d-none d-md-table-cell">@lang('site::launch.address')</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::launch.row', $items, 'item')
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

    </div>
@endsection
