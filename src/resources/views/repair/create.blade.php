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

                <form id="repair-create-form"
                      method="POST"
                      enctype="multipart/form-data"
                      action="{{ route('repairs.store') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col mb-3">

                            <div class="input-group input-group-lg">

                                <input type="text" name="serial_id" id="serial_id"
                                       class="form-control{{ $errors->has('serial_id') ? ' is-invalid' : '' }}"
                                       placeholder="@lang('site::repair.placeholder.serial_id')"
                                       maxlength="20"
                                       value="{{ old('serial_id') }}" required
                                       aria-label="Large" aria-describedby="inputGroup-sizing-sm">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" disabled="disabled" id="serial-check-button"
                                            type="button"><i
                                                class="fa fa-check-circle"></i> @lang('site::messages.check')</button>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('serial_id') }}</span>
                                <span class="invalid-feedback"><i
                                            class="fa fa-close"></i> {{ trans('site::repair.error.serial_id') }}</span>
                            </div>
                            <div id="serial-success" class="alert alert-success mt-3" role="alert" style="display: none;">
                                <h4 class="alert-heading"><i class="fa fa-check"></i> Серийный номер проверен!</h4>
                                <table class="table table-sm">
                                    <tbody>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::serial.serial_id')</b></td>
                                        <td class="serial-serial"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::equipment.catalog_id')</b></td>
                                        <td class="serial-catalog"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::product.equipment_id')</b></td>
                                        <td class="serial-model"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::serial.product_id')</b></td>
                                        <td class="serial-product"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::product.sku')</b></td>
                                        <td class="serial-sku"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::equipment.cost_work')</b></td>
                                        <td class="serial-cost_work"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::equipment.cost_road')</b></td>
                                        <td class="serial-cost_road"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>@lang('site::equipment.currency_id')</b></td>
                                        <td class="serial-currency"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <p class="mb-0">Теперь вы можете заполнить отчет по ремонту</p>
                            </div>
                            <div id="serial-error" class="alert alert-danger mt-3" role="alert" style="display: none;">
                                <h4 class="alert-heading"><i class="fa fa-close"></i> Серийный номер не найден!</h4>
                                <p class="mb-0">Проверьте правильность серийного номера</p>
                                <hr />
                                <p class="mb-0">Если вы уверены, что серийный номер правильный - обратитесь к менеджеру</p>
                            </div>
                            <small id="serialHelp"
                                   class="d-block form-text text-muted">@lang('site::repair.help.serial_id')</small>
                        </div>
                    </div>

                    <fieldset>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                                <div class="form-group required">
                                    <label class="control-label" for="number">@lang('site::repair.number')</label>
                                    <input type="text"
                                           id="number"
                                           name="number"
                                           class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}"
                                           value="{{ old('number') }}"
                                           required
                                           placeholder="@lang('site::repair.placeholder.number')">
                                    <span class="invalid-feedback">{{ $errors->first('number') }}</span>
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


                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.client')</h5>
                                <div class="form-group mt-2 required">
                                    <label for="client">@lang('site::repair.client')</label>
                                    <input type="text" id="client" name="client"
                                           class="form-control{{ $errors->has('client') ? ' is-invalid' : '' }}"
                                           value="{{ old('client') }}" required
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
                                           value="{{ old('address') }}" required
                                           placeholder="@lang('site::repair.placeholder.address')">
                                    <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                                </div>

                                <div class="form-group required">
                                    <label class="control-label"
                                           for="phone_primary">@lang('site::repair.phone_primary')</label>
                                    <input type="tel" id="phone_primary" name="phone_primary"
                                           class="form-control{{ $errors->has('phone_primary') ? ' is-invalid' : '' }}"
                                           pattern="^\d{10}$" maxlength="10" required
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
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.org')</h5>
                                @include('site::repair.field.trade_id')
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_trade">@lang('site::repair.date_trade')</label>
                                    <input type="date" name="date_trade" id="date_trade"
                                           class="form-control{{ $errors->has('date_trade') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_trade')"
                                           value="{{ old('date_trade') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_trade') }}</span>
                                </div>

                                @include('site::repair.field.launch_id')
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_launch">@lang('site::repair.date_launch')</label>
                                    <input type="date" name="date_launch" id="date_launch"
                                           class="form-control{{ $errors->has('date_launch') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_launch')"
                                           value="{{ old('date_launch') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_launch') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::repair.header.call')</h5>
                                @include('site::repair.field.engineer_id')
                                <div class="form-group required">
                                    <label class="control-label" for="date_call">@lang('site::repair.date_call')</label>
                                    <input type="date" name="date_call" id="date_call"
                                           class="form-control{{ $errors->has('date_call') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_call')"
                                           value="{{ old('date_call') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_call') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="reason_call">@lang('site::repair.reason_call')</label>
                                    <textarea name="reason_call" id="reason_call"
                                              placeholder="@lang('site::repair.placeholder.reason_call')"
                                              class="form-control{{ $errors->has('reason_call') ? ' is-invalid' : '' }}"
                                              required>{{ old('reason_call') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('reason_call') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="diagnostics">@lang('site::repair.diagnostics')</label>
                                    <textarea name="diagnostics" id="diagnostics"
                                              placeholder="@lang('site::repair.placeholder.diagnostics')"
                                              class="form-control{{ $errors->has('diagnostics') ? ' is-invalid' : '' }}"
                                              required>{{ old('diagnostics') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('diagnostics') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label" for="works">@lang('site::repair.works')</label>
                                    <textarea name="works" id="works"
                                              placeholder="@lang('site::repair.placeholder.works')"
                                              class="form-control{{ $errors->has('works') ? ' is-invalid' : '' }}"
                                              required>{{ old('works') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('works') }}</span>
                                </div>
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="date_repair">@lang('site::repair.date_repair')</label>
                                    <input type="date" name="date_repair" id="date_repair"
                                           class="form-control{{ $errors->has('date_repair') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::repair.placeholder.date_repair')"
                                           value="{{ old('date_repair') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_repair') }}</span>
                                </div>

                                <div class="form-row">
                                    <div class="col mb-3">

                                        <div class="custom-control custom-checkbox">
                                            <input name="allow_work"
                                                   type="checkbox"
                                                   @if(old('allow_work')) checked @endif
                                                   class="custom-control-input"
                                                   value="1"
                                                   id="allow_work">
                                            <input type="hidden" name="cost_work" class="serial-cost_work" value="">
                                            <label class="custom-control-label"
                                                   for="allow_work">@lang('site::repair.allow_work') (<span class="serial-cost_work">0</span>)</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col mb-3">

                                        <div class="custom-control custom-checkbox">
                                            <input name="allow_road"
                                                   type="checkbox"
                                                   @if(old('allow_road')) checked @endif
                                                   class="custom-control-input"
                                                   value="1"
                                                   id="allow_road">
                                            <input type="hidden" name="cost_work" class="serial-cost_road-value" value="">
                                            <label class="custom-control-label"
                                                   for="allow_road">@lang('site::repair.allow_road') (<span class="serial-cost_work">0</span>)</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col mb-3">

                                        <div class="custom-control custom-checkbox">
                                            <input name="allow_parts"
                                                   type="checkbox"
                                                   @if(old('allow_parts')) checked @endif
                                                   class="custom-control-input"
                                                   value="1"
                                                   id="allow_parts">
                                            <label class="custom-control-label"
                                                   for="allow_parts">@lang('site::repair.allow_parts')</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label"
                                           for="parts_search">Найти замененную деталь</label>
                                    <select style="width:100%" class="form-control" id="parts_search" disabled>
                                        <option value=""></option>
                                    </select>
                                    <small id="partsHelp"
                                           class="d-block form-text text-success">Введите артикул или наименование
                                        заменённой детали и выберите её из списка
                                    </small>
                                </div>

                                <div class="form-row">
                                    <div class="col my-3">
                                        <label class="control-label"
                                               for="">Замененные детали</label>
                                        <table class="table table-sm table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">@lang('site::product.sku')</th>
                                                <th scope="col">@lang('site::product.name')</th>
                                                <th scope="col">@lang('site::product.quantity')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="parts">
                                            @if(old('parts'))
                                                @foreach(old('parts') as $part_id => $part)
                                                    <tr>
                                                        <td>{{$part['sku']}}</td>
                                                        <td>{{$part['name']}}</td>
                                                        <td>
                                                            <input type="hidden" name="parts[{{$part_id}}][product_id]"
                                                                   value="{{$part_id}}">
                                                            <input name="parts[{{$part_id}}][count]"
                                                                   placeholder="Количество"
                                                                   class="form-control"
                                                                   type="number" min="1" max="5" maxlength="1" title=""
                                                                   value="1">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>39819810</td>
                                                    <td>Теплообменник первичный (основной)</td>
                                                    <td>
                                                        <input type="hidden" name="parts[00030493][product_id]"
                                                               value="00030493">
                                                        <input name="parts[00030493][count]" placeholder="Количество"
                                                               class="form-control"
                                                               type="number" min="1" max="5" maxlength="1" title=""
                                                               value="1">
                                                    </td>
                                                </tr>
                                            @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{--<small id="serialHelp"--}}
                                {{--class="d-block form-text text-muted">@lang('site::repair.help.serial')</small>--}}

                                {{--<div class="form-group">--}}
                                {{--<label class="control-label"--}}
                                {{--for="parts">Поиск запчастей</label>--}}
                                {{--<input class="form-control"--}}
                                {{--required disabled--}}
                                {{--data-url="{{route('api.products.index')}}"--}}
                                {{--placeholder="@lang('site::repair.help.product_select')"--}}
                                {{--id="parts" />--}}
                                {{--<span class="invalid-feedback">{{ $errors->first('country_id') }}</span>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </fieldset>
                </form>
                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::file.files')</h5>
                            @foreach($types as $type)

                                <form method="POST" enctype="multipart/form-data" action="{{route('files.store')}}">
                                    @csrf
                                    <div class="form-group required form-control{{ $errors->has('file.'.$type->id) ? ' is-invalid' : '' }}">
                                        <label class="control-label d-block" for="type_id">{{$type->name}}</label>
                                        <input type="hidden" name="type_id" value="{{$type->id}}"/>
                                        <input type="file" name="path"/>
                                        <button class="btn btn-primary repair-file-upload"><i
                                                    class="fa fa-download"></i> @lang('site::messages.load')</button>
                                        <small id="fileHelp-{{$type->id}}"
                                               class="form-text text-muted">{{$type->comment}}</small>
                                        <span class="invalid-feedback">{{ $errors->first('file.'.$type->id) }}</span>
                                    </div>
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

                            @endforeach
                        </div>
                    </div>
                </fieldset>
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="repair-create-form" value="1" type="submit"
                                class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save_add')</span>
                        </button>
                        <button name="_create" form="repair-create-form" value="0" type="submit"
                                class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('repairs.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection