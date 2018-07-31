@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::currency.currencies')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::currency.icon')"></i> @lang('site::currency.currencies')</h1>

        @alert()@endalert

        <div class="row">
            <div class="col-12 mb-2">
                <a class="btn btn-success" href="{{ route('admin.currencies.create') }}"
                   role="button">
                    <i class="fa fa-plus"></i>
                    <span>@lang('site::messages.add')</span>
                </a>
                <a class="btn btn-success" href="{{ route('currencies.refresh') }}"
                   role="button">
                    <i class="fa fa-refresh"></i>
                    <span>@lang('site::messages.refresh')</span>
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">@lang('site::currency.name')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::currency.title')</th>
                        <th scope="col" class="text-right">@lang('site::currency.rates')</th>
                        <th scope="col" class="d-none d-sm-table-cell text-center">@lang('site::currency.id')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.currency.index.row', $currencies, 'currency')
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
