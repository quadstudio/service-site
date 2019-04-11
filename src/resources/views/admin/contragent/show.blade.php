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
        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.contragents.edit', $contragent) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::contragent.contragent')</span>
            </a>
            <a href="{{ route('admin.contragents.index') }}"
               class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.user_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('admin.users.show', $contragent->user)}}">{{$contragent->user->name}}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.name')</dt>
                    <dd class="col-sm-8">{{ $contragent->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.nds')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $contragent->nds == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.nds_act')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $contragent->nds_act == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.organization_id')</dt>
                    <dd class="col-sm-8">{{$contragent->organization->name}}</dd>


                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.inn')</dt>
                    <dd class="col-sm-8">{{ $contragent->inn }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.ogrn')</dt>
                    <dd class="col-sm-8"> {{ $contragent->ogrn }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.kpp')</dt>
                    <dd class="col-sm-8">{{ $contragent->kpp }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.okpo')</dt>
                    <dd class="col-sm-8">{{ $contragent->okpo }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.rs')</dt>
                    <dd class="col-sm-8">{{ $contragent->rs }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.bik')</dt>
                    <dd class="col-sm-8"> {{ $contragent->bik }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.bank')</dt>
                    <dd class="col-sm-8">{{ $contragent->bank }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.ks')</dt>
                    <dd class="col-sm-8">{{ $contragent->ks }}</dd>

                    @foreach ($contragent->addresses()->where('type_id', 1)->with('type')->get() as $address)
                        <dt class="col-sm-4 text-left text-sm-right">{{$address->type->name}}</dt>
                        <dd class="col-sm-8">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span>{{$address->full}}</span>
                                    <a href="{{route('admin.contragents.addresses.edit', [$contragent, $address])}}"
                                       class="pull-right btn btn-ferroli btn-sm py-0 mx-1">
                                        <i class="fa fa-pencil"></i>
                                        @lang('site::messages.edit')
                                    </a>
                                </li>
                            </ul>


                        </dd>
                    @endforeach
                    @foreach ($contragent->addresses()->where('type_id', 3)->with('type')->get() as $address)
                        <dt class="col-sm-4 text-left text-sm-right">{{$address->type->name}}</dt>
                        <dd class="col-sm-8">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span>{{$address->full}}</span>
                                    <a href="{{route('admin.contragents.addresses.edit', [$contragent, $address])}}"
                                       class="pull-right btn btn-ferroli btn-sm py-0 mx-1">
                                        <i class="fa fa-pencil"></i>
                                        @lang('site::messages.edit')
                                    </a>
                                </li>
                            </ul>
                        </dd>
                    @endforeach
                </dl>
            </div>
        </div>

    </div>
@endsection
