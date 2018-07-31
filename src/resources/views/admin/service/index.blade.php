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
            <li class="breadcrumb-item active">@lang('site::service.services')</li>
        </ol>
        <h1 class="header-titlemb-4"><i class="fa fa-@lang('site::service.icon')"></i> @lang('site::service.services')</h1>
        @alert()@endalert
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

        @filter()@endfilter

        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th class="text-center" scope="col"></th>
                        <th scope="col">@lang('site::user.name')</th>
                        <th scope="col">@lang('site::service.name')</th>
                        <th scope="col">@lang('site::address.region_id') / @lang('site::address.locality')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::user.logged_at')</th>
                        <th scope="col">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.service.index.row', $items, 'service')
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
