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
            <li class="breadcrumb-item active">@lang('site::order.orders')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-shopping-cart"></i> @lang('site::order.orders')</h1>
        <hr/>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
        @include('repo::filter')
        <div class="row">
            @each('site::order.item', $items, 'item')
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
    </div>
@endsection
