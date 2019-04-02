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
            <li class="breadcrumb-item active">@lang('site::contragent.contragents_user')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents_user')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('contragents.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::contragent.contragent_user')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $contragents])@endpagination
        {{$contragents->render()}}

        @foreach($contragents as $contragent)
            <div class="card my-4" id="contragent-{{$contragent->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('contragents.show', $contragent)}}" class="mr-3">
                            {{$contragent->name}}
                        </a>
                    </div>
                    @if($contragent->contract)
                        <div class="card-header-elements ml-md-auto">
                            <span class="badge text-normal badge-pill badge-light">
                                @lang('site::contragent.contract'): {{$contragent->contract}}
                            </span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xl-4 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            @foreach ($contragent->addresses()->where('type_id', 1)->with('type')->get() as $address)
                                <dt class="col-12">{{$address->type->name}}</dt>
                                <dd class="col-12">{{$address->full}}</dd>
                            @endforeach
                        </dl>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::contragent.inn')</dt>
                            <dd class="col-12">{{$contragent->inn}}</dd>
                            <dt class="col-12">@lang('site::contragent.ogrn')</dt>
                            <dd class="col-12">{{$contragent->ogrn}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::contragent.type_id')</dt>
                            <dd class="col-12">{{ $contragent->type->name }}</dd>
                            <dt class="col-12">@lang('site::contragent.organization_id')</dt>
                            <dd class="col-12">{{$contragent->organization->name}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::contragent.nds')</dt>
                            <dd class="col-12">
                                @bool(['bool' => $contragent->nds])@endbool
                            </dd>
                            <dt class="col-12">@lang('site::contragent.nds_act')</dt>
                            <dd class="col-12">
                                @bool(['bool' => $contragent->nds_act])@endbool
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$contragents->render()}}
    </div>
@endsection
