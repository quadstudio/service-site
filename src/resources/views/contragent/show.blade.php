@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('contragents.index') }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item active">{{ $contragent->name }}</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contragent.icon')"></i> {{ $contragent->name }}</h1>
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('contragents.edit', $contragent) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::contragent.contragent')</span>
            </a>
            <a href="{{ route('contragents.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
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
                            <div class="items-dropdown btn-group">
                                <button type="button"
                                        class="btn btn-sm btn-ferroli border btn-round md-btn-flat dropdown-toggle icon-btn hide-arrow"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <div class="items-dropdown-menu dropdown-menu dropdown-menu-right"
                                     x-placement="bottom-end"
                                     style="position: absolute; will-change: top, left; top: 26px; left: -134px;">

                                    <a @can('edit', $address)
                                       href="{{route('addresses.edit', $address)}}"
                                       @else()
                                       href="javascript:void(0);"
                                       @endcan class="dropdown-item">@lang('site::messages.edit')</a>
                                    <button @cannot('delete', $address) disabled @endcannot
                                    class="dropdown-item btn-row-delete"
                                            data-form="#contragent-delete-form-{{$contragent->id}}"
                                            data-btn-delete="@lang('site::messages.delete')"
                                            data-btn-cancel="@lang('site::messages.cancel')"
                                            data-label="@lang('site::messages.delete_confirm')"
                                            data-message="@lang('site::messages.delete_sure') @lang('site::address.address')? "
                                            data-toggle="modal" data-target="#form-modal"
                                            href="javascript:void(0);" title="@lang('site::messages.delete')">
                                        @lang('site::messages.delete')
                                    </button>
                                    <form id="contragent-delete-form-{{$address->id}}"
                                          action="{{route('addresses.destroy', $address)}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>

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
                    <div class="card">
                        <div class="card-body">
                            @php $address = $contragent->addresses()->whereTypeId(3)->first() @endphp
                            <div class="items-dropdown btn-group">
                                <button type="button"
                                        class="btn btn-sm btn-ferroli border btn-round md-btn-flat dropdown-toggle icon-btn hide-arrow"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <div class="items-dropdown-menu dropdown-menu dropdown-menu-right"
                                     x-placement="bottom-end"
                                     style="position: absolute; will-change: top, left; top: 26px; left: -134px;">

                                    <a @can('edit', $address)
                                       href="{{route('addresses.edit', $address)}}"
                                       @else()
                                       href="javascript:void(0);"
                                       @endcan class="dropdown-item">@lang('site::messages.edit')</a>
                                    <button @cannot('delete', $address) disabled @endcannot
                                    class="dropdown-item btn-row-delete"
                                            data-form="#contragent-delete-form-{{$contragent->id}}"
                                            data-btn-delete="@lang('site::messages.delete')"
                                            data-btn-cancel="@lang('site::messages.cancel')"
                                            data-label="@lang('site::messages.delete_confirm')"
                                            data-message="@lang('site::messages.delete_sure') @lang('site::address.address')? "
                                            data-toggle="modal" data-target="#form-modal"
                                            href="javascript:void(0);" title="@lang('site::messages.delete')">
                                        @lang('site::messages.delete')
                                    </button>
                                    <form id="contragent-delete-form-{{$address->id}}"
                                          action="{{route('addresses.destroy', $address)}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection
