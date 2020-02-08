@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.home')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-desktop"></i> @lang('site::messages.home')</h1>
        @alert()@endalert
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="media">
                            <img id="user-logo" src="{{$user->logo}}" style="width:100px!important;height: 100px"
                                 class="rounded-circle">
                            <div class="media-body pt-2 ml-3">
                                <h5 class="mb-2">{{ $user->name }}</h5>
                                <div class="mt-3">
                                    <form action="{{route('home.logo')}}" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="btn btn-ferroli btn-sm control-label" for="change-user-logo">
                                                @lang('site::messages.change') @lang('site::user.help.logo')
                                            </label>
                                            <input accept="image/jpeg" name="path" type="file"
                                                   class="d-none form-control-file" id="change-user-logo">
                                            <input type="hidden" name="storage" value="logo">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.created_at')
                                :</span>&nbsp;&nbsp;{{ $user->created_at->format('d.m.Y H:i') }}
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::region.region'):</span>&nbsp;
                            <span class="text-dark">{{ $user->region->name }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.email'):</span>&nbsp;
                            <span class="text-dark">{{ $user->email }}</span>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @permission('orders')
                        <a href="{{ route('orders.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::order.icon')"></i>
                                @lang('site::order.orders')
                            </span>
                            <span class="badge text-big @if($user->orders()->exists()) badge-ferroli @else badge-light @endif">{{$user->orders()->count()}}</span>
                        </a>
                        @endpermission()
                        @permission('distributors')
                        <a href="{{ route('distributors.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::order.distributor_icon')"></i>
                                @lang('site::order.distributors')
                            </span>
                            <span class="badge text-big @if($user->distributors()->exists()) badge-ferroli @else badge-light @endif">{{$user->distributors()->count()}}</span>
                        </a>
                        @endpermission()
                        @permission('repairs')
                        <a href="{{ route('repairs.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::repair.icon')"></i>
                                @lang('site::repair.repairs')
                            </span>
                            <span class="badge text-big @if($user->repairs()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->repairs()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('mountings')
                        <a href="{{ route('mountings.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::mounting.icon')"></i>
                                @lang('site::mounting.mountings')
                            </span>
                            <span class="badge text-big @if($user->mountings()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->mountings()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('acts')
                        <a href="{{ route('acts.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::act.icon')"></i>
                                @lang('site::act.acts')
                            </span>
                            <span class="badge text-big @if($user->acts()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->acts()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('authorizations')
                        <a href="{{ route('authorizations.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::authorization.icon')"></i>
                                @lang('site::authorization.authorizations')
                            </span>
                            <span class="badge text-big @if($user->authorizations()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->authorizations()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('mountings')
                        <a href="{{ route('mounters.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::mounter.icon')"></i>
                                @lang('site::mounter.mounters')
                            </span>
                            <span class="badge text-big @if($user->mounters()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->mounters()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('messages')
                        <a href="{{ route('messages.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::message.icon')"></i>
                                @lang('site::message.messages')
                            </span>
                            <span class="badge text-big @if($user->inbox()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->inbox()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('contracts')
                        <a href="{{ route('contracts.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::contract.icon')"></i>
                                @lang('site::contract.contracts')
                            </span>
                            <span class="badge text-big @if($user->contracts()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->contracts()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('storehouses')
                        <a href="{{ route('storehouses.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::storehouse.icon')"></i>
                                @lang('site::storehouse.storehouses')
                            </span>
                            <span class="badge text-big @if($user->storehouses()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->storehouses()->count()}}
                            </span>
                        </a>
                        @endpermission()
                        @permission('engineers')
                        <a href="{{ route('engineers.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::engineer.icon')"></i>
                                @lang('site::engineer.engineers')
                            </span>
                            <span class="badge text-big @if($user->engineers()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->engineers()->count()}}
                            </span>
                        </a>
                        @endpermission
                        @permission('trades')
                        <a href="{{ route('trades.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::trade.icon')"></i>
                                @lang('site::trade.trades')
                            </span>
                            <span class="badge text-big @if($user->trades()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->trades()->count()}}
                            </span>
                        </a>
                        @endpermission
                        @permission('contragents')
                        <a href="{{ route('contragents.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::contragent.icon')"></i>
                                @lang('site::contragent.contragents')
                            </span>
                            <span class="badge text-big @if($user->contragents()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->contragents()->count()}}
                            </span>
                        </a>
                        @endpermission
                        @permission('contacts')
                        <a href="{{ route('contacts.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::contact.icon')"></i>
                                @lang('site::contact.contacts')
                            </span>
                            <span class="badge text-big @if($user->contacts()->exists()) badge-ferroli @else badge-light @endif">{{$user->contacts()->count()}}</span>
                        </a>
                        @endpermission()
                        @permission('addresses')
                        <a href="{{ route('addresses.index') }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::address.icon')"></i>
                                @lang('site::address.addresses')
                            </span>
                            <span class="badge text-big @if($user->addresses()->exists()) badge-ferroli @else badge-light @endif">{{$user->addresses()->count()}}</span>
                        </a>
                        @endpermission()
                    </div>
                </div>
            </div>
            <div class="col">
                @permission('authorizations')
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('site::authorization.request.title')</h5>
                        <p class="card-text">@lang('site::authorization.request.text')</p>
                        @foreach($authorization_roles as $authorization_role)
                            <a href="{{route('authorizations.create', $authorization_role->role)}}"
                               class="btn btn-ferroli">{{$authorization_role->name}}</a>
                        @endforeach
                    </div>
                </div>
                @endpermission()
                @permission('storehouses.excel')
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('site::storehouse.header.quantity')</h5>

                        <a href="{{route('storehouses.excel')}}" class="btn btn-primary">
                            <i class="fa fa-upload"></i>
                            @lang('site::storehouse.header.download')
                        </a>
                    </div>
                </div>
                @endpermission()
                @permission('ferroli_contacts')
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('site::home.ferroli_contacts_h') </h5>
                        @lang('site::home.ferroli_contacts_w')
                        @lang('site::home.ferroli_contacts_text')
                    </div>
                </div>
                @endpermission()
                @permission('mountings')
                @if($user->digiftUser()->exists())
                    @include('site::digift_bonus.index', ['digiftUser' => $user->digiftUser])
                @endif
                @endpermission()
                @permission('engineers')

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('site::certificate.header.mounting') </h5>
                        @if($user->mountingCertificates()->exists())
                            <a class="btn btn-success" href="{{route('certificates.show', $user->mountingCertificates()->first())}}">
                                <i class="fa fa-download"></i>
                                @lang('site::certificate.button.download')
                            </a>
                        @else
                            <form action="{{route('certificates.store')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}"/>
                                    <span class="invalid-feedback">{!! $errors->first('email') !!}</span>
                                </div>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-download"></i>
                                    @lang('site::certificate.button.get')
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endpermission()
            </div>
        </div>
    </div>
@endsection
