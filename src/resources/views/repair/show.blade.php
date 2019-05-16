@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('repairs.index') }}">@lang('site::repair.repairs')</a>
            </li>
            <li class="breadcrumb-item active">№ {{ $repair->id }}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::repair.header.repair') № {{ $repair->id }}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-4">
            @if($statuses->isNotEmpty())
                <a href="{{route('repairs.edit', $repair)}}"
                   class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit') @lang('site::repair.repair')</span>
                </a>
            @endif
            <a href="{{ route('repairs.pdf', $repair) }}"
               class="@cannot('pdf', $repair) disabled @endcannot d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
                <i class="fa fa-print"></i>
                <span>@lang('site::messages.print')</span>
            </a>
            <a href="{{ route('repairs.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        @include('site::message.create', ['messagable' => $repair])
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.created_at')</dt>
                    <dd class="col-sm-8">{{ $repair->created_at->format('d.m.Y') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.status_id')</dt>
                    <dd class="col-sm-8">
                        <span class="badge text-normal badge-{{$repair->status->color}}">
                            <i class="fa fa-{{$repair->status->icon}}"></i>
                            {{ $repair->status->name }}
                        </span>
                    </dd>
                </dl>

                <hr/>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.serial_id')</dt>
                    <dd class="col-sm-8">{{ $repair->serial_id }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::serial.product_id')</dt>
                    <dd class="col-sm-8">{{ $repair->product->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.sku')</dt>
                    <dd class="col-sm-8">{{ $repair->product->sku }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.equipment_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('equipments.show', $repair->product->equipment)}}">
                            {{ $repair->product->equipment->catalog->name_plural }} {{ $repair->product->equipment->name }}
                        </a>
                    </dd>

                </dl>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.payment')</h5>
                <dl class="row">

                    <dt class="@if($fails->contains('field', 'contragent_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.contragent_id')</dt>
                    <dd class="col-sm-8">{{ $repair->contragent->name }}</dd>

                    <dt class="@if($fails->contains('field', 'distance_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.distance_id')</dt>
                    <dd class="col-sm-8">{{ $repair->distance->name }}</dd>

                    <dt class="@if($fails->contains('field', 'difficulty_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.difficulty_id')</dt>
                    <dd class="col-sm-8">{{ $repair->difficulty->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_distance')</dt>
                    <dd class="col-sm-8">{{ Site::format($repair->cost_distance())}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_difficulty')</dt>
                    <dd class="col-sm-8">{{ Site::format($repair->cost_difficulty())}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                    <dd class="col-sm-8">{{ Site::format($repair->cost_parts())}}</dd>

                    <dt class="@if($fails->contains('field', 'parts')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::part.parts')</dt>
                    <dd class="col-sm-8">
                        @foreach($repair->parts as $part)
                            <div class="row">
                                <div class="col-4 text-info">{{Site::format($part->total)}}</div>
                                <div class="col-8">{!! $part->product->name()!!}
                                    x {{$part->count}} {{$part->product->unit}}</div>

                            </div>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right border-top">@lang('site::repair.help.total')</dt>
                    <dd class="col-sm-8 border-sm-top border-top-0">{{ Site::format($repair->totalCost)}}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.client')</h5>
                <dl class="row">

                    <dt class="@if($fails->contains('field', 'client')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.client')</dt>
                    <dd class="col-sm-8">{{ $repair->client }}</dd>

                    <dt class="@if($fails->contains('field', 'address')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.address')</dt>
                    <dd class="col-sm-8">{{ $repair->address }}</dd>

                    <dt class="@if($fails->contains('field', 'phone_primary')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.phone_primary')</dt>
                    <dd class="col-sm-8">
                        {{ $repair->country->phone }}
                        {{ $repair->phone_primary }}
                    </dd>

                    <dt class="@if($fails->contains('field', 'phone_secondary')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.phone_secondary')</dt>
                    <dd class="col-sm-8">
                        @if($repair->phone_secondary)
                            {{ $repair->country->phone }}
                            {{ $repair->phone_secondary }}
                        @endif
                    </dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.org')</h5>
                <dl class="row">

                    <dt class="@if($fails->contains('field', 'trade_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.trade_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('trades.edit', $repair->trade)}}">{{ $repair->trade->name }}</a>
                    </dd>

                    <dt class="@if($fails->contains('field', 'date_trade')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_trade')</dt>
                    <dd class="col-sm-8">{{ $repair->date_trade->format('d.m.Y') }}</dd>


                    <dt class="@if($fails->contains('field', 'launch_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.launch_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('launches.edit', $repair->launch)}}">{{ $repair->launch->name }}</a>
                    </dd>

                    <dt class="@if($fails->contains('field', 'date_launch')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_launch')</dt>
                    <dd class="col-sm-8">{{ $repair->date_launch->format('d.m.Y') }}</dd>


                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.call')</h5>
                <dl class="row">

                    <dt class="@if($fails->contains('field', 'engineer_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.engineer_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('engineers.edit', $repair->engineer)}}">{{ $repair->engineer->name }}</a>
                    </dd>

                    <dt class="@if($fails->contains('field', 'date_call')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_call')</dt>
                    <dd class="col-sm-8">{{ $repair->date_call->format('d.m.Y') }}</dd>

                    <dt class="@if($fails->contains('field', 'reason_call')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.reason_call')</dt>
                    <dd class="col-sm-8">{!! $repair->reason_call !!}</dd>

                    <dt class="@if($fails->contains('field', 'diagnostics')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.diagnostics')</dt>
                    <dd class="col-sm-8">{!! $repair->diagnostics !!}</dd>

                    <dt class="@if($fails->contains('field', 'works')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.works')</dt>
                    <dd class="col-sm-8">{!! $repair->works !!}</dd>

                    <dt class="@if($fails->contains('field', 'date_repair')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_repair')</dt>
                    <dd class="col-sm-8">{{ $repair->date_repair->format('d.m.Y') }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.files')</h5>
                @include('site::file.files')
            </div>
        </div>

    </div>
@endsection
