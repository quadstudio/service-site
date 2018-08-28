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
            <li class="breadcrumb-item">
                <a href="{{ route('orders.index') }}">@lang('site::order.orders')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-magic"></i> @lang('site::messages.create') @lang('site::order.order')</h1>

        @alert()@endalert()
        <div class="card mt-2 mb-2">
            <div class="card-body">

                <form id="order-create-form" method="POST" action="{{ route('orders.store') }}">
                    <input type="hidden" name="status_id" value="1"/>
                    @csrf

                    <div class="form-group required">
                        <label class="control-label"
                               for="fast_product_id">@lang('site::order_item.product_id')</label>
                        <select data-limit="10" id="fast_product_id" style="width:100%" class="form-control">
                            <option value=""></option>
                        </select>
                        <span id="fast_product_idHelp" class="d-block form-text text-success">
                            @lang('site::order_item.help.product_id')
                        </span>

                    </div>

                </form>

                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="order-create-form" value="0" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
