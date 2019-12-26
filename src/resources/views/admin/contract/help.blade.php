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
            <li class="breadcrumb-item active">@lang('site::contract.contracts')</li>
        </ol>
        <h1 class="header-title">
            <i class="fa fa-@lang('site::contract.icon')"></i> @lang('site::contract.contracts')
        </h1>
        @alert()@endalert

        <div class=" border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
		<a class="d-block d-sm-inline-block btn btn-secondary"
	           href="{{ route('admin.contract-types.index') }}">
	        <i class="fa fa-@lang('site::contract_type.icon')"></i> @lang('site::contract_type.contract_types')
	        </a>
        </div>
	@filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $contracts])@endpagination
        {{$contracts->render()}}
        @foreach($contracts as $contract)
            <div class="card @if($loop->last) mb-2 @else my-2 my-sm-0 @endif"
                 id="contract-{{$contract->id}}">
                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('admin.contracts.show', $contract)}}" class="mr-2 ml-0 text-big">
                            @lang('site::contract.header.contract')
                            № {{$contract->number}}
                        </a>
                    </div>

                    <div class="card-header-elements ml-md-auto">
                        <a href="{{route('admin.users.show', $contract->contragent->user)}}">
                            <img id="user-logo"
                                 src="{{$contract->contragent->user->logo}}"
                                 style="width:25px!important;height: 25px"
                                 class="rounded-circle mr-2">{{$contract->contragent->user->name}}
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::messages.created_at')</dt>
                            <dd class="col-12">{{$contract->created_at->format('d.m.Y H:i')}}</dd>
                            <dt class="col-12">@lang('site::contract.date')</dt>
                            <dd class="col-12">{{$contract->date->format('d.m.Y')}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::contract.contragent_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.contragents.show', $contract->contragent)}}">
                                    {{$contract->contragent->name}}
                                </a>
                            </dd>
                            <dt class="col-12">@lang('site::contract.territory')</dt>
                            <dd class="col-12">{{$contract->territory}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::contract.signer')</dt>
                            <dd class="col-12">{{$contract->signer}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6 text-right">
                        <dl class="dl-horizontal mt-2">
                            <dd class="col-12">
                                <a class="btn btn-success" href="{{route('admin.contracts.download', $contract)}}">
                                    @lang('site::contract.help.download')
                                </a>
                            </dd>
                            <dd class="col-12">
                                <span class="bg-light px-2">{{ $contract->type->name }}</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$contracts->render()}}
    </div>
@endsection
