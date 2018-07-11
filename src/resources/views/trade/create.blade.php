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
            <li class="breadcrumb-item active">@lang('repair::messages.add')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">@lang('repair::messages.add') @lang('repair::trade.trade')</h1>
        <hr/>

        @include('alert')

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">
                @include('repair::trade.form')
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="form-content" value="1" type="submit" class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('repair::messages.save_add')</span>
                        </button>
                        <button name="_create" form="form-content" value="0" type="submit" class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('repair::messages.save')</span>
                        </button>
                        <a href="{{ route('trades.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('repair::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection