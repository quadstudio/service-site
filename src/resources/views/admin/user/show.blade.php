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
        <h1 class="header-titlemb-4"><i class="fa fa-@lang('site::user.icon')"></i> {{ $user->name }}</h1>
        <div class="row">
            <div class="col-xl-4">
                <!-- Side info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="media">
                            <img style="background-image: url('http://placehold.it/60x60');width:60px!important;height: 60px"
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

                                {{--<div class="mt-3">--}}
                                {{--<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-round">+&nbsp; Follow</a>--}}
                                {{--&nbsp;--}}
                                {{--<a href="javascript:void(0)" class="btn icon-btn btn-default btn-sm md-btn-flat btn-round">--}}
                                {{--<span class="ion ion-md-mail"></span>--}}
                                {{--</a>--}}
                                {{--</div>--}}
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
                            <a href="javascript:void(0)" class="text-dark">
                                <img style="width: 30px;" class="img-fluid border"
                                     src="{{ asset($user->address()->country->flag) }}"
                                     alt=""> {{ $user->address()->country->name }}
                            </a>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::address.region_id'):</span>&nbsp;
                            <a href="javascript:void(0)"
                               class="text-dark">{{ $user->address()->region->name }}</a>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::address.locality'):</span>&nbsp;
                            <a href="javascript:void(0)" class="text-dark">{{ $user->address()->locality }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
