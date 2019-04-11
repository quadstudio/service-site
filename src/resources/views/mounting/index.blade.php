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
            <li class="breadcrumb-item active">@lang('site::mounting.mountings')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::mounting.icon')"></i> @lang('site::mounting.mountings')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('mountings.create') }}"
               role="button">
                <i class="fa fa-magic"></i>
                <span>@lang('site::messages.create') @lang('site::mounting.mounting')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('acts.create') }}"
               role="button">
                <i class="fa fa-magic"></i>
                <span>@lang('site::messages.create') @lang('site::act.act')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $mountings])@endpagination
        {{$mountings->render()}}

        @foreach($mountings as $mounting)
            <div class="card my-4" id="mounting-{{$mounting->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <span class="badge text-normal badge-pill badge-{{ $mounting->status->color }}">
                            <i class="fa fa-{{ $mounting->status->icon }}"></i> {{ $mounting->status->name }}
                        </span>
                        <a href="{{route('mountings.show', $mounting)}}" class="ml-3">
                            @lang('site::mounting.header.mounting') № {{$mounting->id}}
                        </a>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        @if($mounting->act)
                            <a href="{{route('admin.acts.show', $mounting->act)}}">
                                <span class="text-normal badge badge-pill @if($mounting->act->received && $mounting->act->paid) badge-success @else badge-warning @endif">
                                    @lang('site::act.help.avr') № {{ $mounting->act->id }}
                                    <span data-toggle="tooltip" data-placement="top"
                                          title="@lang('site::act.user.received_'.($mounting->act->received))">
                                        @component('site::components.bool.check', ['bool' => $mounting->act->received])@endcomponent
                                    </span>
                                    <span data-toggle="tooltip" data-placement="top"
                                          title="@lang('site::act.user.paid_'.($mounting->act->paid))">
                                        @component('site::components.bool.check', ['bool' => $mounting->act->paid])@endcomponent
                                    </span>
                                </span>
                            </a>
                        @endif
                        @if( $mounting->messages()->exists())
                            <span class="badge badge-secondary text-normal badge-pill">
                                <i class="fa fa-comment"></i> {{ $mounting->messages()->count() }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-md-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounting.created_at')</dt>
                            <dd class="col-12">{{$mounting->created_at->format('d.m.Y')}}</dd>
                            <dt class="col-12">@lang('site::mounting.date_mounting')</dt>
                            <dd class="col-12">{{$mounting->date_mounting->format('d.m.Y')}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-2 col-md-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounting.product_id')</dt>
                            <dd class="col-12">{{$mounting->product->name}}</dd>
                            <dt class="col-12">@lang('site::mounting.serial_id')</dt>
                            <dd class="col-12">{{$mounting->serial_id}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-4 col-md-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounting.client')</dt>
                            <dd class="col-12">{{$mounting->client}}</dd>
                            <dt class="col-12">@lang('site::mounting.address')</dt>
                            <dd class="col-12">{{$mounting->address}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-4 col-md-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounting.bonus')</dt>
                            <dd class="col-12">
                                {{number_format($mounting->bonus, 0, '.', ' ')}}
                                {{ $mounting->user->currency->symbol_right }}
                            </dd>
                            <dt class="col-12">@lang('site::mounting.social_bonus')</dt>
                            <dd class="col-12">
                                {{number_format($mounting->enabled_social_bonus, 0, '.', ' ')}}
                                {{ $mounting->user->currency->symbol_right }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$mountings->render()}}
    </div>
@endsection
