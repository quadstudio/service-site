@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::act.acts')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $acts])@endpagination
        {{$acts->render()}}
        @foreach($acts as $act)
            <div class="card my-4" id="act-{{$act->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('acts.show', $act)}}">
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
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0">
                            <dt class="col-12">@lang('site::act.contragent_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('contragents.show', $act->contragent)}}">{{$act->contragent->name}}</a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0">

                            <dt class="col-12">@lang('site::messages.total')</dt>
                            <dd class="col-12">
                                {{number_format($act->total, 0, '.', ' ')}}
                                {{ $act->user->currency->symbol_right }}
                            </dd>
                        </dl>
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
