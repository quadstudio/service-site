@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::contract.contracts')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::contract.icon')"></i> @lang('site::contract.contracts')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <div class="dropdown d-inline-block">
                <button class="btn @if($contract_types->isEmpty()) disabled @endif btn-ferroli dropdown-toggle"
                        type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-magic"></i>
                    <span>@lang('site::messages.create') @lang('site::contract.contract')</span>
                </button>
                @if($contract_types->isNotEmpty())
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($contract_types as $contract_type)
                            <a class="dropdown-item"
                               href="{{ route('contracts.create', $contract_type) }}">{{$contract_type->name}}</a>
                        @endforeach
                    </div>
                @endif
            </div>
            <a href="{{ route('home') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $contracts])@endpagination
        {{$contracts->render()}}
        @foreach($contracts as $contract)
            <div class="card my-4" id="contract-{{$contract->id}}">
                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('contracts.show', $contract)}}" class="mr-2 ml-0 text-big">
                            @lang('site::contract.header.contract')
                            № {{$contract->number}}
                        </a>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        <span class="bg-light px-2">{{ $contract->type->name }}</span>
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
                                <a href="{{route('contragents.show', $contract->contragent)}}">
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
                            <dt class="col-12">@lang('site::contract.phone')</dt>
                            <dd class="col-12">{{$contract->phone}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6 text-right">
                        <dl class="dl-horizontal mt-2">
                            <dd class="col-12"><a class="btn btn-success"
                                                  href="{{route('contracts.download', $contract)}}">@lang('site::contract.help.download')</a>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$contracts->render()}}
    </div>
@endsection
