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
            @if($address->addressable_type == 'contragents')
                <li class="breadcrumb-item">
                    <a href="{{ route('contragents.index') }}">@lang('site::contragent.contragents')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('contragents.show', $address->addressable) }}">{{$address->addressable->name}}</a>
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ route('addresses.index') }}">@lang('site::address.addresses')</a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $address->type->name }}</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::address.icon')"></i> {{ $address->type->name }}</h1>
        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('addresses.edit', $address) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::address.address')</span>
            </a>
            @if($address->addressable_type == 'contragents')
                <a href="{{ route('contragents.show', $address->addressable) }}" class="d-block d-sm-inline btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::contragent.help.back')</span>
                </a>
            @else
                <a href="{{ route('addresses.index') }}" class="d-block d-sm-inline btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            @endif
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h4 class="card-title">{{$address->name}}</h4>

                <dl class="row">
                    @if($address->addressable_type == 'contragents')
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.addressable.'.$address->addressable_type)</dt>
                        <dd class="col-sm-8">
                            <a href="{{ route('contragents.show', $address->addressable) }}">{{ $address->addressable->name }}</a>
                        </dd>
                    @endif
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.country_id')</dt>
                    <dd class="col-sm-8">
                        <img style="width: 30px;" class="img-fluid border"
                             src="{{ asset($address->country->flag) }}"
                             alt="">
                        {{$address->country->name}}
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.region_id')</dt>
                    <dd class="col-sm-8"> {{ $address->region->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.locality')</dt>
                    <dd class="col-sm-8">{{ $address->locality }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.street')</dt>
                    <dd class="col-sm-8">{{ $address->street }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.building')</dt>
                    <dd class="col-sm-8">{{ $address->building }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.apartment')</dt>
                    <dd class="col-sm-8">{{ $address->apartment }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.postal')</dt>
                    <dd class="col-sm-8">{{ $address->postal }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.geo')</dt>
                    <dd class="col-sm-8">{{ $address->geo }}</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
