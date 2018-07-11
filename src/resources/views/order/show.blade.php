@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('orders.index') }}">@lang('site::order.breadcrumb_index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::order.breadcrumb_show', ['order' => $order->id, 'date' => $order->created_at->format(config('site.time_format', 'd.m.Y H:i:s')) ])</li>
        </ol>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20">Order № {{ $order->id }}</h4>

            </div>
        </div>
    </div>
@endsection
