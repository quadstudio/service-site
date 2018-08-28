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
            <li class="breadcrumb-item active">@lang('site::currency.currencies')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::currency.icon')"></i> @lang('site::currency.currencies')</h1>

        @alert()@endalert

        <div  class="justify-content-start border p-3 mb-2">
            <a class="disabled btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('admin.currencies.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::currency.currency')</span>
            </a>

            <a href="{{ route('admin.currencies.refresh') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-refresh"></i>
                <span>@lang('site::messages.refresh')</span>
            </a>
        </div>
        @pagination(['pagination' => $currencies])@endpagination
        {{$currencies->render()}}
        <div class="row items-row-view">
            @each('site::admin.currency.index.row', $currencies, 'currency')
        </div>
        {{$currencies->render()}}
    </div>
@endsection
