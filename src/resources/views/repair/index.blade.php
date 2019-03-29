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
            <li class="breadcrumb-item active">@lang('site::repair.repairs')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('repairs.create') }}"
               role="button">
                <i class="fa fa-magic"></i>
                <span>@lang('site::messages.create') @lang('site::repair.repair')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $repairs])@endpagination
        {{$repairs->render()}}
        @foreach($repairs as $repair)
            <div class="card my-4" id="repair-{{$repair->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <span data-toggle="tooltip" data-placement="top" title="@lang('site::repair.status_id')"
                              class="badge text-normal badge-pill badge-{{ $repair->status->color }}">
                            <i class="fa fa-{{ $repair->status->icon }}"></i> {{ $repair->status->name }}
                        </span>
                        <a href="{{route('repairs.show', $repair)}}" class="mx-3">
                            @lang('site::repair.header.repair') № {{$repair->id}}
                        </a>
                    </div>

                    <div class="card-header-elements ml-md-auto">
                        @if($repair->fails()->count())
                            <span data-toggle="tooltip" data-placement="top" title="@lang('site::fail.fails')"
                                  class="badge badge-danger text-normal badge-pill">
                                <i class="fa fa-exclamation-triangle"></i> {{ $repair->fails()->count() }}
                            </span>
                        @endif
                        @if( $repair->messages()->exists())
                            <span data-toggle="tooltip" data-placement="top" title="@lang('site::message.messages')"
                                  class="badge badge-secondary text-normal badge-pill">
                                <i class="fa fa-comment"></i> {{ $repair->messages()->count() }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.created_at')</dt>
                            <dd class="col-12">{{$repair->created_at->format('d.m.Y')}}</dd>
                            <dt class="col-12">@lang('site::repair.date_repair')</dt>
                            <dd class="col-12">{{$repair->date_repair->format('d.m.Y')}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.product_id')</dt>
                            <dd class="col-12">{{$repair->product->name}}</dd>
                            <dt class="col-12">@lang('site::repair.serial_id')</dt>
                            <dd class="col-12">{{$repair->serial_id}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.client')</dt>
                            <dd class="col-12">{{$repair->client}}</dd>
                            <dt class="col-12">@lang('site::repair.address')</dt>
                            <dd class="col-12">{{$repair->address}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.cost_difficulty')</dt>
                            <dd class="col-12">
                                {{number_format($repair->cost_difficulty(), 0, '.', ' ')}}
                                {{ $repair->user->currency->symbol_right }}
                            </dd>
                            <dt class="col-12">@lang('site::repair.cost_distance')</dt>
                            <dd class="col-12">
                                {{number_format($repair->cost_distance(), 0, '.', ' ')}}
                                {{ $repair->user->currency->symbol_right }}
                            </dd>
                            <dt class="col-12">@lang('site::repair.cost_parts')</dt>
                            <dd class="col-12">
                                {{number_format($repair->cost_parts(), 0, '.', ' ')}}
                                {{ $repair->user->currency->symbol_right }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$repairs->render()}}
    </div>
@endsection
