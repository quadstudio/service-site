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
        <div class=" border p-3 mb-4">
            @permission('repairs')
            <a href="{{ route('repairs.index') }}"
               class="d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-@lang('site::repair.icon')"></i>
                <span>@lang('site::repair.repairs') <span class="badge badge-light">{{$user->repairs()->count()}}</span></span>
            </a>
            @endpermission()
            @permission('orders')
            <a href="{{ route('orders.index') }}"
               class="d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-@lang('site::order.icon')"></i>
                <span>@lang('site::order.orders') <span
                            class="badge badge-light">{{$user->orders()->count()}}</span></span>
            </a>
            @endpermission()
        </div>
        <div class="row">
            <div class="col-xl-4">
                <!-- Side info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="media">
                            <img id="user-logo" src="{{$user->logo}}" style="width:100px!important;height: 100px"
                                 class="rounded-circle">
                            <div class="media-body pt-2 ml-3">
                                <h5 class="mb-2">{{ $user->name }}</h5>
                                <div class="text-muted small">{{ $user->type->name }}</div>

                                {{--<div class="mt-2">--}}
                                {{--<a href="javascript:void(0)" class="text-twitter">--}}
                                {{--<span class="ion ion-logo-twitter"></span>--}}
                                {{--</a>--}}
                                {{--&nbsp;&nbsp;--}}
                                {{--<a href="javascript:void(0)" class="text-facebook">--}}
                                {{--<span class="ion ion-logo-facebook"></span>--}}
                                {{--</a>--}}
                                {{--&nbsp;&nbsp;--}}
                                {{--<a href="javascript:void(0)" class="text-instagram">--}}
                                {{--<span class="ion ion-logo-instagram"></span>--}}
                                {{--</a>--}}
                                {{--</div>--}}

                                <div class="mt-3">
                                    {{--<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-round">Сменить--}}
                                    {{--логотип</a>--}}
                                    <form action="{{route('home.logo')}}" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="btn btn-primary btn-sm control-label" for="change-user-logo">Сменить
                                                логотип</label>
                                            <input accept="image/jpeg" name="path" type="file"
                                                   class="d-none form-control-file" id="change-user-logo">
                                            <input type="hidden" name="storage" value="logo">
                                        </div>
                                    </form>
                                    {{--<a href="javascript:void(0)" class="btn icon-btn btn-default btn-sm md-btn-flat btn-round">--}}
                                    {{--<span class="ion ion-md-mail"></span>--}}
                                    {{--</a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.created_at')
                                :</span>&nbsp;&nbsp;{{ $user->created_at() }}
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::address.country_id'):</span>&nbsp;
                            <span class="text-dark">
                                <img style="width: 30px;" class="img-fluid border"
                                     src="{{ asset($user->address()->country->flag) }}"
                                     alt=""> {{ $user->address()->country->name }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::address.region_id'):</span>&nbsp;
                            <span class="text-dark">{{ $user->address()->region->name }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::address.locality'):</span>&nbsp;
                            <span class="text-dark">{{ $user->address()->locality }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row no-gutters text-center mb-4">
                    @permission('contragents')
                    <a href="{{route('contragents.index')}}"
                       class="d-flex border border-right-0 col flex-column text-dark py-3">
                        <div class="font-weight-bold">{{$user->contragents()->count()}}</div>
                        <div class="text-muted ">@lang('site::contragent.contragents')
                        </div>
                    </a>
                    @endpermission()
                    @permission('contacts')
                    <a href="{{route('contacts.index', $user)}}"
                       class="d-flex border border-right-0 col flex-column text-dark py-3">
                        <div class="font-weight-bold">{{$user->contacts()->count()}}</div>
                        <div class="text-muted ">@lang('site::contact.contacts')</div>
                    </a>
                    @endpermission()
                    @permission('addresses')
                    <a href="{{route('addresses.index', $user)}}" class="d-flex border col flex-column text-dark py-3">
                        <div class="font-weight-bold">{{$user->addresses()->count()}}</div>
                        <div class="text-muted ">@lang('site::address.addresses')
                        </div>
                    </a>
                    @endpermission()
                </div>
            </div>
        </div>
    </div>
@endsection
