@extends('center::layouts.page')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('shop::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('shop::order.orders')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-shopping-cart"></i> @lang('shop::order.orders')</h1>
        <hr/>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
        @include('repo::filter')
        <div class="row">
            @each('shop::order.item', $items, 'item')
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>
    </div>
@endsection
