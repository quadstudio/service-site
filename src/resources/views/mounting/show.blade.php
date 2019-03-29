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
                <a href="{{ route('mountings.index') }}">@lang('site::mounting.mountings')</a>
            </li>
            <li class="breadcrumb-item active">№ {{ $mounting->id }}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::mounting.header.mounting') № {{ $mounting->id }}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-4">

            <a href="{{ route('mountings.pdf', $mounting) }}"
               class="@cannot('pdf', $mounting) disabled @endcannot d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
                <i class="fa fa-print"></i>
                <span>@lang('site::messages.print')</span>
            </a>
            <a href="{{ route('mountings.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        @include('site::message.create')
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::mounting.header.mounting')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.created_at')</dt>
                    <dd class="col-sm-8">{{ $mounting->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.status_id')</dt>
                    <dd class="col-sm-8">
                        <span class="badge text-normal badge-{{$mounting->status->color}}">
                            <i class="fa fa-{{$mounting->status->icon}}"></i>
                            {{ $mounting->status->name }}
                        </span>
                    </dd>

                </dl>

                <hr/>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.serial_id')</dt>
                    <dd class="col-sm-8">{{ $mounting->serial_id }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::serial.product_id')</dt>
                    <dd class="col-sm-8">{{ $mounting->product->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.sku')</dt>
                    <dd class="col-sm-8">{{ $mounting->product->sku }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.equipment_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('equipments.show', $mounting->product->equipment)}}">
                            {{ $mounting->product->equipment->catalog->parentTreeName() }}
                            {{ $mounting->product->equipment->name }}
                        </a>
                    </dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">

                <h5 class="card-title">@lang('site::mounting.header.payment')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.contragent_id')</dt>
                    <dd class="col-sm-8">{{ $mounting->contragent->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.bonus')</dt>
                    <dd class="col-sm-8 ">
                        {{number_format($mounting->bonus, 0, '.', ' ')}}
                        {{ $mounting->user->currency->symbol_right }}
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.social_bonus')</dt>
                    <dd class="col-sm-8 ">
                        {{number_format($mounting->enabled_social_bonus, 0, '.', ' ')}}
                        {{ $mounting->user->currency->symbol_right }}
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.social_url')</dt>
                    <dd class="col-sm-8">
                        <a target="_blank" href="{{ $mounting->social_url }}">{{ $mounting->social_url }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right border-top">@lang('site::mounting.help.total')</dt>
                    <dd class="col-sm-8 border-sm-top border-top-0">
                        {{ $mounting->total}}
                        {{ $mounting->user->currency->symbol_right }}
                    </dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::mounting.header.client')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.client')</dt>
                    <dd class="col-sm-8">{{ $mounting->client }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.address')</dt>
                    <dd class="col-sm-8">{{ $mounting->address }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.phone_primary')</dt>
                    <dd class="col-sm-8">{{ $mounting->country->phone }} {{ $mounting->phone_primary }}</dd>
                    @if($mounting->phone_secondary)
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.phone_secondary')</dt>
                        <dd class="col-sm-8">{{ $mounting->country->phone }} {{ $mounting->phone_secondary }}</dd>
                    @endif
                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::mounting.header.org')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.trade_id')</dt>
                    <dd class="col-sm-8">{{ $mounting->trade->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.date_trade')</dt>
                    <dd class="col-sm-8">{{ $mounting->date_trade->format('d.m.Y') }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::mounting.header.call')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.engineer_id')</dt>
                    <dd class="col-sm-8">{{ $mounting->engineer->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.date_mounting')</dt>
                    <dd class="col-sm-8">{{ $mounting->date_mounting->format('d.m.Y') }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::mounting.header.extra')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.source_id')</dt>
                    <dd class="col-sm-8">
                        @if($mounting->source_id == 4)
                            {{ $mounting->source_other }}
                        @else
                            {{ $mounting->source->name }}
                        @endif


                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.comment')</dt>
                    <dd class="col-sm-8">{{ $mounting->comment }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">@lang('site::mounting.header.files')</h5>
                @include('site::file.files')
            </div>
        </div>
    </div>
@endsection
