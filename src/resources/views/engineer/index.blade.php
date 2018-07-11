@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('repair::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('repair::engineer.engineers')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-@lang('repair::engineer.icon')"></i> @lang('repair::engineer.engineers')</h1>
        <hr/>

        @include('alert')

        <div class="row">
            <div class="col-12 mb-2">
                <nav class="nav nav-pills flex-column flex-sm-row">
                    <a class="flex-sm-fill text-sm-center nav-link btn-success" href="{{ route('engineers.create') }}" role="button">
                        <i class="fa fa-plus"></i>
                        <span>@lang('repair::messages.add')</span>
                    </a>
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('trades.index') }}">@lang('repair::trade.trades')</a>
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('launches.index') }}">@lang('repair::launch.launches')</a>
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('costs.index') }}">@lang('repair::cost.costs')</a>
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
                        <th scope="col">@lang('repair::engineer.name')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('repair::engineer.country_id')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('repair::engineer.phone')</th>
                        <th scope="col" class="d-none d-md-table-cell">@lang('repair::engineer.address')</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('repair::engineer.row', $items, 'item')
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
