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
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::user.icon')"></i> {{ $user->name }}</h1>
        @alert()@endalert

        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.users.edit', $user) }}"
               class="d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 btn-ferroli">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::user.user')</span>
            </a>
            <a href="{{ route('admin.users.password.create', $user) }}"
               class="d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 btn-ferroli">
                <i class="fa fa-user-secret"></i>
                <span>@lang('site::messages.change') @lang('site::user.password')</span>
            </a>
            <a href="{{ route('admin.users.schedule', $user) }}"
               class="@cannot('schedule', $user) disabled @endcannot d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 btn btn-ferroli">
                <i class="fa fa-@lang('site::schedule.icon')"></i>
                <span>@lang('site::schedule.synchronize')</span>
            </a>
            <a href="{{ route('admin.users.prices.index', $user) }}"
               class="d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 btn btn-ferroli">
                <i class="fa fa-@lang('site::user_price.icon')"></i>
                <span>@lang('site::user_price.user_price')</span>
            </a>
            <a href="{{ route('admin.users.force', $user) }}"
               class="d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 btn-warning">
                <i class="fa fa-sign-in"></i>
                <span>@lang('site::user.force_login')</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="d-block d-sm-inline-block btn mb-1 btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <!-- Side info -->
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="media">
                            <img id="user-logo" src="{{$user->logo}}" style="width:100px!important;height: 100px"
                                 class="rounded-circle">
                            <div class="media-body pt-2 ml-3">
                                <h5 class="mb-2">{{ $user->name }} @include('site::admin.user.component.online')</h5>
                            </div>
                        </div>
                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body">

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.email')
                                :</span>&nbsp;&nbsp;{{ $user->email }}
                        </div>
                        @if($user->orders()->count() > 0)
                            <div class="mb-2">
                            <span class="text-muted">@lang('site::repair.help.last')
                                :</span>&nbsp;&nbsp;
                                @if($user->repairs()->count() > 0)
                                    <a href="{{route('admin.repairs.show', $user->repairs()->latest()->first())}}">{{ $user->repairs()->latest()->first()->created_at->format('d.m.Y H:i') }}</a>
                                @endif
                            </div>
                        @endif
                        @if($user->orders()->count() > 0)
                            <div class="mb-2">
                            <span class="text-muted">@lang('site::order.help.last')
                                :</span>&nbsp;&nbsp;
                                @if($user->orders()->count() > 0)
                                    <a href="{{route('admin.orders.show', $user->orders()->latest()->first())}}">{{ $user->orders()->latest()->first()->created_at->format('d.m.Y H:i') }}</a>
                                @endif
                            </div>
                        @endif
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.currency_id'):</span>&nbsp;
                            <span class="text-dark">{{ $user->currency->title }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.region_id'):</span>&nbsp;
                            <span class="text-dark">{{ optional($user->region)->name }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.guid'):</span>&nbsp;
                            <span class="text-dark">{{ $user->guid }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.created_at')
                                :</span>&nbsp;&nbsp;{{ optional($user->created_at)->format('d.m.Y H:i') }}
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.logged_at')
                                :</span>&nbsp;&nbsp;{{ $user->logged_at ? $user->logged_at->format('d.m.Y H:i') : trans('site::messages.did_not_come') }}
                        </div>

                        <div class="my-2">
                            <span class="d-block text-normal @if($user->active) text-success @else text-danger @endif">
                                @lang('site::user.active_'.($user->active))
                            </span>
                            <span class="d-block text-normal @if($user->verified) text-success @else text-danger @endif">
                                @lang('site::user.verified_'.($user->verified))
                            </span>
                            <span class="d-block text-normal @if($user->display) text-success @else text-danger @endif">
                                @lang('site::user.display_'.($user->display))
                            </span>
                            <span class="d-block text-normal @if($user->only_ferroli) text-success @else text-danger @endif">
                                @lang('site::user.only_ferroli_'.($user->only_ferroli))
                            </span>
                        </div>

                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body">
                        <h4>@lang('rbac::role.roles')</h4>
                        @foreach($roles as $role)
                            <span class="d-block text-normal @if($user->hasRole($role->name)) text-success @else text-danger @endif">
                                @if($user->hasRole($role->name)) ✔ @else ✖ @endif {{$role->title}}
                            </span>
                        @endforeach
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.repairs.index', ['filter[user_id]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::repair.icon')"></i>
                                 <span>@lang('site::repair.repairs')</span>
                            </span>
                            <span class="badge text-big @if($user->repairs()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->repairs()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.mountings.index', ['filter[user_id]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::mounting.icon')"></i>
                                 <span>@lang('site::mounting.mountings')</span>
                            </span>
                            <span class="badge text-big @if($user->mountings()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->mountings()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.authorizations.index', ['filter[user_id]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::authorization.icon')"></i>
                                 <span>@lang('site::authorization.authorizations')</span>
                            </span>
                            <span class="badge text-big @if($user->authorizations()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->authorizations()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.orders.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::order.icon')"></i>
                                 <span>@lang('site::order.orders')</span>
                            </span>
                            <span class="badge text-big @if($user->orders()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->orders()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.contracts.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::contract.icon')"></i>
                                 <span>@lang('site::contract.contracts')</span>
                            </span>
                            <span class="badge text-big @if($user->contracts()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->contracts()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.contragents.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::contragent.icon')"></i>
                                 <span>@lang('site::contragent.contragents')</span>
                            </span>
                            <span class="badge text-big @if($user->contragents()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->contragents()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.storehouses.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::storehouse.icon')"></i>
                                 <span>@lang('site::storehouse.storehouses')</span>
                            </span>
                            <span class="badge text-big @if($user->storehouses()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->storehouses()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.addresses.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::address.icon')"></i>
                                 <span>@lang('site::address.addresses')</span>
                            </span>
                            <span class="badge text-big @if($user->addresses()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->addresses()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.contacts.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::contact.icon')"></i>
                                 <span>@lang('site::contact.contacts')</span>
                            </span>
                            <span class="badge text-big @if($user->contacts()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->contacts()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.engineers.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::engineer.icon')"></i>
                                 <span>@lang('site::engineer.engineers')</span>
                            </span>
                            <span class="badge text-big @if($user->engineers()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->engineers()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.trades.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::trade.icon')"></i>
                                 <span>@lang('site::trade.trades')</span>
                            </span>
                            <span class="badge text-big @if($user->trades()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->trades()->count()}}
                            </span>
                        </a>
                        <a href="{{ route('admin.contragents.index', ['filter[user]='.$user->id]) }}"
                           class="py-2 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-@lang('site::contragent.icon')"></i>
                                 <span>@lang('site::contragent.contragents')</span>
                            </span>
                            <span class="badge text-big @if($user->contragents()->exists()) badge-ferroli @else badge-light @endif">
                                {{$user->contragents()->count()}}
                            </span>
                        </a>
                    </div>

                </div>
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::schedule.schedules')</span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{ route('admin.users.schedule', $user) }}"
                               class="@cannot('schedule', $user) disabled @endcannot btn btn-sm btn-light">
                                <i class="fa fa-@lang('site::schedule.icon')"></i>
                            </a>
                        </div>
                    </h6>
                    @include('site::schedule.index', ['schedules' => $user->schedules])
                </div>
            </div>
            <div class="col">
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">@lang('site::authorization.authorizations')</h5>
                        <table class="table bg-white table-sm table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col"></th>
                                @foreach($authorization_roles as $authorization_role)
                                    <th class="text-center" scope="col">{{$authorization_role->name}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($authorization_types as $authorization_type)
                                <tr>
                                    <td class="text-right">{{$authorization_type->name}} {{$authorization_type->brand->name}}</td>
                                    @foreach($authorization_roles as $authorization_role)
                                        <td class="text-center">
                                            @if($authorization_accepts->contains(function ($accept) use ($authorization_role, $authorization_type) {
                                                return $accept->type_id == $authorization_type->id && $accept->role_id == $authorization_role->role_id;
                                            }))
                                                <span class="badge text-normal badge-success"><i
                                                            class="fa fa-check"></i></span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($user->digiftUser()->exists())
                    @include('site::admin.user.digift_bonus.index', ['digiftUser' => $user->digiftUser])
                @else
                    <div class="alert alert-warning" role="alert">
                        @lang('site::digift_user.help.digift_user_not_exists')
                    </div>
                @endif
                @foreach($contacts as $contact)
                    <div class="card mb-2">
                        <div class="card-body">
                            <dl class="row">

                                <dt class="col-sm-4 text-left text-sm-right">@lang('site::user.header.contact')</dt>
                                <dd class="col-sm-8">{{ $contact->name }}</dd>

                                <dt class="col-sm-4 text-left text-sm-right">@lang('site::contact.position')</dt>
                                <dd class="col-sm-8">{{ $contact->position }}</dd>

                                <dt class="col-sm-4 text-left text-sm-right">@lang('site::contact.type_id')</dt>
                                <dd class="col-sm-8">{{ $contact->type->name }}</dd>

                                <dt class="col-sm-4 text-left text-sm-right">@lang('site::phone.phones')</dt>
                                <dd class="col-sm-8">
                                    @if(($phones = $contact->phones)->isNotEmpty())
                                        <ul>
                                            @foreach($phones as $phone)
                                                <li>{{$phone->country->phone}} {{$phone->number}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </dd>

                            </dl>

                        </div>
                    </div>
                @endforeach
                @foreach($addresses as $address)
                    <div class="card mb-2">
                        <div class="card-body">

                            <dl class="row">

                                <dt class="col-sm-4 text-left text-sm-right">{{ $address->type->name }}</dt>
                                <dd class="col-sm-8"><a
                                            href="{{route('admin.addresses.show', $address)}}">{{ $address->full }}</a>
                                </dd>

                                <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.name')</dt>
                                <dd class="col-sm-8">{{ $address->name }}</dd>

                                <dt class="col-sm-4 text-left text-sm-right">@lang('site::phone.phones')</dt>
                                <dd class="col-sm-8">

                                    @if(($phones = $address->phones)->isNotEmpty())
                                        <ul>
                                            @foreach($phones as $phone)
                                                <li>{{$phone->country->phone}} {{$phone->number}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </dd>
                                <dt class="col-sm-4 text-left text-sm-right"></dt>
                                <dd class="col-sm-8">
                                    @if(( $address->is_service ))<span
                                            class="badge text-normal mb-0 mb-sm-1 badge-ferroli">Сервис</span> @endif
                                    @if(( $address->is_shop ))<span
                                            class="badge text-normal mb-0 mb-sm-1 badge-ferroli">Торговая точка</span> @endif
                                    @if(( $address->is_eshop ))<span
                                            class="badge text-normal mb-0 mb-sm-1 badge-ferroli">Интернет-магазин</span> @endif
                                    @if(( $address->is_mounter ))<span
                                            class="badge text-normal mb-0 mb-sm-1 badge-ferroli">Монтажник</span> @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                @endforeach
                @include('site::message.comment', ['commentBox' => $commentBox])
            </div>
        </div>


    </div>
@endsection
