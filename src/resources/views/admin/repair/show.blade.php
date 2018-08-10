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
                <a href="{{ route('admin.repairs.index') }}">@lang('site::repair.repairs')</a>
            </li>
            <li class="breadcrumb-item active">{{ $repair->number }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $repair->number }} </h1>
        <div class=" border p-3 mb-4">
            <a href="{{ route('admin.repairs.edit', $repair) }}"
               class="disabled d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::repair.repair')</span>
            </a>
            @if($repair->messages->isNotEmpty())
                <a href="#messages-list" class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-@lang('site::message.icon')"></i>
                    <span>@lang('site::messages.show') @lang('site::message.messages') <span
                                class="badge badge-light">{{$repair->messages()->count()}}</span></span>
                </a>
            @endif
            <a href="{{ route('admin.repairs.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <form id="repair-admin-edit-form" method="post" action="{{route('admin.repairs.status', $repair)}}">
            @csrf
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.created_at')</dt>
                        <dd class="col-sm-8">{{ $repair->created_at(true) }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right ">@lang('site::repair.status_id')</dt>
                        <dd class="col-sm-8" style="color:{{$repair->status->color}}"><i
                                    class="fa fa-{{$repair->status->icon}}"></i> {{ $repair->status->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'number')) bg-danger text-white @endif">
                            <label for="number" class="pointer control-label">@lang('site::repair.number')</label>
                            <input id="number"
                                   value="number"
                                   @if($fails->contains('field', 'number')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->number }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'warranty_number')) bg-danger text-white @endif">
                            <label for="warranty_number"
                                   class="pointer control-label">@lang('site::repair.warranty_number')</label>
                            <input id="warranty_number"
                                   value="warranty_number"
                                   @if($fails->contains('field', 'warranty_number')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->warranty_number }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'warranty_period')) bg-danger text-white @endif">
                            <label for="warranty_period"
                                   class="pointer control-label">@lang('site::repair.warranty_period')</label>
                            <input id="warranty_period"
                                   value="warranty_period"
                                   @if($fails->contains('field', 'warranty_period')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->warranty_period }}</dd>

                    </dl>

                    <hr/>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'serial_id')) bg-danger text-white @endif">@lang('site::repair.serial_id')</dt>
                        <dd class="col-sm-8">{{ $repair->serial_id }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::serial.product_id')</dt>
                        <dd class="col-sm-8">{{ $repair->serial->product->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.sku')</dt>
                        <dd class="col-sm-8">{{ $repair->serial->product->sku }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.equipment_id')</dt>
                        <dd class="col-sm-8"><a
                                    href="{{route('admin.equipments.show', $repair->serial->product->equipment)}}">
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

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'allow_work')) bg-danger text-white @endif">
                            <label for="allow_work"
                                   class="pointer control-label">@lang('site::repair.allow_work')</label>
                            <input id="allow_work"
                                   value="allow_work"
                                   @if($fails->contains('field', 'allow_work')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">@bool(['bool' => $repair->allow_work == 1])@endbool</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'allow_road')) bg-danger text-white @endif">
                            <label for="allow_road"
                                   class="pointer control-label">@lang('site::repair.allow_road')</label>
                            <input id="allow_road"
                                   value="allow_road"
                                   @if($fails->contains('field', 'allow_road')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">@bool(['bool' => $repair->allow_road == 1])@endbool</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'allow_parts')) bg-danger text-white @endif">
                            <label for="allow_parts"
                                   class="pointer control-label">@lang('site::repair.allow_parts')</label>
                            <input id="allow_parts"
                                   value="allow_parts"
                                   @if($fails->contains('field', 'allow_parts')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">@bool(['bool' => $repair->allow_parts == 1])@endbool</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_work')</dt>
                        <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_work())}}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_road')</dt>
                        <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_road())}}</dd>

                        <dt class="col-sm-4  text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                        <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_parts())}}</dd>
                        @if(count($parts = $repair->parts) > 0)
                            <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'parts')) bg-danger text-white @endif">
                                <label for="parts"
                                       class="pointer control-label">@lang('site::part.parts')</label>
                                <input id="parts"
                                       value="parts"
                                       @if($fails->contains('field', 'parts')) checked @endif
                                       type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                            </dt>
                            <dd class="col-sm-8">
                                @foreach($parts as $part)
                                    <div class="row">
                                        <div class="col-8">{{$part->product->name()}}
                                            x {{$part->count}} {{$part->product->unit}}</div>
                                        <div class="col-4 text-right text-danger">{{Site::format($part->total)}}</div>
                                    </div>
                                @endforeach
                            </dd>
                        @endif
                        <dt class="col-sm-4 text-right border-top">Итого к оплате</dt>
                        <dd class="col-sm-8 text-right border-sm-top border-top-0">{{ Site::format($repair->cost_total())}}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.client')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'client')) bg-danger text-white @endif">
                            <label for="client"
                                   class="pointer control-label">@lang('site::repair.client')</label>
                            <input id="client"
                                   value="client"
                                   @if($fails->contains('field', 'client')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->client }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'country_id')) bg-danger text-white @endif">
                            <label for="country_id"
                                   class="pointer control-label">@lang('site::repair.country_id')</label>
                            <input id="country_id"
                                   value="country_id"
                                   @if($fails->contains('field', 'country_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->country->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'address')) bg-danger text-white @endif">
                            <label for="address"
                                   class="pointer control-label">@lang('site::repair.address')</label>
                            <input id="address"
                                   value="address"
                                   @if($fails->contains('field', 'address')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->address }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'phone_primary')) bg-danger text-white @endif">
                            <label for="phone_primary"
                                   class="pointer control-label">@lang('site::repair.phone_primary')</label>
                            <input id="phone_primary"
                                   value="phone_primary"
                                   @if($fails->contains('field', 'phone_primary')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->phone_primary }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'phone_secondary')) bg-danger text-white @endif">
                            <label for="phone_secondary"
                                   class="pointer control-label">@lang('site::repair.phone_secondary')</label>
                            <input id="phone_secondary"
                                   value="phone_secondary"
                                   @if($fails->contains('field', 'phone_secondary')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->phone_secondary }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.org')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'trade_id')) bg-danger text-white @endif">
                            <label for="trade_id"
                                   class="pointer control-label">@lang('site::repair.trade_id')</label>
                            <input id="trade_id"
                                   value="trade_id"
                                   @if($fails->contains('field', 'trade_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8"><a
                                    href="{{route('admin.trades.show', $repair->trade)}}">{{ $repair->trade->name }}</a>
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_trade')) bg-danger text-white @endif">
                            <label for="date_trade"
                                   class="pointer control-label">@lang('site::repair.date_trade')</label>
                            <input id="date_trade"
                                   value="date_trade"
                                   @if($fails->contains('field', 'date_trade')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_trade() }}</dd>


                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'launch_id')) bg-danger text-white @endif">
                            <label for="launch_id"
                                   class="pointer control-label">@lang('site::repair.launch_id')</label>
                            <input id="launch_id"
                                   value="launch_id"
                                   @if($fails->contains('field', 'launch_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8"><a
                                    href="{{route('admin.launches.show', $repair->launch)}}">{{ $repair->launch->name }}</a>
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_launch')) bg-danger text-white @endif">
                            <label for="date_launch"
                                   class="pointer control-label">@lang('site::repair.date_launch')</label>
                            <input id="date_launch"
                                   value="date_launch"
                                   @if($fails->contains('field', 'date_launch')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_launch() }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.call')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'engineer_id')) bg-danger text-white @endif">
                            <label for="engineer_id"
                                   class="pointer control-label">@lang('site::repair.engineer_id')</label>
                            <input id="engineer_id"
                                   value="engineer_id"
                                   @if($fails->contains('field', 'engineer_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8"><a
                                    href="{{route('admin.engineers.show', $repair->engineer)}}">{{ $repair->engineer->name }}</a>
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_call')) bg-danger text-white @endif">
                            <label for="date_call"
                                   class="pointer control-label">@lang('site::repair.date_call')</label>
                            <input id="date_call"
                                   value="date_call"
                                   @if($fails->contains('field', 'date_call')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_call() }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'reason_call')) bg-danger text-white @endif">
                            <label for="reason_call"
                                   class="pointer control-label">@lang('site::repair.reason_call')</label>
                            <input id="reason_call"
                                   value="reason_call"
                                   @if($fails->contains('field', 'reason_call')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{!! $repair->reason_call !!}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'diagnostics')) bg-danger text-white @endif">
                            <label for="diagnostics"
                                   class="pointer control-label">@lang('site::repair.diagnostics')</label>
                            <input id="diagnostics"
                                   value="diagnostics"
                                   @if($fails->contains('field', 'diagnostics')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{!! $repair->diagnostics !!}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'works')) bg-danger text-white @endif">
                            <label for="works"
                                   class="pointer control-label">@lang('site::repair.works')</label>
                            <input id="works"
                                   value="works"
                                   @if($fails->contains('field', 'works')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{!! $repair->works !!}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_repair')) bg-danger text-white @endif">
                            <label for="date_repair"
                                   class="pointer control-label">@lang('site::repair.date_repair')</label>
                            <input id="date_repair"
                                   value="date_repair"
                                   @if($fails->contains('field', 'date_repair')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_repair() }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::file.files')</h5>
                    @include('site::admin.repair.files')
                </div>
            </div>
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
                    @if($statuses->isNotEmpty())
                        <div class="row no-gutters h-100">
                            <div class="d-flex col flex-column">
                                <div class="flex-grow-1 position-relative">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="message_text">@lang('site::message.text')</label>
                                        <input type="hidden" name="message[receiver_id]" value="{{$repair->user_id}}">
                                        <textarea name="message[text]"
                                                  id="message_text"
                                                  rows="3"
                                                  class="form-control{{  $errors->has('message.text') ? ' is-invalid' : '' }}"></textarea>
                                        <span class="invalid-feedback">{{ $errors->first('message.text') }}</span>
                                    </div>
                                    @foreach($statuses as $key => $status)
                                        <button
                                                type="submit"
                                                name="repair[status_id]"
                                                value="{{$status->id}}"
                                                style="color:#fff;background-color: {{$status->color}}"
                                                class="btn d-block d-sm-inline-block @if($key != $statuses->count()) mb-1 @endif">
                                            <i class="fa fa-{{$status->icon}}"></i>
                                            <span>{{$status->button}}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
