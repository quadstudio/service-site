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
                <a href="{{ route('admin.contragents.index') }}">@lang('site::contragent.contragents')</a>
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
            <a href="{{ route('admin.contragents.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::contragent.help.back_list')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <div class="item-content-user text-muted small mb-2">{{$contragent->type->name}}</div>
                <div class="card-group">
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
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            @php $address = $contragent->addresses()->whereTypeId(1)->first() @endphp
                            <h6 class="card-title">{{$address->type->name}}</h6>
                            <div class="item-content-about">
                                <h5 class="item-content-name mb-1">
                                    <a href="{{route('addresses.show', $address)}}"
                                       class="text-dark">{{$address->name}}</a>
                                </h5>
                                <hr class="border-light">
                                <div>
                                    <img style="width: 30px;" class="img-fluid border"
                                         src="{{ asset($address->country->flag) }}"
                                         alt="">
                                    {{$address->country->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @php $address = $contragent->addresses()->whereTypeId(3)->first() @endphp
                            <h6 class="card-title">{{$address->type->name}}</h6>
                            <div class="item-content-about">
                                <h5 class="item-content-name mb-1">
                                    <a href="javascript:void(0)" class="text-dark">{{$address->name}}</a>
                                </h5>
                                <hr class="border-light">
                                <div>
                                    <img style="width: 30px;" class="img-fluid border"
                                         src="{{ asset($address->country->flag) }}"
                                         alt="">
                                    {{$address->country->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-light">
                <div>
                    <div class="text-muted">@lang('site::contragent.nds') @bool(['bool' => $contragent->nds == 1])@endbool</div>
                    <div class="text-muted mr-3">@lang('site::contragent.organization_id')
                        : {{$contragent->organization->name}}</div>
                    <div class="text-muted mr-3">@lang('site::contragent.contract')
                        : @if(is_null($contragent->contract))
                            <span class="badge text-normal badge-danger">Не указан</span>
                        @else
                            {{$contragent->contract }}
                        @endif</div>
                </div>
            </div>
        </div>
    </div>
@endsection
