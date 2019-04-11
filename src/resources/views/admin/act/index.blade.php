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
            <li class="breadcrumb-item active">@lang('site::act.acts')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.acts.create') }}"
               role="button">
                <i class="fa fa-magic"></i>
                <span>@lang('site::messages.create') @lang('site::act.act')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $acts])@endpagination
        {{$acts->render()}}
        @foreach($acts as $act)
            <div class="card my-4" id="act-{{$act->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('admin.acts.show', $act)}}">
                            @lang('site::act.help.avr') № {{$act->id}}
                        </a>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        <span class="px-2 bg-light text-big">
                            <i class="fa fa-@lang('site::'.$act->type->lang.'.icon')"></i>
                            {{$act->type->name}}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0">
                            <dt class="col-12">@lang('site::act.created_at')</dt>
                            <dd class="col-12">{{$act->created_at->format('d.m.Y H:i')}}</dd>
                            <dt class="col-12">@lang('site::messages.total')</dt>
                            <dd class="col-12">
                                {{number_format($act->total, 0, '.', ' ')}}
                                {{ $act->user->currency->symbol_right }}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0">
                            <dt class="col-12">@lang('site::act.user_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.users.show', $act->user)}}">{{$act->user->name}}</a>
                                <div class="text-muted">{{ $act->user->address()->region->name }}
                                    / {{ $act->user->address()->locality }}</div>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        @if($act->schedules->isNotEmpty())
                            <dl class="dl-horizontal mt-sm-2 mt-0">
                                <dt class="col-12">@lang('site::schedule.schedules')</dt>
                                <dd class="col-12">
                                    @foreach($act->schedules as $schedule)
                                        {{$schedule->status()->first()->name}}
                                        <i class="fa fa-{{$schedule->status()->first()->icon}}
                                                text-{{$schedule->status()->first()->color}}"></i>
                                    @endforeach
                                </dd>
                            </dl>
                        @endif
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0">
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::act.user.received_'.$act->received)
                                <span>@bool(['bool' => $act->received == 1])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::act.user.paid_'.$act->paid)
                                <span>@bool(['bool' => $act->paid == 1])@endbool</span>
                            </dt>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$acts->render()}}
    </div>
@endsection
