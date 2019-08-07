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
            <li class="breadcrumb-item">
                <a href="{{ route('repairs.show', $repair) }}">№ {{$repair->id}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::repair.repair') № {{$repair->id}}</h1>

        @alert()@endalert()

        <div class=" border p-3 mb-4">
            <a href="{{ route('repairs.show', $repair) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>

        </div>

        <div class="row justify-content-center mb-5">
            <div class="col">

                <form id="form"
                      method="POST"
                      enctype="multipart/form-data"
                      action="{{ route('repairs.update', $repair) }}">
                    @csrf
                    @method('PUT')
                    <fieldset>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                {{--                                <h5 class="card-title">@lang('site::repair.serial_id')</h5>--}}
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('site::repair.serial_id')</label>
                                    <div class="text-success text-big">{{$repair->serial_id}}</div>
                                    <input type="hidden" id="serial_id" value="{{$repair->serial_id}}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="number">@lang('site::product.equipment_id')</label>
                                    <div class="text-big">
                                        <a href="{{route('equipments.show', $repair->product->equipment)}}">
                                            {{$repair->product->equipment->catalog->name_plural}}
                                            {{$repair->product->equipment->name}}
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="product_id">@lang('site::repair.product_id')</label>
                                    @if($fails->contains('field', 'product_id'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('product_id') ? ' is-invalid' : '' }}"
                                                required
                                                name="product_id"
                                                id="product_id">
                                            <option></option>
                                            @foreach($products as $product)
                                                <option @if(old('product_id', $repair->product_id) == $product->id)
                                                        selected
                                                        @endif
                                                        value="{{$product->id}}">
                                                    {{$product->name}} / {{$product->sku}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('product_id') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->product->name}}</div>
                                        <input type="hidden" value="{{$repair->product_id}}" id="product_id">
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('site::product.sku')</label>
                                    <div class="text-big">{{$repair->product->sku}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="number">@lang('site::repair.cost_difficulty')</label>
                                    <div class="text-big">{{Site::format($repair->cost_difficulty())}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="number">@lang('site::repair.cost_distance')</label>
                                    <div class="text-big">{{Site::format($repair->cost_distance())}}</div>
                                </div>
                            </div>
                        </div>
                        {{-- КЛИЕНТ --}}
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.client')</h5>
                                <div class="form-group mt-2 required">
                                    <label class="control-label" for="client">@lang('site::repair.client')</label>
                                    @if($fails->contains('field', 'client'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <input type="text" id="client" name="client"
                                               class="form-control{{ $errors->has('client') ? ' is-invalid' : '' }}"
                                               value="{{ old('client', $repair->client) }}" required
                                               placeholder="@lang('site::repair.placeholder.client')">
                                        <span class="invalid-feedback">{{ $errors->first('client') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->client}}</div>
                                    @endif
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="country_id">@lang('site::repair.country_id')</label>
                                    @if($fails->contains('field', 'country_id'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('country_id') ? ' is-invalid' : '' }}"
                                                required
                                                name="country_id"
                                                id="country_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($countries as $country)
                                                <option
                                                        @if(old('country_id', $repair->country_id) == $country->id)
                                                        selected
                                                        @endif
                                                        value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->country->name}}</div>
                                    @endif
                                </div>

                                <div class="form-group required">
                                    <label class="control-label" for="address">@lang('site::repair.address')</label>
                                    @if($fails->contains('field', 'address'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <input type="text" id="address" name="address"
                                               class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                               value="{{ old('address', $repair->address) }}" required
                                               placeholder="@lang('site::repair.placeholder.address')">
                                        <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->address}}</div>
                                    @endif
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="phone_primary">@lang('site::repair.phone_primary')</label>
                                    @if($fails->contains('field', 'phone_primary'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <input type="tel" id="phone_primary" name="phone_primary"
                                               class="form-control{{ $errors->has('phone_primary') ? ' is-invalid' : '' }}"
                                               pattern="^\d{9,10}$" maxlength="10" required
                                               value="{{ old('phone_primary') }}"
                                               placeholder="@lang('site::repair.placeholder.phone_primary')">
                                        <span class="invalid-feedback">{{ $errors->first('phone_primary') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->phone_primary}}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label"
                                           for="phone_secondary">@lang('site::repair.phone_secondary')</label>
                                    @if($fails->contains('field', 'phone_secondary'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <input type="tel" id="phone_secondary" name="phone_secondary"
                                               class="form-control{{ $errors->has('phone_secondary') ? ' is-invalid' : '' }}"
                                               pattern="^\d{9,10}$" maxlength="10"
                                               value="{{ old('phone_secondary') }}"
                                               placeholder="@lang('site::repair.placeholder.phone_secondary')">
                                        <span class="invalid-feedback">{{ $errors->first('phone_secondary') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->phone_secondary}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{--ОРГАНИЗАЦИИ --}}

                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.org')</h5>
                                @include('site::repair.field.trade_id')
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_trade">@lang('site::repair.date_trade')</label>
                                    @if($fails->contains('field', 'date_trade'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <div class="input-group date datetimepicker" id="datetimepicker_date_trade"
                                             data-target-input="nearest">
                                            <input type="text"
                                                   name="date_trade"
                                                   id="date_trade"
                                                   maxlength="10"
                                                   required
                                                   placeholder="@lang('site::repair.placeholder.date_trade')"
                                                   data-target="#datetimepicker_date_trade"
                                                   data-toggle="datetimepicker"
                                                   class="datetimepicker-input form-control{{ $errors->has('repair.date_trade') ? ' is-invalid' : '' }}"
                                                   value="{{ old('date_trade', $repair->date_trade->format('d.m.Y')) }}">
                                            <div class="input-group-append"
                                                 data-target="#datetimepicker_date_trade"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('date_trade') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->date_trade->format('Y.m.d')}}</div>
                                    @endif
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_launch">@lang('site::repair.date_launch')</label>
                                    @if($fails->contains('field', 'date_launch'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <div class="input-group date datetimepicker" id="datetimepicker_date_launch"
                                             data-target-input="nearest">
                                            <input type="text"
                                                   name="date_launch"
                                                   id="date_launch"
                                                   maxlength="10"
                                                   required
                                                   placeholder="@lang('site::repair.placeholder.date_launch')"
                                                   data-target="#datetimepicker_date_launch"
                                                   data-toggle="datetimepicker"
                                                   class="datetimepicker-input form-control{{ $errors->has('repair.date_launch') ? ' is-invalid' : '' }}"
                                                   value="{{ old('date_launch', $repair->date_launch->format('d.m.Y')) }}">
                                            <div class="input-group-append"
                                                 data-target="#datetimepicker_date_launch"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('date_launch') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->date_launch->format('d.m.Y')}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{--ВЫЕЗД НА ОБСЛУЖИВАНИЕ --}}

                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.call')</h5>
                                @include('site::repair.field.engineer_id')
                                <div class="form-group required">
                                    <label class="control-label" for="date_call">@lang('site::repair.date_call')</label>
                                    @if($fails->contains('field', 'date_call'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <div class="input-group date datetimepicker" id="datetimepicker_date_call"
                                             data-target-input="nearest">
                                            <input type="text"
                                                   name="date_call"
                                                   id="date_call"
                                                   maxlength="10"
                                                   required
                                                   placeholder="@lang('site::repair.placeholder.date_call')"
                                                   data-target="#datetimepicker_date_call"
                                                   data-toggle="datetimepicker"
                                                   class="datetimepicker-input form-control{{ $errors->has('repair.date_call') ? ' is-invalid' : '' }}"
                                                   value="{{ old('date_call', $repair->date_call->format('d.m.Y')) }}">
                                            <div class="input-group-append"
                                                 data-target="#datetimepicker_date_call"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('date_call') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->date_call->format('d.m.Y')}}</div>
                                    @endif
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="reason_call">@lang('site::repair.reason_call')</label>
                                    @if($fails->contains('field', 'reason_call'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <textarea name="reason_call" id="reason_call"
                                                  placeholder="@lang('site::repair.placeholder.reason_call')"
                                                  class="form-control{{ $errors->has('reason_call') ? ' is-invalid' : '' }}"
                                                  required>{{ old('reason_call', $repair->reason_call) }}</textarea>
                                        <span class="invalid-feedback">{{ $errors->first('reason_call') }}</span>
                                    @else
                                        <div class="text-success text-big">{!! $repair->reason_call !!}</div>
                                    @endif
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="diagnostics">@lang('site::repair.diagnostics')</label>
                                    @if($fails->contains('field', 'diagnostics'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <textarea name="diagnostics" id="diagnostics"
                                                  placeholder="@lang('site::repair.placeholder.diagnostics')"
                                                  class="form-control{{ $errors->has('diagnostics') ? ' is-invalid' : '' }}"
                                                  required>{{ old('diagnostics', $repair->diagnostics) }}</textarea>
                                        <span class="invalid-feedback">{{ $errors->first('diagnostics') }}</span>
                                    @else
                                        <div class="text-success text-big">{!! $repair->diagnostics !!}</div>
                                    @endif
                                </div>
                                <div class="form-group required">
                                    <label class="control-label" for="works">@lang('site::repair.works')</label>
                                    @if($fails->contains('field', 'works'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <textarea name="works" id="works"
                                                  placeholder="@lang('site::repair.placeholder.works')"
                                                  class="form-control{{ $errors->has('works') ? ' is-invalid' : '' }}"
                                                  required>{{ old('works', $repair->works) }}</textarea>
                                        <span class="invalid-feedback">{{ $errors->first('works') }}</span>
                                    @else
                                        <div class="text-success text-big">{!! $repair->works !!}</div>
                                    @endif
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_repair">@lang('site::repair.date_repair')</label>
                                    @if($fails->contains('field', 'date_repair'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <div class="input-group date datetimepicker" id="datetimepicker_date_repair"
                                             data-target-input="nearest">
                                            <input type="text"
                                                   name="date_repair"
                                                   id="date_repair"
                                                   maxlength="10"
                                                   required
                                                   placeholder="@lang('site::repair.placeholder.date_repair')"
                                                   data-target="#datetimepicker_date_repair"
                                                   data-toggle="datetimepicker"
                                                   class="datetimepicker-input form-control{{ $errors->has('repair.date_repair') ? ' is-invalid' : '' }}"
                                                   value="{{ old('date_repair', $repair->date_repair->format('d.m.Y')) }}">
                                            <div class="input-group-append"
                                                 data-target="#datetimepicker_date_repair"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('date_repair') }}</span>
                                    @else
                                        <div class="text-success text-big">{!! $repair->date_repair->format('d.m.Y') !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{--ОПЛАТА--}}
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.payment')</h5>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="contragent_id">@lang('site::repair.contragent_id')</label>
                                    @if($fails->contains('field', 'contragent_id'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('contragent_id') ? ' is-invalid' : '' }}"
                                                required
                                                name="contragent_id"
                                                id="contragent_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($contragents as $contragent)
                                                <option
                                                        @if(old('contragent_id', $repair->contragent_id) == $contragent->id) selected
                                                        @endif
                                                        value="{{ $contragent->id }}">{{ $contragent->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('contragent_id') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->contragent->name}}</div>
                                    @endif
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="difficulty_id">@lang('site::repair.difficulty_id')</label>
                                    @if($fails->contains('field', 'difficulty_id'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('difficulty_id') ? ' is-invalid' : '' }}"
                                                required
                                                name="difficulty_id"
                                                id="difficulty_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($difficulties as $difficulty)
                                                @if($difficulty->active == 1 || $repair->difficulty_id == $difficulty->id)
                                                    <option data-cost="{{$difficulty->cost}}"
                                                            @if(old('difficulty_id', $repair->difficulty_id) == $difficulty->id) selected
                                                            @endif
                                                            value="{{ $difficulty->id }}">{{ $difficulty->name }}@if($difficulty->cost > 0)
                                                            - {{ Site::format($difficulty->cost) }}@endif</option>
                                                @endif
                                            @endforeach

                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('difficulty_id') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->difficulty->name}}</div>
                                    @endif
                                </div>
                                {{-- ДОРОГА --}}
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="distance_id">@lang('site::repair.distance_id')</label>
                                    @if($fails->contains('field', 'distance_id'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('distance_id') ? ' is-invalid' : '' }}"
                                                required
                                                name="distance_id"
                                                id="distance_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($distances as $distance)
                                                @if($distance->active == 1 || $repair->distance_id == $distance->id)
                                                    <option data-cost="{{$distance->cost}}"
                                                            @if(old('distance_id', $repair->distance_id) == $distance->id) selected
                                                            @endif
                                                            value="{{ $distance->id }}">{{ $distance->name }}@if($distance->cost > 0)
                                                            - {{ Site::format($distance->cost) }}@endif</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('distance_id') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->distance->name}}</div>
                                    @endif
                                </div>
                                @if($fails->contains('field', 'parts'))
                                    <fieldset id="parts-search-fieldset">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="parts_search">Найти замененную деталь</label>
                                            <select style="width:100%" class="form-control" id="parts_search">
                                                <option value=""></option>
                                            </select>
                                            <span class="invalid-feedback">Такая деталь уже есть в списке</span>
                                            <small id="partsHelp"
                                                   class="d-block form-text text-success">Введите артикул или
                                                наименование
                                                заменённой детали и выберите её из списка
                                            </small>

                                        </div>

                                        <div class="form-row">
                                            <div class="col my-3">
                                                <label class="control-label"
                                                       for="">@lang('site::part.parts')</label>
                                                <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                                <div id="parts"
                                                     class="card-group"
                                                     data-currency-symbol="{{ auth()->user()->currency->symbol_right }}">
                                                    @foreach($parts as $part)
                                                        @include('site::part.create', ['product' => $part['product'], 'count' => $part['count']])
                                                    @endforeach
                                                </div>
                                                <hr/>
                                                <div class="text-right text-xlarge">
                                                    @lang('site::part.total'):
                                                    @if(!$parts->isEmpty())
                                                        <span id="total-cost">
                                                        {{Site::format($parts->sum('cost'))}}
                                                        </span>
                                                    @else
                                                        {{Site::currency()->symbol_left}}
                                                        <span id="total-cost">0</span>
                                                        {{Site::currency()->symbol_right}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                @else
                                    <div class="form-row">
                                        <div class="col my-3">
                                            <label class="control-label"
                                                   for="">@lang('site::part.parts')</label>
                                            <div class="card-group" id="parts">
                                                @foreach($parts as $part)
                                                    <div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                                        <div class="card-body text-left">
                                                            <h4 class="card-title">{{$part['product']->name}}</h4>
                                                            <input type="hidden" name="count[{{$part['product']->id}}]" value="{{$part['count']}}" />
                                                            <dl class="row">
                                                                <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::product.sku')</dt>
                                                                <dd class="col-12 col-md-6">{{$part['product']->sku}}</dd>
                                                                <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.cost')</dt>
                                                                <dd class="col-12 col-md-6">
                                                                    {{$part['product']->hasPrice ? number_format($part['product']->repairPrice->value, 0, '.', ' ') : trans('site::price.error.price')}}
                                                                    {{ auth()->user()->currency->symbol_right }}
                                                                </dd>
                                                                <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.count')</dt>
                                                                <dd class="col-12 col-md-6">{{$part['count']}}</dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr/>
                                            <div class="text-right text-xlarge">
                                                @lang('site::part.total'):
{{--                                                {{dd($parts)}}--}}
                                                @if(!$parts->isEmpty())
                                                    <span id="total-cost">
                                                        {{ number_format($parts->sum(function ($p) {return $p['cost'] * $p['count'];}), 0, '.', ' ') }}
                                                    </span>
                                                    {{ auth()->user()->currency->symbol_right }}
                                                @else

                                                    {{Site::currency()->symbol_left}}
                                                    <span id="total-cost">0</span>
                                                    {{Site::currency()->symbol_right}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </form>
                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::file.files')</h5>
                            <h6 class="card-subtitle mb-2 text-muted">@lang('site::file.maxsize5mb')</h6>
                            @include('site::file.create.type')
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <hr id="messages-list"/>
                    <div class="card mt-5 mb-4">
                        <div class="card-body flex-grow-1 position-relative overflow-hidden">
                            <h5 class="card-title">@lang('site::message.messages')</h5>
                            <div class="row no-gutters">
                                <div class="d-flex col flex-column">
                                    <div class="flex-grow-1 position-relative">

                                        <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                                        <div class="chat-messages p-4 ps">
                                            @foreach($repair->messages as $message)
                                                <div class="@if($message->user_id == auth()->user()->getAuthIdentifier()) chat-message-right @else chat-message-left @endif mb-4">
                                                    <div>
                                                        <img src="{{$message->user->logo}}"
                                                             style="width: 40px!important;"
                                                             class="rounded-circle" alt="">
                                                        <div class="text-muted small text-nowrap mt-2">{{ $message->created_at->format('d.m.Y H:i') }}</div>
                                                    </div>
                                                    <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == auth()->user()->getAuthIdentifier()) mr-3 @else ml-3 @endif">
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
                                <div class="row no-gutters">
                                    <div class="d-flex col flex-column">
                                        <div class="flex-grow-1 position-relative">
                                            <div class="form-group">
                                                <label class="control-label"
                                                       for="message_text">@lang('site::message.text')</label>
                                                <input type="hidden" name="message[receiver_id]"
                                                       form="form"
                                                       value="{{$repair->user_id}}">
                                                <textarea name="message[text]"
                                                          id="message_text"
                                                          form="form"
                                                          rows="3"
                                                          class="form-control{{  $errors->has('message.text') ? ' is-invalid' : '' }}"></textarea>
                                                <span class="invalid-feedback">{{ $errors->first('message.text') }}</span>
                                            </div>
                                            @foreach($statuses as $key => $status)
                                                <button
                                                        form="form"
                                                        type="submit"
                                                        name="status_id"
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
                </fieldset>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    try {
        window.addEventListener('load', function () {

            let product = $('#product_id'),
                product_n = $('[name="product_id"]'),
                parts_search = $('#parts_search'),
                parts = $('#parts'),
                selected = [];
            let number_format = function (number, decimals, dec_point, thousands_sep) {

                let i, j, kw, kd, km;

                // input sanitation & defaults
                if (isNaN(decimals = Math.abs(decimals))) {
                    decimals = 0;
                }
                if (dec_point === undefined) {
                    dec_point = ".";
                }
                if (thousands_sep === undefined) {
                    thousands_sep = " ";
                }

                i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

                if ((j = i.length) > 3) {
                    j = j % 3;
                } else {
                    j = 0;
                }

                km = (j ? i.substr(0, j) + thousands_sep : "");
                kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
                //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
                kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


                return km + kw + kd;
            };
            $(document)
                .on('click', '.part-delete', (function () {
                    let index = selected.indexOf($(this).data('id'));
                    if (index > -1) {
                        selected.splice(index, 1);
                        $('.product-' + $(this).data('id')).remove();
                    }
                    calc_parts();
                }))
                .on('keyup mouseup', '.parts_count', (function () {
                    calc_parts();
                }));
            let calc_parts = function () {
                if($('.parts_count').length){
                    let cost = 0;
                    selected.push(parts.children().data('id'));
                    parts.children().each(function (i) {
                        let el = $(this).find('.parts_count');

                        cost += (parseInt(el.data('cost')) * el.val());
                    });

                    $('#total-cost').html(number_format(cost));
                }
            };
            calc_parts();

            product_n.select2({
                theme: "bootstrap4",
                placeholder: '@lang('site::messages.select_from_list')',
                selectOnClose: true,
                minimumInputLength: 3,
            });

            product_n.on('select2:select', function (e) {
                selected = [];
                parts.text('');
                $('#total-cost').html(number_format(0));
            });

            parts_search.select2({
                theme: "bootstrap4",
                ajax: {
                    url: '/api/parts',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            'filter[search_part]': params.term,
                            'filter[search_product]': product.val(),
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data.data,
                        };
                    }
                },
                minimumInputLength: 3,
                templateResult: function (product) {
                    if (product.loading) return "...";
                    let markup = "<img style='width:70px;' src=" + product.image + " /> &nbsp; " + product.name + ' (' + product.sku + ')';
                    return markup;
                },
                templateSelection: function (product) {

                    if (product.id !== "") {
                        return product.name + ' (' + product.sku + ')';
                    }


                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
            parts_search.on('select2:select', function (e) {
                let product_id = $(this).find('option:selected').val();
                if (!selected.includes(product_id)) {
                    parts_search.removeClass('is-invalid');
                    selected.push(product_id);
                    axios
                        .get("/api/parts/create/" + product_id)
                        .then((response) => {

                            parts.append(response.data);
                            $('[name="count[' + product_id + ']"]').focus();
                            calc_parts();
                            parts_search.val(null)
                        })
                        .catch((error) => {
                            this.status = 'Error:' + error;
                        });
                } else {
                    parts_search.addClass('is-invalid');
                }
            });


        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush