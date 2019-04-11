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
            <li class="breadcrumb-item active">@lang('site::address.addresses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::address.icon')"></i> @lang('site::address.addresses')</h1>

        @alert()@endalert
        <div class="border p-3 mb-2">
            <div class="dropdown d-inline-block">
                <button class="btn btn-ferroli dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-plus"></i>
                    <span>@lang('site::messages.add') @lang('site::address.address')</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($address_types as $address_type)
                        <a class="dropdown-item"
                           href="{{ route('addresses.create', $address_type) }}">{{$address_type->name}}</a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $addresses])@endpagination
        {{$addresses->render()}}

        @foreach($addresses as $address)
            <div class="card my-4" id="address-{{$address->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('addresses.show', $address)}}" class="mr-3">
                            {{$address->name}}
                        </a>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        <span class="px-2 bg-light">{{$address->type->name}}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-5 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::address.full')</dt>
                            <dd class="col-12">{{$address->full}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::phone.phones')</dt>
                            <dd class="col-12">
                                <ul class="list-group"></ul>
                                @foreach ($address->phones()->with('country')->get() as $phone)
                                    <li class="list-group-item border-0 p-0">
                                        {{$phone->country->phone}}
                                        {{$phone->number}}
                                        @if($phone->extra)
                                            (@lang('site::phone.help.extra') {{$phone->extra}})
                                        @endif
                                    </li>
                                @endforeach
                            </dd>

                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-12">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            @if($address->email)
                                <dt class="col-12">@lang('site::address.email')</dt>
                                <dd class="col-12">{{$address->email}}</dd>
                            @endif
                            @if($address->web)
                                <dt class="col-12">@lang('site::address.web')</dt>
                                <dd class="col-12">{{$address->web}}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$addresses->render()}}
    </div>
@endsection
