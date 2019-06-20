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
                <a href="{{ route('admin.contracts.index') }}">@lang('site::contract.contracts')</a>
            </li>
            <li class="breadcrumb-item active">№ {{ $contract->number }}</li>
        </ol>
        <h1 class="header-title mb-4">№ {{ $contract->number }}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn btn-success"
               href="{{route('admin.contracts.download', $contract)}}">
                @lang('site::contract.help.download')
            </a>
            <a href="{{ route('admin.contracts.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <div class="card mb-4">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.created_at')</dt>
                    <dd class="col-sm-8">{{ $contract->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.number')</dt>
                    <dd class="col-sm-8">{{ $contract->number }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.date')</dt>
                    <dd class="col-sm-8">{{ $contract->date->format('d.m.Y') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.type_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('admin.contract-types.show', $contract->type)}}">
                            {{ $contract->type->name }}
                        </a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.signer')</dt>
                    <dd class="col-sm-8">{{ $contract->signer }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.territory')</dt>
                    <dd class="col-sm-8">{{ $contract->territory }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.contragent_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('admin.contragents.show', $contract->contragent)}}">
                            {{ $contract->contragent->name }}
                        </a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.user_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('admin.users.show', $contract->contragent->user)}}">
                            {{ $contract->contragent->user->name }}
                        </a>
                    </dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
