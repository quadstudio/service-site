@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::product.index')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">@lang('site::product.index')</h1>
        <hr/>
        @include('repo::filter')
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

        <div class="row">
            @if(config('site.layout', 'grid') == 'list')
                <div class="col-12">
                    @endif
                    @each('site::product.'.config('site.layout'), $items, 'item', 'site::product.empty')
                    @if(config('site.layout', 'grid') == 'list')
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

    </div>
@endsection
