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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.repairs.show', $repair) }}">{{$repair->id}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.change') @lang('site::repair.status_id')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.change') @lang('site::repair.status_id') {{ $repair->id }} </h1>
        <div class=" border p-3 mb-4">
            <a href="{{ route('admin.repairs.show', $repair) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
        <form id="repair-status-form"
              method="POST"
              action="{{ route('admin.repairs.save', $repair) }}">
            @csrf
            @method('PUT')
            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="number">
                                    <label class="custom-control-label"
                                           for="number">@lang('site::repair.number')</label>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{$repair->id}}
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" title=""/>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label"
                               for="warranty_number">@lang('site::repair.warranty_number')</label>
                        <input type="text" id="warranty_number" name="warranty_number"
                               class="form-control{{ $errors->has('warranty_number') ? ' is-invalid' : '' }}"
                               value="{{ old('warranty_number') }}"
                               required
                               placeholder="@lang('site::repair.placeholder.warranty_number')">
                        <span class="invalid-feedback">{{ $errors->first('warranty_number') }}</span>
                    </div>
                    <div class="form-group mb-0 required">
                        <label class="control-label" for="">@lang('site::repair.warranty_period')</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="warranty_period_12"
                               @if(old('warranty_period') == 12) checked @endif
                               name="warranty_period" value="12" required>
                        <span class="invalid-feedback">{{ $errors->first('warranty_period') }}</span>
                        <label class="form-check-label" for="warranty_period_12">12</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="warranty_period_24"
                               @if(old('warranty_period') == 24) checked @endif
                               name="warranty_period" value="24" required>
                        <label class="form-check-label" for="warranty_period_24">24</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="warranty_period_36"
                               @if(old('warranty_period') == 36) checked @endif
                               name="warranty_period" value="36" required>
                        <label class="form-check-label" for="warranty_period_36">36</label>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.created_at')</dt>
                    <dd class="col-sm-8">{{ $repair->created_at->format('d.m.Y H:i') }}</dd>


                    <dt class="col-sm-4 text-left text-sm-right ">@lang('site::repair.status_id')</dt>
                    <dd class="col-sm-8" style="color:{{$repair->status->color}}"><i
                                class="fa fa-{{$repair->status->icon}}"></i> {{ $repair->status->name }}</dd>
                </dl>

                <hr/>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'serial_id')) bg-danger text-white @endif">@lang('site::repair.serial_id')</dt>
                    <dd class="col-sm-8">{{ $repair->serial_id }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::serial.product_id')</dt>
                    <dd class="col-sm-8">{{ $repair->product->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.sku')</dt>
                    <dd class="col-sm-8">{{ $repair->product->sku }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.equipment_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('admin.equipments.show', $repair->product->equipment)}}">
                            {{ $repair->product->equipment->catalog->name_plural }} {{ $repair->serial->product->equipment->name }}
                        </a>
                    </dd>

                </dl>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.payment')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'allow_work')) bg-danger text-white @endif">@lang('site::repair.allow_work')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_work == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'allow_road')) bg-danger text-white @endif">@lang('site::repair.allow_road')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_road == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'allow_parts')) bg-danger text-white @endif">@lang('site::repair.allow_parts')</dt>
                    <dd class="col-sm-8"> @bool(['bool' => $repair->allow_parts == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_difficulty')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_difficulty())}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.cost_distance')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_distance())}}</dd>

                    <dt class="col-sm-4  text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                    <dd class="col-sm-8 text-right">{{ Site::format($repair->cost_parts())}}</dd>
                    @if(count($parts = $repair->parts) > 0)
                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'parts')) bg-danger text-white @endif">@lang('site::part.parts')</dt>
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
                    <dd class="col-sm-8 text-right border-sm-top border-top-0">{{ Site::format($repair->totalCost)}}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.client')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'client')) bg-danger text-white @endif">@lang('site::repair.client')</dt>
                    <dd class="col-sm-8">{{ $repair->client }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'country_id')) bg-danger text-white @endif">@lang('site::repair.country_id')</dt>
                    <dd class="col-sm-8">{{ $repair->country->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'address')) bg-danger text-white @endif">@lang('site::repair.address')</dt>
                    <dd class="col-sm-8">{{ $repair->address }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'phone_primary')) bg-danger text-white @endif">@lang('site::repair.phone_primary')</dt>
                    <dd class="col-sm-8">{{ $repair->phone_primary }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'phone_secondary')) bg-danger text-white @endif">@lang('site::repair.phone_secondary')</dt>
                    <dd class="col-sm-8">{{ $repair->phone_secondary }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.org')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'trade_id')) bg-danger text-white @endif">@lang('site::repair.trade_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('admin.trades.show', $repair->trade)}}">{{ $repair->trade->name }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_trade')) bg-danger text-white @endif">@lang('site::repair.date_trade')</dt>
                    <dd class="col-sm-8">{{ $repair->date_trade() }}</dd>


                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'launch_id')) bg-danger text-white @endif">@lang('site::repair.launch_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('admin.launches.show', $repair->launch)}}">{{ $repair->launch->name }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_launch')) bg-danger text-white @endif">@lang('site::repair.date_launch')</dt>
                    <dd class="col-sm-8">{{ $repair->date_launch() }}</dd>


                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.call')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'engineer_id')) bg-danger text-white @endif">@lang('site::repair.engineer_id')</dt>
                    <dd class="col-sm-8"><a
                                href="{{route('admin.engineers.show', $repair->engineer)}}">{{ $repair->engineer->name }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_call')) bg-danger text-white @endif">@lang('site::repair.date_call')</dt>
                    <dd class="col-sm-8">{{ $repair->date_call() }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'reason_call')) bg-danger text-white @endif">@lang('site::repair.reason_call')</dt>
                    <dd class="col-sm-8">{!! $repair->reason_call !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'diagnostics')) bg-danger text-white @endif">@lang('site::repair.diagnostics')</dt>
                    <dd class="col-sm-8">{!! $repair->diagnostics !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'works')) bg-danger text-white @endif">@lang('site::repair.works')</dt>
                    <dd class="col-sm-8">{!! $repair->works !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_repair')) bg-danger text-white @endif">@lang('site::repair.date_repair')</dt>
                    <dd class="col-sm-8">{{ $repair->date_repair() }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::file.files')</h5>
                @include('site::repair.files')
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <div class=" border p-3 mb-4"></div>
                @if($statuses->isNotEmpty())
                    @foreach($statuses as $key => $status)
                        <a href="#"
                           style="color:#fff;background-color: {{$status->color}}"
                           class="btn
                            @if($key != $statuses->count()) mb-1 @endif

                                   d-block d-sm-inline-block">
                            <i class="fa fa-{{$status->icon}}"></i>
                            <span>{{$status->button}}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
@endsection
