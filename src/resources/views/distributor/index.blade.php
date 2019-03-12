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
            <li class="breadcrumb-item active">@lang('site::order.distributors')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.distributors')</h1>
        <div class=" border p-3 mb-2">
            {{--<a href="{{ route('orders.create') }}"--}}
               {{--class="d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-ferroli">--}}
                {{--<i class="fa fa-magic"></i>--}}
                {{--<span>@lang('site::messages.create') @lang('site::order.order')</span>--}}
            {{--</a>--}}
            <a href="{{ route('home') }}"
               class="d-block d-sm-inline btn btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.home')</span>
            </a>
        </div>
        @alert()@endalert()
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $orders])@endpagination
        {{$orders->render()}}
        <div class="row items-row-view mb-4">
            @each('site::distributor.index.row', $orders, 'order')
        </div>
        {{$orders->render()}}
    </div>
@endsection
