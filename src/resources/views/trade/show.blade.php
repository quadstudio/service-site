@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('repair::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('trades.index') }}">@lang('repair::trade.trades')</a>
            </li>
            <li class="breadcrumb-item active">{{ $trade->name }}</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">{{ $trade->name }}</h1>
        <hr/>

        @include('alert')

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('trades.edit', $trade) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('repair::messages.edit')</span>
                </a>
                <a href="{{ route('trades.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('repair::messages.back')</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <table class="table table-sm table-bordered">
                    <tbody>
                    <tr>
                        <td class="text-right"><b>@lang('repair::trade.name')</b></td>
                        <td>{{ $trade->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('repair::trade.country_id')</b></td>
                        <td><img style="width: 30px;" class="img-fluid border" src="{{ asset($trade->country->flag) }}" alt=""> {{ $trade->country->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('repair::trade.phone')</b></td>
                        <td>{{ $trade->country->phone }}{{ $trade->phone }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection