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
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.create') @lang('site::repair.repair')</h1>

        @alert()@endalert()
        <div class="row justify-content-center mb-5">
            <div class="col">

                <form id="repair-form"
                      method="POST"
                      enctype="multipart/form-data"
                      action="{{ route('repairs.store') }}">
                    @csrf

                    <fieldset>

                        {{-- КЛИЕНТ --}}
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.client')</h5>
                                <div class="form-group mt-2 required">
                                    <label class="control-label" for="client">@lang('site::repair.client')</label>
                                    <input type="text" id="client" name="client"
                                           class="form-control{{ $errors->has('client') ? ' is-invalid' : '' }}"
                                           value="{{ old('client') }}"
                                           required
                                           placeholder="@lang('site::repair.placeholder.client')">
                                    <span class="invalid-feedback">{{ $errors->first('client') }}</span>
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="country_id">@lang('site::repair.country_id')</label>
                                    <select class="form-control{{  $errors->has('country_id') ? ' is-invalid' : '' }}"
                                            required
                                            name="country_id"
                                            id="country_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('country_id') == $country->id) selected
                                                    @endif
                                                    value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
                                </div>

                                <div class="form-group required">
                                    <label class="control-label" for="address">@lang('site::repair.address')</label>
                                    <input type="text" id="address" name="address"
                                           class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                           value="{{ old('address') }}"
                                           required
                                           placeholder="@lang('site::repair.placeholder.address')">
                                    <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="phone_primary">@lang('site::repair.phone_primary')</label>
                                    <input type="tel" id="phone_primary" name="phone_primary"
                                           class="form-control{{ $errors->has('phone_primary') ? ' is-invalid' : '' }}"
                                           pattern="^\d{10}$" maxlength="10"
                                           required
                                           value="{{ old('phone_primary') }}"
                                           placeholder="@lang('site::repair.placeholder.phone_primary')">
                                    <span class="invalid-feedback">{{ $errors->first('phone_primary') }}</span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label"
                                           for="phone_secondary">@lang('site::repair.phone_secondary')</label>
                                    <input type="tel" id="phone_secondary" name="phone_secondary"
                                           class="form-control{{ $errors->has('phone_secondary') ? ' is-invalid' : '' }}"
                                           pattern="^\d{10}$" maxlength="10"
                                           value="{{ old('phone_secondary') }}"
                                           placeholder="@lang('site::repair.placeholder.phone_secondary')">
                                    <span class="invalid-feedback">{{ $errors->first('phone_secondary') }}</span>
                                </div>
                            </div>
                        </div>

                        {{--ОРГАНИЗАЦИИ --}}

                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.org')</h5>
                                @include('site::repair.create.trade_id')
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_trade">@lang('site::repair.date_trade')</label>
                                    <input type="date" name="date_trade" id="date_trade"
                                           class="form-control{{ $errors->has('date_trade') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_trade')"
                                           required
                                           value="{{ old('date_trade') }}">
                                    <span class="invalid-feedback">{{ $errors->first('date_trade') }}</span>
                                </div>

                                @include('site::repair.create.launch_id')
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_launch">@lang('site::repair.date_launch')</label>
                                    <input type="date" name="date_launch" id="date_launch"
                                           class="form-control{{ $errors->has('date_launch') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_launch')"
                                           required
                                           value="{{ old('date_launch') }}">
                                    <span class="invalid-feedback">{{ $errors->first('date_launch') }}</span>
                                </div>
                            </div>
                        </div>

                        {{--ВЫЕЗД НА ОБСЛУЖИВАНИЕ --}}

                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.call')</h5>
                                @include('site::repair.create.engineer_id')
                                <div class="form-group required">
                                    <label class="control-label" for="date_call">@lang('site::repair.date_call')</label>
                                    <input type="date" name="date_call" id="date_call"
                                           class="form-control{{ $errors->has('date_call') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_call')"
                                           required
                                           value="{{ old('date_call') }}">
                                    <span class="invalid-feedback">{{ $errors->first('date_call') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="reason_call">@lang('site::repair.reason_call')</label>
                                    <textarea name="reason_call" id="reason_call"
                                              class="form-control{{ $errors->has('reason_call') ? ' is-invalid' : '' }}"
                                              required
                                              placeholder="@lang('site::repair.placeholder.reason_call')">{{ old('reason_call') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('reason_call') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="diagnostics">@lang('site::repair.diagnostics')</label>
                                    <textarea name="diagnostics" id="diagnostics"
                                              required
                                              class="form-control{{ $errors->has('diagnostics') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::repair.placeholder.diagnostics')">{{ old('diagnostics') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('diagnostics') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label" for="works">@lang('site::repair.works')</label>
                                    <textarea name="works" id="works"
                                              required
                                              class="form-control{{ $errors->has('works') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::repair.placeholder.works')">{{ old('works') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('works') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_repair">@lang('site::repair.date_repair')</label>
                                    <input type="date" name="date_repair" id="date_repair"
                                           class="form-control{{ $errors->has('date_repair') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_repair')"
                                           required
                                           value="{{ old('date_repair') }}">
                                    <span class="invalid-feedback">{{ $errors->first('date_repair') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- ОПЛАТА --}}
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.payment')</h5>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="contragent_id">@lang('site::repair.contragent_id')</label>
                                    <select class="form-control{{  $errors->has('contragent_id') ? ' is-invalid' : '' }}"
                                            required
                                            name="contragent_id"
                                            id="contragent_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($contragents as $contragent)
                                            <option
                                                    @if(old('contragent_id') == $contragent->id) selected
                                                    @endif
                                                    value="{{ $contragent->id }}">{{ $contragent->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('contragent_id') }}</span>
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="product_id">@lang('site::repair.product_id')</label>
                                    @if(old('product_id'))
                                        <select style="width:100%" title=""
                                                class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}">
                                            <option value="{{old('product_id')}}">{{$product}}</option>
                                        </select>
                                        <input type="hidden" name="product_id" value="{{old('product_id')}}"/>
                                    @else
                                        <select id="product_id" name="product_id" style="width:100%"
                                                class="form-control">
                                            <option value=""></option>
                                        </select>
                                    @endif
                                    <small id="product_idHelp" class="d-block form-text text-success">
                                        @lang('site::repair.placeholder.product_id')
                                    </small>

                                </div>

                                <div class="form-group ">
                                    <label class="control-label"
                                           for="serial_id">@lang('site::repair.serial_id')</label>
                                    <input type="text" name="serial_id" id="serial_id"
                                           class="form-control{{ $errors->has('serial_id') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.serial_id')"
                                           maxlength="20"
                                           value="{{ old('serial_id') }}"
                                           aria-label="Large" aria-describedby="inputGroup-sizing-sm">
                                    <span class="invalid-feedback">{{ $errors->first('serial_id') }}</span>
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="difficulty_id">@lang('site::repair.difficulty_id')</label>
                                    <select class="form-control{{  $errors->has('difficulty_id') ? ' is-invalid' : '' }}"
                                            required
                                            name="difficulty_id"
                                            id="difficulty_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($difficulties as $difficulty)
                                            <option data-cost="{{$difficulty->cost}}"
                                                    @if(old('difficulty_id') == $difficulty->id) selected
                                                    @endif
                                                    value="{{ $difficulty->id }}">{{ $difficulty->name }}@if($difficulty->cost > 0)
                                                    - {{ Site::format($difficulty->cost) }}@endif</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('difficulty_id') }}</span>
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="distance_id">@lang('site::repair.distance_id')</label>
                                    <select class="form-control{{  $errors->has('distance_id') ? ' is-invalid' : '' }}"
                                            required
                                            name="distance_id"
                                            id="distance_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($distances as $distance)
                                            <option data-cost="{{$distance->cost}}"
                                                    @if(old('distance_id') == $distance->id) selected
                                                    @endif
                                                    value="{{ $distance->id }}">{{ $distance->name }}@if($distance->cost > 0)
                                                    - {{ Site::format($distance->cost) }}@endif</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('distance_id') }}</span>
                                </div>


                                <fieldset id="product-search-fieldset">

                                </fieldset>

                                <fieldset id="parts-search-fieldset"
                                          style="display: @if( !old('allow_parts') || old('allow_parts') == 1) block @else none @endif;">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="parts_search">@lang('site::messages.find') @lang('site::part.part')</label>
                                        <select style="width:100%" class="form-control" id="parts_search">
                                            <option value=""></option>
                                        </select>
                                        <span class="invalid-feedback">Такая деталь ужде есть в списке</span>
                                        <small id="partsHelp"
                                               class="d-block form-text text-success">Введите артикул или наименование
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
                                                        {{Site::format($parts->sum('cost') + old('cost_difficulty', 0) + old('cost_distance', 0))}}
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
                            </div>
                        </div>
                    </fieldset>
                </form>
                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::file.files')</h5>
                            @foreach($types as $type)

                                <div class="form-group @if($type->required) required @endif form-control{{ $errors->has('file.'.$type->id) ? ' is-invalid' : '' }}">
                                    <label class="control-label d-block" for="type_id">{{$type->name}}</label>
                                    <form method="POST" enctype="multipart/form-data"
                                          action="{{route('files.store')}}">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$type->id}}"/>
                                        <input type="hidden" name="storage" value="repairs"/>
                                        <input type="file" name="path"/>
                                        <button class="btn btn-ferroli repair-file-upload">
                                            <i class="fa fa-download"></i> @lang('site::messages.load')
                                        </button>
                                        <small id="fileHelp-{{$type->id}}"
                                               class="form-text text-muted">{{$type->comment}}</small>
                                    </form>
                                    <ul class="list-group" class="file-list">
                                        @if($files->isNotEmpty())
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
                    <div class="form-row">
                        <div class="col text-right">
                            <button name="_create" form="repair-form" value="1" type="submit"
                                    class="btn btn-ferroli mb-1">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save_add')</span>
                            </button>
                            <button name="_create" form="repair-form" value="0" type="submit"
                                    class="btn btn-ferroli mb-1">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save')</span>
                            </button>
                            <a href="{{ route('repairs.index') }}" class="btn btn-secondary mb-1">
                                <i class="fa fa-close"></i>
                                <span>@lang('site::messages.cancel')</span>
                            </a>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
@endsection