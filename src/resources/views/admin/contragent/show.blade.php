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
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.show', $contragent->user) }}">{{$contragent->user->name}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.contragents', $contragent->user) }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item active">{{ $contragent->name }}</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contragent.icon')"></i> {{ $contragent->name }}</h1>
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.contragents.edit', $contragent) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::contragent.contragent')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.contragents.addresses.index', $contragent) }}"
               role="button">
                <i class="fa fa-@lang('site::address.icon')"></i>
                <span>@lang('site::address.addresses')</span>
                <span class="badge badge-light">{{$contragent->addresses()->count()}}</span>
            </a>
            <a href="{{ route('admin.users.contragents', $contragent->user) }}"
               class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.guid')</dt>
                    <dd class="col-sm-8">
                        @if($contragent->guid)
                            {{ $contragent->guid }}
                        @else
                            <span class="badge text-normal badge-danger">@lang('site::messages.not_received')</span>
                        @endif

                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.type_id')</dt>
                    <dd class="col-sm-8">{{ $contragent->type->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.organization_id')</dt>
                    <dd class="col-sm-8">
                        @if($contragent->organization)
                            <a href="{{route('admin.organizations.show', $contragent->organization)}}">{{$contragent->organization->name}}</a>
                        @else
                            <span class="badge text-normal badge-danger">@lang('site::messages.not_indicated_f')</span>
                        @endif
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.contract')</dt>
                    <dd class="col-sm-8">
                        @if($contragent->contract)
                            {{$contragent->contract }}
                        @else
                            <span class="badge text-normal badge-danger">@lang('site::messages.not_indicated_m')</span>

                        @endif
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.nds')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $contragent->nds == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.nds_act')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $contragent->nds_act == 1])@endbool</dd>

                </dl>
            </div>
        </div>
        <div class="card-group mb-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">@lang('site::contragent.header.legal')</h6>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.inn')</dt>
                        <dd class="col-sm-8">{{ $contragent->inn }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.ogrn')</dt>
                        <dd class="col-sm-8"> {{ $contragent->ogrn }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.kpp')</dt>
                        <dd class="col-sm-8">{{ $contragent->kpp }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.okpo')</dt>
                        <dd class="col-sm-8">{{ $contragent->okpo }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">@lang('site::contragent.header.payment')</h6>
                    <dl class="row">
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.rs')</dt>
                        <dd class="col-sm-8">{{ $contragent->rs }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.bik')</dt>
                        <dd class="col-sm-8"> {{ $contragent->bik }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.bank')</dt>
                        <dd class="col-sm-8">{{ $contragent->bank }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.ks')</dt>
                        <dd class="col-sm-8">{{ $contragent->ks }}</dd>

                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
