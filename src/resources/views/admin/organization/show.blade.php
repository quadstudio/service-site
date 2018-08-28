@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.organizations.index') }}">@lang('site::organization.organizations')</a>
            </li>
            <li class="breadcrumb-item active">{{ $organization->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $organization->name }}</h1>
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.organizations.edit', $organization) }}"
               class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::account.account')</span>
            </a>
            <a href="{{ route('admin.organizations.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.name')</dt>
                    <dd class="col-sm-8">{{ $organization->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.inn')</dt>
                    <dd class="col-sm-8">{{ $organization->inn }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.kpp')</dt>
                    <dd class="col-sm-8">{{ $organization->kpp }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.okpo')</dt>
                    <dd class="col-sm-8">{{ $organization->okpo }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.address')</dt>
                    <dd class="col-sm-8">{{ $organization->address }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.active')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $organization->active == 1])@endbool</dd>

                    @if(!$organization->account)
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.account_id')</dt>
                        <dd class="col-sm-8">
                            <span class="badge text-normal badge-danger">@lang('site::messages.not_indicated_m')</span>
                        </dd>
                    @else
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.account_id')</dt>
                        <dd class="col-sm-8">{{ $organization->account->id }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::bank.id')</dt>
                        <dd class="col-sm-8">{{ $organization->account->bank_id }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::account.bank_id')</dt>
                        <dd class="col-sm-8">{{ $organization->account->bank->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::bank.ks')</dt>
                        <dd class="col-sm-8">{{ $organization->account->bank->ks }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::account.disabled')</dt>
                        <dd class="col-sm-8">@bool(['bool' => $organization->account->disabled == 1])@endbool</dd>
                    @endif

                </dl>
                <hr/>
                <dl class="row">
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::organization.accounts')</dt>
                    <dd class="col-sm-8">
                        @if($organization->accounts()->count() > 0)
                            @foreach($organization->accounts as $account)
                                <div class="row">
                                    <div class="col">{{$account->id}}</div>
                                    <div class="col">{{$account->bank->name}}</div>
                                </div>
                            @endforeach
                        @else
                            <span class="badge text-normal badge-danger">@lang('site::messages.not_found')</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
