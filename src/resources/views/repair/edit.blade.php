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
                <a href="{{ route('repairs.show', $repair) }}">{{$repair->number}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::repair.repair')</h1>

        @alert()@endalert()

        <div class=" border p-3 mb-4">
            <a href="{{ route('repairs.show', $repair) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>

        </div>

        <div class="row justify-content-center mb-5">
            <div class="col">

                <form id="repair-form"
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
                                        <a href="{{route('equipments.show', $repair->serial->product->equipment)}}">
                                            {{$repair->serial->product->equipment->catalog->parentTreeName()}}
                                            {{$repair->serial->product->equipment->name}}
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('site::serial.product_id')</label>
                                    <div class="text-big">{{$repair->serial->product->name}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('site::product.sku')</label>
                                    <div class="text-big">{{$repair->serial->product->sku}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('site::equipment.cost_work')</label>
                                    <div class="text-big">{{Site::format($repair->cost_work())}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('site::equipment.cost_road')</label>
                                    <div class="text-big">{{Site::format($repair->cost_road())}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                                <div class="form-group required">
                                    <label class="control-label" for="number">@lang('site::repair.number')</label>
                                    @if($fails->contains('field', 'number'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <input type="text"
                                               id="number"
                                               name="number"
                                               class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}"
                                               value="{{ old('number', $repair->number) }}"
                                               required
                                               placeholder="@lang('site::repair.placeholder.number')">
                                        <span class="invalid-feedback">{{ $errors->first('number') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->number}}</div>
                                    @endif

                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="warranty_number">@lang('site::repair.warranty_number')</label>
                                    @if($fails->contains('field', 'warranty_number'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <input type="text" id="warranty_number" name="warranty_number"
                                               class="form-control{{ $errors->has('warranty_number') ? ' is-invalid' : '' }}"
                                               value="{{ old('warranty_number', $repair->warranty_number) }}"
                                               required
                                               placeholder="@lang('site::repair.placeholder.warranty_number')">
                                        <span class="invalid-feedback">{{ $errors->first('warranty_number') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->warranty_number}}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-0 required">
                                    <label class="control-label" for="">@lang('site::repair.warranty_period')</label>
                                </div>
                                @if($fails->contains('field', 'warranty_period'))
                                    <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
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
                                @else
                                    <div class="text-success text-big">{{$repair->warranty_period}}</div>
                                @endif

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
                                               pattern="^\d{10}$" maxlength="10" required
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
                                               pattern="^\d{10}$" maxlength="10"
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
                                        <input type="date" name="date_trade" id="date_trade"
                                               class="form-control{{ $errors->has('date_trade') ? ' is-invalid' : '' }}"
                                               placeholder="@lang('site::repair.placeholder.date_trade')"
                                               value="{{ old('date_trade', $repair->date_trade) }}" required>
                                        <span class="invalid-feedback">{{ $errors->first('date_trade') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->date_trade()}}</div>
                                    @endif
                                </div>

                                @include('site::repair.field.launch_id')
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_launch">@lang('site::repair.date_launch')</label>
                                    @if($fails->contains('field', 'date_launch'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <input type="date" name="date_launch" id="date_launch"
                                               class="form-control{{ $errors->has('date_launch') ? ' is-invalid' : '' }}"
                                               placeholder="@lang('site::repair.placeholder.date_launch')"
                                               value="{{ old('date_launch', $repair->date_launch) }}" required>
                                        <span class="invalid-feedback">{{ $errors->first('date_launch') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->date_launch()}}</div>
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
                                        <input type="date" name="date_call" id="date_call"
                                               class="form-control{{ $errors->has('date_call') ? ' is-invalid' : '' }}"
                                               placeholder="@lang('site::repair.placeholder.date_call')"
                                               value="{{ old('date_call', $repair->date_call) }}" required>
                                        <span class="invalid-feedback">{{ $errors->first('date_call') }}</span>
                                    @else
                                        <div class="text-success text-big">{{$repair->date_call()}}</div>
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
                                        <input type="date" name="date_repair" id="date_repair"
                                               class="form-control{{ $errors->has('date_repair') ? ' is-invalid' : '' }}"
                                               placeholder="@lang('site::repair.placeholder.date_repair')"
                                               value="{{ old('date_repair', $repair->date_repair) }}" required>
                                        <span class="invalid-feedback">{{ $errors->first('date_repair') }}</span>
                                    @else
                                        <div class="text-success text-big">{!! $repair->date_repair() !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.payment')</h5>
                                {{-- РАБОТА --}}
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="allow_work">@lang('site::repair.allow_work')</label>
                                    @if($fails->contains('field', 'allow_work'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('allow_work') ? ' is-invalid' : '' }}"
                                                required
                                                name="allow_work"
                                                id="allow_work">
                                            <option value="">@lang('site::messages.select_from_list')</option>

                                            <option @if(old('allow_work', $repair->allow_work) == 0 ) selected @endif
                                            value="0">@lang('site::messages.no')</option>
                                            <option @if(old('allow_work', $repair->allow_work) == 1 ) selected @endif
                                            value="1">@lang('site::messages.yes')</option>

                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('allow_work') }}</span>
                                    @else
                                        <div class="text-success text-big">@bool(['bool' => $repair->allow_work == 1])@endbool</div>
                                    @endif
                                </div>
                                {{-- ДОРОГА --}}
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="allow_road">@lang('site::repair.allow_road')</label>
                                    @if($fails->contains('field', 'allow_road'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('allow_road') ? ' is-invalid' : '' }}"
                                                required
                                                name="allow_road"
                                                id="allow_road">
                                            <option value="">@lang('site::messages.select_from_list')</option>

                                            <option @if(old('allow_road', $repair->allow_road) == 0 ) selected @endif
                                            value="0">@lang('site::messages.no')</option>
                                            <option @if(old('allow_road', $repair->allow_road) == 1 ) selected @endif
                                            value="1">@lang('site::messages.yes')</option>

                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('allow_road') }}</span>
                                    @else
                                        <div class="text-success text-big">@bool(['bool' => $repair->allow_road == 1])@endbool</div>
                                    @endif
                                </div>
                                {{-- ЗАПЧАСТИ --}}
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="allow_parts">@lang('site::repair.allow_parts')</label>
                                    @if($fails->contains('field', 'allow_parts'))
                                        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        <select class="form-control{{  $errors->has('allow_parts') ? ' is-invalid' : '' }}"
                                                required
                                                name="allow_parts"
                                                id="allow_parts">
                                            <option @if(old('allow_parts', $repair->allow_parts) == 0 ) selected @endif
                                            value="0">@lang('site::messages.no')</option>
                                            <option @if(old('allow_parts', $repair->allow_parts) == 1 ) selected
                                                    @endif
                                                    value="1">@lang('site::messages.yes')</option>

                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('allow_parts') }}</span>
                                    @else
                                        <div class="text-success text-big">@bool(['bool' => $repair->allow_parts == 1])@endbool</div>
                                    @endif
                                </div>
                                @if($fails->contains('field', 'parts'))
                                    <fieldset id="parts-search-fieldset"
                                              style="display: @if(old('allow_parts', $repair->allow_parts) == 1) block @else none @endif;">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="parts_search">Найти замененную деталь</label>
                                            <select style="width:100%" class="form-control" id="parts_search">
                                                <option value=""></option>
                                            </select>
                                            <span class="invalid-feedback">Такая деталь ужде есть в списке</span>
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
                                                <div class="card-group" id="parts">
                                                    @foreach($parts as $part)

                                                        @include('site::part.repair.row', [
                                                                'product_id' => $part['product_id'],
                                                                'sku' => $part['sku'],
                                                                'image' => $part['image'],
                                                                'name' => $part['name'],
                                                                'cost' => $part['cost'],
                                                                'format' => $part['format'],
                                                                'count' => $part['count'],
                                                            ])
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
                                                    @include('site::part.repair.show', [
                                                            'product_id' => $part['product_id'],
                                                            'sku' => $part['sku'],
                                                            'image' => $part['image'],
                                                            'name' => $part['name'],
                                                            'cost' => $part['cost'],
                                                            'format' => $part['format'],
                                                            'count' => $part['count'],
                                                        ])
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
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </form>
                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::file.files')</h5>
                            @foreach($types as $type)
                                @if(in_array($type->id, [1,2,3]))
                                    @if($fails->contains('field', 'file_'.$type->id))

                                        <div class="form-group @if(in_array($type->id, [1,2])) required @endif form-control{{ $errors->has('file.'.$type->id) ? ' is-invalid' : '' }}">
                                            <div>
                                                <label class="control-label"
                                                       for="type_id">{{$type->name}}</label>
                                                <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                            </div>
                                            <form method="POST" enctype="multipart/form-data"
                                                  action="{{route('files.store')}}">
                                                @csrf
                                                <input type="hidden" name="type_id" value="{{$type->id}}"/>
                                                <input type="hidden" name="storage" value="repairs"/>
                                                <input type="file" name="path"/>
                                                <button class="btn btn-ferroli repair-file-upload"><i
                                                            class="fa fa-download"></i> @lang('site::messages.load')
                                                </button>

                                                <small id="fileHelp-{{$type->id}}"
                                                       class="form-text text-muted">{{$type->comment}}</small>
                                            </form>
                                            <ul class="list-group" class="file-list">
                                                @if( !$files->isEmpty())
                                                    @foreach($files as $file)
                                                        @if($file->type_id == $type->id)
                                                            @include('site::repair.field.file')
                                                            {{--<li class="list-group-item">--}}
                                                            {{--<a href="#"--}}
                                                            {{--onclick="$(this).parent().remove();return false;"--}}
                                                            {{--title="@lang('site::messages.delete')"--}}
                                                            {{--class="d-inline-block text-danger mr-2"><i--}}
                                                            {{--class="fa fa-close"></i></a>--}}
                                                            {{--<a href="{{ route('files.show', $file) }}"--}}
                                                            {{--class="">{{$file->name}}</a>--}}
                                                            {{--<input form="repair-form" type="hidden"--}}
                                                            {{--name="file[{{$file->type_id}}][]"--}}
                                                            {{--value="{{$file->id}}">--}}
                                                            {{--</li>--}}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('file.'.$type->id) }}</span>
                                    @else
                                        <div class="form-group @if(in_array($type->id, [1,2])) required @endif form-control">
                                            <label class="control-label d-block"
                                                   for="type_id">{{$type->name}}</label>
                                            <ul class="list-group file-list">
                                                @if( !$files->isEmpty())
                                                    @foreach($files as $file)
                                                        @if($file->type_id == $type->id)
                                                            <li class="list-group-item">
                                                                <a href="{{ route('files.show', $file) }}"
                                                                   class="">{{$file->name}}</a>
                                                                <input form="repair-form" type="hidden"
                                                                       name="file[{{$file->type_id}}][]"
                                                                       value="{{$file->id}}">
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>

                                    @endif
                                @endif
                            @endforeach
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
                                                <div class="@if($message->user_id == Auth::user()->id) chat-message-right @else chat-message-left @endif mb-4">
                                                    <div>
                                                        <img src="{{$message->user->logo}}"
                                                             style="width: 40px!important;"
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
                                <div class="row no-gutters">
                                    <div class="d-flex col flex-column">
                                        <div class="flex-grow-1 position-relative">
                                            <div class="form-group">
                                                <label class="control-label"
                                                       for="message_text">@lang('site::message.text')</label>
                                                <input type="hidden" name="message[receiver_id]"
                                                       form="repair-form"
                                                       value="{{$repair->user_id}}">
                                                <textarea name="message[text]"
                                                          id="message_text"
                                                          form="repair-form"
                                                          rows="3"
                                                          class="form-control{{  $errors->has('message.text') ? ' is-invalid' : '' }}"></textarea>
                                                <span class="invalid-feedback">{{ $errors->first('message.text') }}</span>
                                            </div>
                                            @foreach($statuses as $key => $status)
                                                <button
                                                        form="repair-form"
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