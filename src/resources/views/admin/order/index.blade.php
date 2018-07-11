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
            <li class="breadcrumb-item active">@lang('site::order.orders')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-shopping-cart"></i> @lang('site::order.orders')</h1>
        <hr/>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
        @include('repo::filter')
        <table class="table table-sm">
            <thead>
            <tr>
                <th class="text-center">№</th>
                <th class="text-center">@lang('site::order.created_at')</th>
                <th class="d-none d-md-table-cell">@lang('site::order.client')</th>
                <th class="text-right">@lang('site::order.total_short')</th>
                <th class="text-center"><span class="d-none d-sm-table-cell">@lang('site::order.status_id')</span></th>
            </tr>
            </thead>
            <tbody>
            @each('site::admin.order.index.row', $items, 'item')
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
    </div>
@endsection
