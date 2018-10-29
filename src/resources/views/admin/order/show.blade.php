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
                <a href="{{ route('admin.orders.index') }}">@lang('site::order.orders')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::order.breadcrumb_show', ['order' => $order->id, 'date' => $order->created_at(true) ])</li>
        </ol>
        <h1 class="header-title mb-4">№ {{ $order->id }}</h1>
        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.orders.schedule', $order) }}"
               class="@cannot('schedule', $order) disabled @endcannot d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-@lang('site::schedule.icon')"></i>
                <span>@lang('site::schedule.synchronize')</span>
            </a>
            @if($order->messages->isNotEmpty())
                <a href="#messages-list" role="button"
                   class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-@lang('site::message.icon')"></i>
                    <span>
                        @lang('site::messages.show') @lang('site::message.messages')
                        <span class="badge badge-light">{{$order->messages()->count()}}</span>
                    </span>
                </a>
            @endif
            <button @cannot('delete', $order) disabled @endcannot
            class="btn btn-danger btn-row-delete"
                    data-form="#order-delete-form-{{$order->id}}"
                    data-btn-delete="@lang('site::messages.delete')"
                    data-btn-cancel="@lang('site::messages.cancel')"
                    data-label="@lang('site::messages.delete_confirm')"
                    data-message="@lang('site::messages.delete_sure') @lang('site::order.order')? "
                    data-toggle="modal" data-target="#form-modal"
                    href="javascript:void(0);" title="@lang('site::messages.delete')">
                @lang('site::messages.delete')
            </button>

            <a href="{{ route('admin.orders.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            <form id="order-delete-form-{{$order->id}}"
                  action="{{route('admin.orders.destroy', $order)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::order.info')</span>
                        {{--<div class="card-header-elements ml-auto">--}}
                        {{--<a href="#" class="btn btn-sm btn-light">--}}
                        {{--<i class="fa fa-pencil"></i>--}}
                        {{--</a>--}}
                        {{--</div>--}}
                    </h6>
                    <div class="card-body">

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.created_at'):</span>&nbsp;
                            <span class="text-dark">{{\Carbon\Carbon::instance($order->created_at)->format('d.m.Y H:i' )}}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.status_id'):</span>&nbsp;
                            <span style="color:{{$order->status->color}}">
                                <i class="fa fa-{{$order->status->icon}}"></i> {{ $order->status->name }}
                            </span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.total'):</span>&nbsp;
                            <span class="text-dark text-large">{{ Site::format($order->total()) }}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.user_id'):</span>&nbsp;
                            <span class="text-dark">
                                <a href="{{route('admin.users.show', $order->user)}}">{{ $order->user->name }}</a>
                            </span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.contragent_id'):</span>&nbsp;
                            <span class="text-dark">
                                <a href="{{route('admin.contragents.show', $order->contragent)}}">{{ $order->contragent->name }}</a>
                            </span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::contragent.organization_id'):</span>&nbsp;
                            <span class="text-dark">
                                @if($order->contragent->organization)
                                    <a href="{{route('admin.organizations.show', $order->contragent->organization)}}">{{ $order->contragent->organization->name }}</a>
                                @else
                                    [ <a href="{{route('admin.contragents.edit', [$order->contragent, '#contragent_organization_id'])}}">@lang('site::messages.select')</a> ]
                                @endif

                            </span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.guid'):</span>&nbsp;
                            <span class="text-dark">{{ $order->guid }}</span>
                        </div>

                    </div>
                </div>

                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::schedule.schedules')</span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{ route('admin.orders.schedule', $order) }}"
                               class="@cannot('schedule', $order) disabled @endcannot btn btn-sm btn-light">
                                <i class="fa fa-@lang('site::schedule.icon')"></i>
                            </a>
                        </div>
                    </h6>
                    {{--<div class="card-body">--}}
                    <ul class="list-group list-group-flush">
                        @if($order->schedules()->count())
                            @foreach($order->schedules as $schedule)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        {{\Carbon\Carbon::instance($schedule->status == 0 ? $schedule->created_at : $schedule->updated_at)->format('d.m.Y H:i' )}}
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

                    @cannot('schedule', $order)
                        <div class="card-footer">
                            <div class="font-weight-bold text-danger">@lang('site::schedule.error')</div>
                        </div>
                        <ul class="list-group list-group-flush text-danger">
                            @if(!$order->user->hasGuid())
                                <li class="list-group-item  bg-lighter">@lang('site::user.error.guid')</li>
                            @endif
                            @if(!$order->contragent->hasOrganization())
                                <li class="list-group-item  bg-lighter">@lang('site::messages.not_selected_f') @lang('site::contragent.organization_id')</li>
                            @endif
                        </ul>

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
                        <span class="card-header-title">@lang('site::order.items')</span>
                        {{--<div class="card-header-elements ml-auto">--}}
                        {{--<a href="#" class="btn btn-sm btn-light">--}}
                        {{--<i class="fa fa-pencil"></i>--}}
                        {{--</a>--}}
                        {{--</div>--}}
                    </h6>
                    <div class="card-body">
                        {{--<h5 class="card-title">@lang('site::order.items')</h5>--}}
                        @foreach($order->items as $item)
                            <hr class="m-1"/>
                            <div class="row mb-sm-1">

                                <div class="col-sm-1 d-none d-md-block">
                                    <img class="img-fluid img-thumbnail" src="{{ $item->product->image()->src() }}">
                                </div>
                                <div class="col-sm-8">
                                    <a class="d-block"
                                       href="{{route('products.show', $item->product)}}">{!! $item->product->name() !!}</a>
                                    <div class="text-muted">
                                        {{ $item->quantity }} {{ $item->product->unit }}
                                        x {{ Site::format($item->price) }}
                                    </div>
                                    <div class="mt-2">
                                        <button @cannot('delete', $item->order) disabled @endcannot
                                        class="btn btn-danger btn-sm btn-row-delete"
                                           data-form="#order-item-delete-form-{{$item->id}}"
                                           data-btn-delete="@lang('site::messages.delete')"
                                           data-btn-cancel="@lang('site::messages.cancel')"
                                           data-label="@lang('site::messages.delete_confirm')"
                                           data-message="@lang('site::messages.delete_sure') {!! $item->product->name() !!}? "
                                           data-toggle="modal" data-target="#form-modal"
                                           href="javascript:void(0);" title="@lang('site::messages.delete')">
                                            @lang('site::messages.delete')
                                        </button>
                                        <form id="order-item-delete-form-{{$item->id}}"
                                              action="{{route('admin.orders.items.destroy', $item)}}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-4 mb-sm-0 text-large text-left text-sm-right">{{ Site::format($item->subtotal()) }}</div>
                            </div>

                        @endforeach
                    </div>
                </div>

                <div class="card mt-2 mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::message.messages')</span>
                        {{--<div class="card-header-elements ml-auto">--}}
                        {{--<a href="#" class="btn btn-sm btn-light">--}}
                        {{--<i class="fa fa-pencil"></i>--}}
                        {{--</a>--}}
                        {{--</div>--}}
                    </h6>
                    <div class="card-body flex-grow-1 position-relative overflow-hidden">
                        {{--<h5 class="card-title">@lang('site::message.messages')</h5>--}}
                        <div class="row no-gutters h-100">
                            <div class="d-flex col flex-column">
                                <div class="flex-grow-1 position-relative">

                                    <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                                    <div class="chat-messages p-4 ps">

                                        @foreach($order->messages as $message)
                                            <div class="@if($message->user_id == Auth::user()->id) chat-message-right @else chat-message-left @endif mb-4">
                                                <div>
                                                    <img src="{{$message->user->logo}}" style="width: 40px!important;"
                                                         class="rounded-circle" alt="">
                                                    <div class="text-muted small text-nowrap mt-2">{{ $message->created_at(true) }}</div>
                                                </div>
                                                <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == Auth::user()->id) mr-3 @else ml-3 @endif">
                                                    <div class="mb-1"><b>{{$message->user->name}}</b></div>
                                                    <span class="text-big">{!! $message->text !!}</span>
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

            </div>
        </div>


    </div>
@endsection
