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
                <a href="{{ route('contracts.index') }}">@lang('site::contract.contracts')</a>
            </li>
            <li class="breadcrumb-item active">№ {{ $contract->number }}</li>
        </ol>
        <h1 class="header-title mb-4">№ {{ $contract->number }}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn btn-ferroli"
               href="{{route('contracts.edit', $contract)}}">
                @lang('site::messages.edit')
            </a>
            <a class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn btn-success"
               href="{{route('contracts.download', $contract)}}">
                @lang('site::contract.help.download')
            </a>
            <button @cannot('delete', $contract) disabled @endcannot
            class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-danger btn-row-delete"
                    data-form="#contract-delete-form-{{$contract->id}}"
                    data-btn-delete="@lang('site::messages.delete')"
                    data-btn-cancel="@lang('site::messages.cancel')"
                    data-label="@lang('site::messages.delete_confirm')"
                    data-message="@lang('site::messages.delete_sure') @lang('site::contract.contract')? "
                    data-toggle="modal" data-target="#form-modal"
                    title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i>
                @lang('site::messages.delete')
            </button>
            <a href="{{ route('contracts.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <form id="contract-delete-form-{{$contract->id}}"
              action="{{route('contracts.destroy', $contract)}}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
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
                    <dd class="col-sm-8">{{ $contract->type->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.territory')</dt>
                    <dd class="col-sm-8">{{ $contract->territory }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.signer')</dt>
                    <dd class="col-sm-8">{{ $contract->signer }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.phone')</dt>
                    <dd class="col-sm-8">{{ $contract->phone }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract.contragent_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('contragents.show', $contract->contragent)}}">
                            {{ $contract->contragent->name }}
                        </a>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
