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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.currencies.index') }}">@lang('site::currency.currencies')</a>
            </li>
            <li class="breadcrumb-item active">{{ $currency->title }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $currency->title }}</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-4">
            <a class="disabled btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.currencies.edit', $currency) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit')</span>
            </a>
            <a href="{{ route('admin.currencies.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::currency.title')</dt>
                    <dd class="col-sm-8">{{ $currency->title }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::currency.name')</dt>
                    <dd class="col-sm-8">{{ $currency->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::currency.rates')</dt>
                    <dd class="col-sm-8">{{ $currency->rates }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::currency.multiplicity')</dt>
                    <dd class="col-sm-8">{{ $currency->multiplicity }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::currency.symbol_left')</dt>
                    <dd class="col-sm-8">{{ $currency->symbol_left }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::currency.symbol_right')</dt>
                    <dd class="col-sm-8">{{ $currency->symbol_right }}</dd>

                </dl>
            </div>
        </div>

    </div>
@endsection