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
                <a href="{{ route('admin.trades.index') }}">@lang('site::trade.trades')</a>
            </li>
            <li class="breadcrumb-item active">{{ $trade->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $trade->name }}</h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.trades.edit', $trade) }}" class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::trade.trade')</span>
            </a>
            <a href="{{ route('admin.trades.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::trade.name')</dt>
                    <dd class="col-sm-8">{{ $trade->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::trade.country_id')</dt>
                    <dd class="col-sm-8"><img style="width: 30px;" class="img-fluid border" src="{{ asset($trade->country->flag) }}" alt=""> {{ $trade->country->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::trade.phone')</dt>
                    <dd class="col-sm-8">{{ $trade->country->phone }}{{ $trade->phone }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::trade.address')</dt>
                    <dd class="col-sm-8">{{ $trade->address }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection