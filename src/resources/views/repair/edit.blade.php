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
                                        <a href="{{route('equipments.show', $repair->product->equipment)}}">
                                            {{$repair->product->equipment->catalog->name_plural}}
                                            {{$repair->product->equipment->name}}
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('site::serial.product_id')</label>
                                    <div class="text-big">{{$repair->product->name}}</div>
                                    <input type="hidden" value="{{$repair->product->id}}" id="product_id">
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
                                                <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                                <div class="card-group" id="parts">
                                                    @foreach($parts as $part)

                                                        @include('site::part.repair.row', [
                                                                'product_id' => $part['product_id'],
                                                                'sku' => $part['sku'],
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
                                <div class="form-group @if($type->required == 1) required @endif form-control{{ $errors->has('file.'.$type->id) ? ' is-invalid' : '' }}">
                                    <div>
                                        <label class="control-label"
                                               for="type_id">{{$type->name}}</label>
                                        @if($fails->contains('field', 'file_'.$type->id))
                                            <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
                                        @endif
                                    </div>
                                    <form method="POST" enctype="multipart/form-data"
                                          action="{{route('files.store')}}">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$type->id}}"/>
                                        <input type="hidden" name="storage" value="repairs"/>
                                        <input type="file" name="path"/>
                                        <button class="btn btn-ferroli file-type-upload"><i
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
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('file.'.$type->id) }}</span>
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