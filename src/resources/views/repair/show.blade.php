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
        @alert()@endalert()
        <div class=" border p-3 mb-4">
            @if($statuses->isNotEmpty())
                <a href="{{route('repairs.edit', $repair)}}"
                   class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit') @lang('site::repair.repair')</span>
                </a>
            @endif
            @if($repair->messages->isNotEmpty())
                <a href="#messages-list" class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-@lang('site::message.icon')"></i>
                    <span>@lang('site::messages.show') @lang('site::message.messages') <span
                                class="badge badge-light">{{$repair->messages()->count()}}</span></span>
                </a>
            @endif
            <a href="{{ route('repairs.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.created_at')</dt>
                    <dd class="col-sm-8">{{ $repair->created_at(true) }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.status_id')</dt>
                    <dd class="col-sm-8" style="color:{{$repair->status->color}}"><i
                                class="fa fa-{{$repair->status->icon}}"></i> {{ $repair->status->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'number')) bg-danger text-white @endif">@lang('site::repair.number')</dt>
                    <dd class="col-sm-8">{{ $repair->number }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'warranty_number')) bg-danger text-white @endif">@lang('site::repair.warranty_number')</dt>
                    <dd class="col-sm-8">{{ $repair->warranty_number }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'warranty_period')) bg-danger text-white @endif">@lang('site::repair.warranty_period')</dt>
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

                    <dt class="@if($fails->contains('field', 'allow_work')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.allow_work')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_work == 1])@endbool</dd>

                    <dt class="@if($fails->contains('field', 'allow_road')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.allow_road')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_road == 1])@endbool</dd>

                    <dt class="@if($fails->contains('field', 'allow_parts')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.allow_parts')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_parts == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_work')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_work())}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_road')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_road())}}</dd>

                    <dt class="col-sm-4  text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_parts())}}</dd>

                    <dt class="@if($fails->contains('field', 'parts')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::part.parts')</dt>
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

                    <dt class="@if($fails->contains('field', 'client')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.client')</dt>
                    <dd class="col-sm-8">{{ $repair->client }}</dd>

                    <dt class="@if($fails->contains('field', 'country')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.country_id')</dt>
                    <dd class="col-sm-8">{{ $repair->country->name }}</dd>

                    <dt class="@if($fails->contains('field', 'address')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.address')</dt>
                    <dd class="col-sm-8">{{ $repair->address }}</dd>

                    <dt class="@if($fails->contains('field', 'phone_primary')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.phone_primary')</dt>
                    <dd class="col-sm-8">{{ $repair->phone_primary }}</dd>

                    <dt class="@if($fails->contains('field', 'phone_secondary')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.phone_secondary')</dt>
                    <dd class="col-sm-8">{{ $repair->phone_secondary }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.org')</h5>
                <dl class="row">

                    <dt class="@if($fails->contains('field', 'trade_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.trade_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('trades.show', $repair->trade)}}">{{ $repair->trade->name }}</a></dd>

                    <dt class="@if($fails->contains('field', 'date_trade')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_trade')</dt>
                    <dd class="col-sm-8">{{ $repair->date_trade() }}</dd>


                    <dt class="@if($fails->contains('field', 'launch_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.launch_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('launches.show', $repair->launch)}}">{{ $repair->launch->name }}</a></dd>

                    <dt class="@if($fails->contains('field', 'date_launch')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_launch')</dt>
                    <dd class="col-sm-8">{{ $repair->date_launch() }}</dd>


                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.call')</h5>
                <dl class="row">

                    <dt class="@if($fails->contains('field', 'engineer_id')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.engineer_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('engineers.show', $repair->engineer)}}">{{ $repair->engineer->name }}</a>
                    </dd>

                    <dt class="@if($fails->contains('field', 'date_call')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_call')</dt>
                    <dd class="col-sm-8">{{ $repair->date_call() }}</dd>

                    <dt class="@if($fails->contains('field', 'reason_call')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.reason_call')</dt>
                    <dd class="col-sm-8">{!! $repair->reason_call !!}</dd>

                    <dt class="@if($fails->contains('field', 'diagnostics')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.diagnostics')</dt>
                    <dd class="col-sm-8">{!! $repair->diagnostics !!}</dd>

                    <dt class="@if($fails->contains('field', 'works')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.works')</dt>
                    <dd class="col-sm-8">{!! $repair->works !!}</dd>

                    <dt class="@if($fails->contains('field', 'date_repair')) bg-danger text-white @endif col-sm-4 text-left text-sm-right">@lang('site::repair.date_repair')</dt>
                    <dd class="col-sm-8">{{ $repair->date_repair() }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">@lang('site::file.files')</h5>
                <dl class="row">
                    <dd class="col">@include('site::repair.files')</dd>
                </dl>
            </div>
        </div>
        @if($repair->messages->isNotEmpty())
            <hr id="messages-list"/>
            <div class="card mt-5 mb-4">
                <div class="card-body flex-grow-1 position-relative overflow-hidden">
                    <h5 class="card-title">@lang('site::message.messages')</h5>
                    <div class="row no-gutters h-100">
                        <div class="d-flex col flex-column">
                            <div class="flex-grow-1 position-relative">

                                <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                                <div class="chat-messages p-4 ps">
                                    @foreach($repair->messages as $message)
                                        <div class="@if($message->user_id == Auth::user()->id) chat-message-right @else chat-message-left @endif mb-4">
                                            <div>
                                                <img src="{{$message->user->logo}}" style="width: 40px!important;"
                                                     class="rounded-circle" alt="">
                                                <div class="text-muted small text-nowrap mt-2">{{ $message->created_at(true) }}</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == Auth::user()->id) mr-3 @else ml-3 @endif">
                                                <div class="mb-1"><b>{{$message->user->name}}</b></div>
                                                {!! $message->text !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- / .chat-messages -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
