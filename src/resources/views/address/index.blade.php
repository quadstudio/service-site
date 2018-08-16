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
            <li class="breadcrumb-item active">@lang('site::address.addresses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::address.icon')"></i> @lang('site::address.addresses')</h1>

        @alert()@endalert
        <div class="border p-3 mb-2">
            <a class="disabled btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('addresses.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::address.address')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        @pagination(['pagination' => $addresses])@endpagination
        {{$addresses->render()}}
        <div class="row items-row-view">
            @each('site::address.index.row', $addresses, 'address')
        </div>
        {{$addresses->render()}}
    </div>
@endsection
