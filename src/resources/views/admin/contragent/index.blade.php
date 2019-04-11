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
            <li class="breadcrumb-item active">@lang('site::contragent.contragents')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents')
        </h1>

        @alert()@endalert

        <div class=" border p-3 mb-4">
            <button form="repository-form"
                    type="submit"
                    name="excel"
                    class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
                <i class="fa fa-upload"></i>
                <span>@lang('site::messages.upload') @lang('site::messages.to_excel')</span>
            </button>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $contragents])@endpagination
        {{$contragents->render()}}
        @foreach($contragents as $contragent)
            <div class="card my-2" id="contragent-{{$contragent->id}}">

                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::contragent.name')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.contragents.show', $contragent)}}" class="mr-3 ml-0">
                                    {{$contragent->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::contragent.user_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.users.show', $contragent->user)}}" class="mr-3 ml-0">
                                    {{$contragent->user->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::contragent.inn')</dt>
                            <dd class="col-12">
                                {{ $contragent->inn }}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            @if($contragent->organization)
                                <dt class="col-12">@lang('site::contragent.organization_id')</dt>
                                <dd class="col-12">{{$contragent->organization->name }}</dd>
                            @endif
                            @if($contragent->contract)
                                <dt class="col-12">@lang('site::contragent.contract')</dt>
                                <dd class="col-12">{{$contragent->contract }}</dd>
                            @endif
                        </dl>

                    </div>
                </div>
            </div>
        @endforeach
        {{$contragents->render()}}
    </div>
@endsection