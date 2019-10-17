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
            <li class="breadcrumb-item active">@lang('site::order.breadcrumb_show', ['order' => $order->id, 'date' => $order->created_at->format('d.m.Y H:i') ])</li>
        </ol>
        <h1 class="header-title mb-4">№ {{ $order->id }}</h1>
        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.orders.schedule', $order) }}"
               class="@cannot('schedule', $order) disabled @endcannot d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-@lang('site::schedule.icon')"></i>
                <span>@lang('site::schedule.synchronize')</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::order.info')</span>
                    </h6>
                    <div class="card-body">

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.created_at'):</span>&nbsp;
                            <span class="text-dark">{{$order->created_at->format('d.m.Y H:i' )}}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.status_id'):</span>&nbsp;
                            <span class="badge text-normal badge-pill text-white"
                                  style="background-color: {{ $order->status->color }}">
                                <i class="fa fa-{{ $order->status->icon }}"></i> {{ $order->status->name }}
                            </span>
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
                            <span class="text-muted">@lang('site::order.address_id'):</span>&nbsp;
                            <span class="text-dark">{{ optional($order->address)->name }}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.guid'):</span>&nbsp;
                            <span class="text-dark">{{ $order->guid }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.in_stock_type'):</span>&nbsp;
                            <span class="text-dark">@lang('site::order.help.in_stock_type.'.$order->in_stock_type)</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.percent_compl'):</span>&nbsp;
                            <span class="badge badge-warning badge-pill">
                                <i class="fa fa-percent"></i> {{ $order->percent_compl }}
                            </span>
                        </div>
                        @if($order->brother)
                            <div class="mb-2">
                                <span class="text-primary font-weight-bold">@lang('site::order.brother_id'):</span>&nbsp;
                                <a href="{{route('admin.orders.show', $order->brother)}}">№ {{$order->brother->id}}</a>
                            </span>
                            </div>
                        @endif

                        <hr class="p-0"/>

                        <div class="mb-2">
                            <div class="font-weight-bold mb-0">@lang('site::order.total')</div>&nbsp;
                            <div class="text-dark display-6 font-weight-bolder">
                                @include('site::order.total')
                            </div>
                        </div>

                        <hr class="p-0"/>
                        <div class="mb-2">
                            <div class="font-weight-bold mb-0">@lang('site::order.help.payment')</div>&nbsp;
                            @if(in_array($order->status_id, array(2,3)))
                                <div class="form-row mt-2">
                                    <div class="col">

                                        <form method="POST" enctype="multipart/form-data"
                                              action="{{route('admin.orders.payment', $order)}}">
                                            @csrf
                                            <input type="hidden"
                                                   name="type_id"
                                                   value="19"/>
                                            <input type="hidden"
                                                   name="storage"
                                                   value="payments"/>
                                            <input class="d-inline-block form-control-file{{ $errors->has('file_id') ? ' is-invalid' : '' }}"
                                                   type="file"
                                                   accept="{{config('site.payments.accept')}}"
                                                   name="path"/>

                                            <button type="submit"
                                                    class="py-0 px-1 btn-sm btn btn-ferroli file-upload-button">
                                                @lang('site::messages.attach')
                                            </button>
                                            <span class="invalid-feedback">{{ $errors->first('file_id') }}</span>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div id="files" class="form-row bg-white ml-2">
                                @include('site::admin.file.edit', ['delete' => in_array($order->status_id, array(2,3))])
                            </div>
                        </div>

                        <hr class="p-0"/>
                        <div>
                            <form action="{{route('admin.orders.update', $order)}}"
                                  method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="d-flex flex-column justify-content-between">


                                    @if($order->in_stock_type == 2)
                                        @if($order->status_id == 1)
                                            <button name="order[status_id]"
                                                    value="7"
                                                    type="submit"
                                                    class="btn btn-success mb-1">
                                                @lang('site::order.button.status.7')
                                            </button>
                                        @endif
                                        @if($order->status_id == 8)
                                            <button name="order[status_id]"
                                                    value="9"
                                                    type="submit"
                                                    class="btn btn-success mb-1">
                                                @lang('site::order.button.status.9')
                                            </button>
                                        @endif
                                    @endif
                                    @if($order->status_id == 2)
                                        <button name="order[status_id]"
                                                value="3"
                                                type="submit"
                                                class="btn btn-success mb-1">
                                            @lang('site::order.button.status.3')
                                        </button>
                                    @endif
                                    @if($order->status_id == 3)
                                        <button name="order[status_id]"
                                                value="4"
                                                type="submit"
                                                class="btn btn-success mb-1">
                                            @lang('site::order.button.status.4')
                                        </button>
                                    @endif
                                    <button name="order[status_id]"
                                            value="6"
                                            type="submit"
                                            class="btn btn-danger mb-1">
                                        @lang('site::order.button.status.6')
                                    </button>
                                </div>
                            </form>
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
                    @include('site::schedule.index', ['schedules' => $order->schedules])
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
                    @endcannot
                </div>

            </div>
            <div class="col-xl-8">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::order.items')</span>
                    </h6>
                    <div class="card-body">
                        @foreach($order->items as $item)
                            <hr class="mb-3"/>
                            <div class="row mb-sm-1">

                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-3 d-none d-md-block">
                                            <img class="img-fluid img-thumbnail"
                                                 src="{{ $item->product->image()->src() }}">
                                        </div>
                                        <div class="col-sm-9">
                                            <a class="d-block"
                                               href="{{route('products.show', $item->product)}}">{!! $item->product->name() !!}</a>
                                            <div class="text-muted">
                                                {{ $item->quantity }} {{ $item->product->unit }} x
                                                {{Site::convert($item->price, $item->currency_id, $item->currency_id, 1, false, true)}}
                                                @if ($item->currency_id != 643)
                                                    ({{Site::convert($item->price, $item->currency_id, 643, 1, false, true)}}
                                                    )
                                                @endif
                                            </div>
                                            @if($order->in_stock_type == 2)
                                                <div class="text-muted">
                                                    @lang('site::order_item.weeks_delivery'):
                                                    @if($item->weeks_delivery > 0)
                                                        {{numberof($item->weeks_delivery, $item->weeks_delivery, trans('site::messages.weekends'))}}
                                                    @else
                                                        @lang('site::messages.not_indicated_m')
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="my-2">

                                                <a onclick="document.getElementById('order-item-edit-form-{{$item->id}}').classList.toggle('d-none')"
                                                   class="py-0 px-1 btn btn-ferroli btn-sm @cannot('edit', $item) disabled @endcannot"
                                                   href="javascript:void(0)">
                                                    <i class="fa fa-pencil"></i>
                                                    @lang('site::messages.edit')
                                                </a>

                                                <button @cannot('delete', $item) disabled @endcannot
                                                class="py-0 px-1 btn btn-danger btn-sm btn-row-delete"
                                                        data-form="#order-item-delete-form-{{$item->id}}"
                                                        data-btn-delete="@lang('site::messages.delete')"
                                                        data-btn-cancel="@lang('site::messages.cancel')"
                                                        data-label="@lang('site::messages.delete_confirm')"
                                                        data-message="@lang('site::messages.delete_sure') {!! $item->product->name() !!}? "
                                                        data-toggle="modal" data-target="#form-modal"
                                                        href="javascript:void(0);"
                                                        title="@lang('site::messages.delete')">
                                                    <i class="fa fa-close"></i> @lang('site::messages.delete')
                                                </button>
                                                <form id="order-item-delete-form-{{$item->id}}"
                                                      action="{{route('admin.order-items.destroy', $item)}}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </div>
                                            @can('edit', $item)
                                                <fieldset id="order-item-edit-form-{{$item->id}}"
                                                          class="@if(!($errors->any() || $errors->has('order_item.'.$item->id))) d-none @endif border-top mt-4">
                                                    <form method="POST"
                                                          action="{{route('admin.order-items.update', $item)}}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-group mt-2 required">
                                                            <label class="control-label" for="price">
                                                                @lang('site::order_item.price')
                                                                {{$item->currency->name}}
                                                            </label>
                                                            <input required
                                                                   type="number"
                                                                   min="0.01"
                                                                   step="0.01"
                                                                   id="price"
                                                                   value="{{old('order_item.'.$item->id.'.price', $item->price)}}"
                                                                   class="form-control{{ $errors->has('order_item.'.$item->id.'.price') ? ' is-invalid' : '' }}"
                                                                   name="order_item[{{$item->id}}][price]"/>
                                                            <span class="invalid-feedback">{{ $errors->first('order_item.'.$item->id.'.price') }}</span>
                                                        </div>
                                                        <div class="form-group mt-2 required">
                                                            <label class="control-label" for="client">
                                                                @lang('site::order_item.quantity')
                                                            </label>
                                                            <input required
                                                                   type="number"
                                                                   min="1"
                                                                   max="{{config('cart.item_max_quantity')}}"
                                                                   step="1"
                                                                   id="price"
                                                                   value="{{old('order_item.'.$item->id.'.price', $item->quantity)}}"
                                                                   class="form-control{{ $errors->has('order_item.'.$item->id.'.quantity') ? ' is-invalid' : '' }}"
                                                                   name="order_item[{{$item->id}}][quantity]"/>
                                                            <span class="invalid-feedback">{{ $errors->first('order_item.'.$item->id.'.quantity') }}</span>
                                                        </div>
                                                        @if($order->status_id == 1)
                                                            <div class="form-group mt-2 required">
                                                                <label class="control-label" for="client">
                                                                    @lang('site::order_item.weeks_delivery')
                                                                </label>
                                                                <select required
                                                                        id="weeks_delivery"
                                                                        class="form-control{{ $errors->has('order_item.'.$item->id.'.weeks_delivery') ? ' is-invalid' : '' }}"
                                                                        name="order_item[{{$item->id}}][weeks_delivery]">
                                                                    @foreach(range(config('site.weeks_delivery.min'), config('site.weeks_delivery.max')) as $weekend)
                                                                        <option @if(old('order_item.weeks_delivery', $item->weeks_delivery) == $weekend) selected
                                                                                @endif
                                                                                value="{{$weekend}}">
                                                                            {{numberof($weekend, $weekend, trans('site::messages.weekends'))}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="invalid-feedback">{{ $errors->first('order_item.'.$item->id.'.weeks_delivery') }}</span>
                                                            </div>
                                                        @endif
                                                        <button class="btn btn-success py-1" type="submit">
                                                            <i class="fa fa-save"></i>
                                                            @lang('site::messages.save')
                                                        </button>
                                                    </form>
                                                </fieldset>
                                            @endcan
                                        </div>
                                    </div>


                                </div>
                                <div class="col-sm-4 mb-4 mb-sm-0 text-large text-left text-sm-right">
                                    {{Site::convert($item->price, $item->currency_id, $item->currency_id, $item->quantity, false, true)}}
                                    @if ($item->currency_id != 643)
                                        ({{Site::convert($item->price, $item->currency_id, 643, $item->quantity, true, true)}}
                                        )
                                    @endif
                                </div>
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
                        @if($order->messages->isNotEmpty())
                            <div class="row no-gutters h-100">
                                <div class="d-flex col flex-column">
                                    <div class="flex-grow-1 position-relative">

                                        <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                                        <div class="chat-messages p-4 ps">

                                            @foreach($order->messages as $message)
                                                <div class="@if($message->user_id == auth()->user()->getAuthIdentifier()) chat-message-right @else chat-message-left @endif mb-4">
                                                    <div>
                                                        <img src="{{$message->user->logo}}"
                                                             style="width: 40px!important;"
                                                             class="rounded-circle" alt="">
                                                        <div class="text-muted small text-nowrap mt-2">{{ $message->created_at->format('d.m.Y H:i') }}</div>
                                                    </div>
                                                    <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == auth()->user()->getAuthIdentifier()) mr-3 @else ml-3 @endif">
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
                        @endif
                        <form action="{{route('admin.orders.message', $order)}}" method="post">
                            @csrf

                            <div class="row no-gutters">
                                <div class="d-flex col flex-column">
                                    <div class="flex-grow-1 position-relative">
                                        <div class="form-group">
                                            <input type="hidden" name="message[receiver_id]"
                                                   value="{{$order->user_id}}">
                                            <textarea name="message[text]"
                                                      id="message_text"
                                                      rows="3"
                                                      placeholder="@lang('site::message.placeholder.text')"
                                                      class="form-control{{  $errors->has('message.text') ? ' is-invalid' : '' }}"></textarea>
                                            <span class="invalid-feedback">{{ $errors->first('message.text') }}</span>
                                        </div>
                                        <button type="submit"
                                                class="btn btn-success d-block d-sm-inline-block">
                                            <i class="fa fa-check"></i>
                                            <span>@lang('site::messages.send')</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection
