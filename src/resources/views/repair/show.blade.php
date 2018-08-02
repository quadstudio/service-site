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
            <li class="breadcrumb-item active">{{ $repair->number }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $repair->number }} </h1>

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('repairs.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            </div>
        </div>


        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.created_at')</dt>
                    <dd class="col-sm-8">{{ $repair->created_at(true) }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.status_id')</dt>
                    <dd class="col-sm-8" style="color:{{$repair->status->color}}"><i class="fa fa-{{$repair->status->icon}}"></i> {{ $repair->status->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.number')</dt>
                    <dd class="col-sm-8">{{ $repair->number }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.warranty_number')</dt>
                    <dd class="col-sm-8">{{ $repair->warranty_number }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.warranty_period')</dt>
                    <dd class="col-sm-8">{{ $repair->warranty_period }}</dd>

                </dl>

                <hr/>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.serial_id')</dt>
                    <dd class="col-sm-8">{{ $repair->serial_id }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::serial.product_id')</dt>
                    <dd class="col-sm-8">{{ $repair->serial->product->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.sku')</dt>
                    <dd class="col-sm-8">{{ $repair->serial->product->sku }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.equipment_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('equipments.show', $repair->serial->product->equipment)}}">
                            {{ $repair->serial->product->equipment->catalog->parentTreeName() }} {{ $repair->serial->product->equipment->name }}
                        </a>
                    </dd>

                </dl>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.payment')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.allow_work')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_work == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.allow_road')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_road == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.allow_parts')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_parts == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_work')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_work())}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_road')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_road())}}</dd>

                    <dt class="col-sm-4  text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_parts())}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::part.parts')</dt>
                    <dd class="col-sm-8">
                        @foreach($repair->parts as $part)
                            <div class="row">
                                <div class="col-8">{{$part->product->name()}}
                                    x {{$part->count}} {{$part->product->unit}}</div>
                                <div class="col-4 text-right text-danger">{{Site::format($part->total)}}</div>
                            </div>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4 text-right border-top">Итого к оплате</dt>
                    <dd class="col-sm-8 text-right border-sm-top border-top-0">{{ Site::format($repair->cost_total())}}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.client')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.client')</dt>
                    <dd class="col-sm-8">{{ $repair->client }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.country_id')</dt>
                    <dd class="col-sm-8">{{ $repair->country->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.address')</dt>
                    <dd class="col-sm-8">{{ $repair->address }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.phone_primary')</dt>
                    <dd class="col-sm-8">{{ $repair->phone_primary }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.phone_secondary')</dt>
                    <dd class="col-sm-8">{{ $repair->phone_secondary }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.org')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.trade_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('trades.show', $repair->trade)}}">{{ $repair->trade->name }}</a></dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.date_trade')</dt>
                    <dd class="col-sm-8">{{ $repair->date_trade() }}</dd>


                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.launch_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('launches.show', $repair->launch)}}">{{ $repair->launch->name }}</a></dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.date_launch')</dt>
                    <dd class="col-sm-8">{{ $repair->date_launch() }}</dd>


                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.call')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.engineer_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('engineers.show', $repair->engineer)}}">{{ $repair->engineer->name }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.date_call')</dt>
                    <dd class="col-sm-8">{{ $repair->date_call() }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.reason_call')</dt>
                    <dd class="col-sm-8">{!! $repair->reason_call !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.diagnostics')</dt>
                    <dd class="col-sm-8">{!! $repair->diagnostics !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.works')</dt>
                    <dd class="col-sm-8">{!! $repair->works !!}</dd>

                    <dt class="col-sm-4">@lang('site::repair.date_repair')</dt>
                    <dd class="col-sm-8">{{ $repair->date_repair() }}</dd>

                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('site::file.files')</h5>
                <dl class="row">
                    <dd class="col">@include('site::repair.files')</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
