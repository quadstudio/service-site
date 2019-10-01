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
                <a href="{{ route('admin.acts.index') }}">@lang('site::act.acts')</a>
            </li>
            <li class="breadcrumb-item active">№ {{$act->id}}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::act.header.act') № {{$act->id}}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.acts.edit', $act) }}"
               class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit')</span>
            </a>
            <a href="{{ route('admin.acts.schedule', $act) }}"
               class="@cannot('schedule', $act) disabled @endcannot d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-@lang('site::schedule.icon')"></i>
                <span>@lang('site::schedule.synchronize')</span>
            </a>
            <a href="{{ route('acts.pdf', $act) }}"
               class="@cannot('pdf', $act) disabled @endcannot d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
                <i class="fa fa-print"></i>
                <span>@lang('site::messages.print')</span>
            </a>
            <a href="{{ route('admin.acts.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::act.help.back_list')</span>
            </a>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::act.header.info')</span>
                    </h6>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::act.created_at'):</span>&nbsp;
                            <span class="text-dark">{{$act->created_at->format('d.m.Y H:i' )}}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::act.user_id'):</span>&nbsp;
                            <span class="text-dark">
                                <a href="{{route('admin.users.show', $act->user)}}">{{ $act->user->name }}</a>
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::act.type_id'):</span>&nbsp;
                            <span class="text-dark">{{$act->type->name}}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::act.received'):</span>&nbsp;
                            <span class="text-dark">@bool(['bool' => $act->received])@endbool</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::act.paid'):</span>&nbsp;
                            <span class="text-dark">@bool(['bool' => $act->paid])@endbool</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::act.number'):</span>&nbsp;
                            <span class="text-dark">{{ $act->number }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::act.guid'):</span>&nbsp;
                            <span class="text-dark">{{ $act->guid }}</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::repair.header.payment')</span>
                    </h6>
                    <div class="card-body">
                        <dl class="row">
                            @include('site::admin.act.show.cost.'.$act->type->alias)
                        </dl>
                    </div>
                    <div class="card-footer">
                        <b>@lang('site::act.help.total')</b>: {{ Site::format($act->total) }}
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header with-elements">
                        <div class="card-header-title">@lang('site::schedule.schedules')</div>
                        <div class="card-header-elements ml-auto">
                            <a href="{{ route('admin.acts.schedule', $act) }}"
                               class="@cannot('schedule', $act) disabled @endcannot btn btn-sm btn-light">
                                <i class="fa fa-@lang('site::schedule.icon')"></i>
                            </a>
                        </div>
                    </div>
                    @include('site::schedule.index', ['schedules' => $act->schedules])
                    @cannot('schedule', $act)
                        <div class="card-footer">
                            <div class="font-weight-bold text-danger">@lang('site::schedule.error')</div>
                        </div>
                    @endcannot
                </div>
            </div>
            <div class="col-xl-8">
                @include('site::admin.act.show.contents.'.$act->type->alias)

                <div class="card mb-2">
                    <h6 class="card-header">@lang('site::act.header.detail_1')</h6>
                    <div class="card-body">
                        @php $detail = $act->details()->whereOur(1)->first() @endphp
                        @include('site::admin.act.show.detail')
                    </div>

                </div>

                <div class="card mb-4">
                    <h6 class="card-header">@lang('site::act.header.detail_0')</h6>
                    <div class="card-body">
                        @php $detail = $act->details()->whereOur(0)->first() @endphp
                        @include('site::admin.act.show.detail')
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
