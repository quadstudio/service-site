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
                        {{--<div class="card-header-elements ml-auto">--}}
                        {{--<a href="#" class="btn btn-sm btn-light">--}}
                        {{--<i class="fa fa-pencil"></i>--}}
                        {{--</a>--}}
                        {{--</div>--}}
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
                            <span class="text-muted">@lang('site::act.received'):</span>&nbsp;
                            <span class="text-dark">@bool(['bool' => $act->received])@endbool</span>
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
                        {{--<div class="card-header-elements ml-auto">--}}
                        {{--<a href="#" class="btn btn-sm btn-light">--}}
                        {{--<i class="fa fa-pencil"></i>--}}
                        {{--</a>--}}
                        {{--</div>--}}
                    </h6>
                    <div class="card-body">
                        <dl class="row">

                            <dt class="col-sm-6 text-left text-sm-right">@lang('site::repair.cost_distance')</dt>
                            <dd class="col-sm-6">{{ Site::format($act->distanceCost) }}</dd>

                            <dt class="col-sm-6 text-left text-sm-right">@lang('site::repair.cost_difficulty')</dt>
                            <dd class="col-sm-6">{{ Site::format($act->difficultyCost) }}</dd>

                            <dt class="col-sm-6 text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                            <dd class="col-sm-6">{{ Site::format($act->costParts) }}</dd>

                        </dl>
                    </div>
                    <div class="card-footer">
                        <b>@lang('site::act.help.total')</b>: {{ Site::format($act->total) }}
                    </div>
                </div>

                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::schedule.schedules')</span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{ route('admin.acts.schedule', $act) }}"
                               class="@cannot('schedule', $act) disabled @endcannot btn btn-sm btn-light">
                                <i class="fa fa-@lang('site::schedule.icon')"></i>
                            </a>
                        </div>
                    </h6>
                    {{--<div class="card-body">--}}
                    <ul class="list-group list-group-flush">
                        @if($act->schedules()->count())
                            @foreach($act->schedules as $schedule)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        {{$schedule->status == 0 ? $schedule->created_at->format('d.m.Y H:i') : $schedule->updated_at->format('d.m.Y H:i')}}
                                    </div>
                                    <div @if($schedule->status == 2)
                                         data-toggle="tooltip" data-placement="top" title="{!!$schedule->message!!}"
                                            @endif>
                                        @lang('site::schedule.statuses.'.$schedule->status.'.text')
                                        <i class="fa fa-@lang('site::schedule.statuses.'.$schedule->status.'.icon')
                                                text-@lang('site::schedule.statuses.'.$schedule->status.'.color')"></i>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item d-flex justify-content-between align-items-center">@lang('site::messages.not_found')</li>
                        @endif
                    </ul>
                    {{--</div>--}}

                    @cannot('schedule', $act)
                        <div class="card-footer">
                            <div class="font-weight-bold text-danger">@lang('site::schedule.error')</div>
                        </div>
                        {{--<ul class="list-group list-group-flush text-danger">--}}
                        {{--@if(!$order->user->hasGuid())--}}
                        {{--<li class="list-group-item  bg-lighter">@lang('site::user.error.guid')</li>--}}
                        {{--@endif--}}
                        {{--@if(!$order->contragent->hasOrganization())--}}
                        {{--<li class="list-group-item  bg-lighter">@lang('site::messages.not_selected_f') @lang('site::contragent.organization_id')</li>--}}
                        {{--@endif--}}
                        {{--</ul>--}}

                        {{--<ul class="list-group list-group-flush">--}}
                        {{--<li class="list-group-item d-flex justify-content-between align-items-center">--}}
                        {{--<div class="text-muted">--}}
                        {{--@lang('site::contragent.organization_id')--}}
                        {{--</div>--}}
                        {{--<div>--}}
                        {{--@bool(['bool' => $order->contragent->hasOrganization()])@endbool--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                    @endcannot
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::repair.repairs')</span>
                        {{--<div class="card-header-elements ml-auto">--}}
                        {{--<a href="#" class="btn btn-sm btn-light">--}}
                        {{--<i class="fa fa-pencil"></i>--}}
                        {{--</a>--}}
                        {{--</div>--}}
                    </h6>
                    <div class="card-body">
                        @foreach($act->repairs as $repair)
                            <div class="row border-bottom">
                                <div class="col"><a href="{{route('admin.repairs.show', $repair)}}">{{$repair->id}}</a></div>
                                <div class="col">{{$repair->date_repair->format('d.m.Y')}}</div>
                                <div class="col">
                                    <a href="{{route('admin.products.show', $repair->product)}}">{{$repair->product->name}}</a>
                                </div>
                                <div class="col">
                                    {{Site::format($repair->totalCost)}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

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
