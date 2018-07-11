@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('repair::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('repairs.index') }}">@lang('repair::repair.repairs')</a>
            </li>
            <li class="breadcrumb-item active">@lang('repair::messages.create')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">@lang('repair::messages.create') @lang('repair::repair.repair')</h1>
        <hr/>

        @include('alert')

        {{ dump($errors) }}

        <div class="row justify-content-center mb-5">
            <div class="col-md-8">

                <form id="repair-create-form" method="POST" enctype="multipart/form-data"
                      action="{{ route('repairs.store') }}">

                    @csrf

                    <div class="form-row">
                        <div class="col mb-3">

                            <div class="input-group input-group-lg">

                                <input type="text" name="serial" id="serial"
                                       class="form-control{{ $errors->has('serial') ? ' is-invalid' : '' }}"
                                       placeholder="@lang('repair::repair.placeholder.serial')"
                                       value="{{ old('serial') }}" required
                                       aria-label="Large" aria-describedby="inputGroup-sizing-sm">
                                <div class="input-group-append">
                                    <button class="btn btn-primary"
                                            type="button">@lang('repair::messages.check')</button>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('serial') }}</span>
                            </div>
                            <small id="serialHelp"
                                   class="d-block form-text text-muted">@lang('repair::repair.help.serial')</small>

                        </div>
                    </div>

                    <fieldset>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('repair::repair.header.repair')</h5>
                                <div class="form-group">
                                    <label for="number">@lang('repair::repair.number')</label>
                                    <input type="text" id="number" name="number"
                                           class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}"
                                           value="{{ old('number') }}" required
                                           placeholder="@lang('repair::repair.placeholder.number')">
                                    <span class="invalid-feedback">{{ $errors->first('number') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="warranty_number">@lang('repair::repair.warranty_number')</label>
                                    <input type="text" id="warranty_number" name="warranty_number"
                                           class="form-control{{ $errors->has('warranty_number') ? ' is-invalid' : '' }}"
                                           value="{{ old('warranty_number') }}" required
                                           placeholder="@lang('repair::repair.placeholder.warranty_number')">
                                    <span class="invalid-feedback">{{ $errors->first('warranty_number') }}</span>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="" for="">@lang('repair::repair.warranty_period')</label>
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
                                <h5 class="card-title">@lang('repair::repair.header.client')</h5>
                                <div class="form-group mt-2">
                                    <label for="client">@lang('repair::repair.client')</label>
                                    <input type="text" id="client" name="client"
                                           class="form-control{{ $errors->has('client') ? ' is-invalid' : '' }}"
                                           value="{{ old('client') }}" required
                                           placeholder="@lang('repair::repair.placeholder.client')">
                                    <span class="invalid-feedback">{{ $errors->first('client') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="country_id">@lang('repair::repair.country_id')</label>
                                    <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="country_id" id="country_id">
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="address">@lang('repair::repair.address')</label>
                                    <input type="text" id="address" name="address"
                                           class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                           value="{{ old('address') }}" required
                                           placeholder="@lang('repair::repair.placeholder.address')">
                                    <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="phone_primary">@lang('repair::repair.phone_primary')</label>
                                    <input type="tel" id="phone_primary" name="phone_primary"
                                           class="form-control{{ $errors->has('phone_primary') ? ' is-invalid' : '' }}"
                                           pattern="^\d{10}$" maxlength="10" required
                                           value="{{ old('phone_primary') }}"
                                           placeholder="@lang('repair::repair.placeholder.phone_primary')">
                                    <span class="invalid-feedback">{{ $errors->first('phone_primary') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="phone_secondary">@lang('repair::repair.phone_secondary')</label>
                                    <input type="tel" id="phone_secondary" name="phone_secondary"
                                           class="form-control{{ $errors->has('phone_secondary') ? ' is-invalid' : '' }}"
                                           pattern="^\d{10}$" maxlength="10" required
                                           value="{{ old('phone_secondary') }}"
                                           placeholder="@lang('repair::repair.placeholder.phone_secondary')">
                                    <span class="invalid-feedback">{{ $errors->first('phone_secondary') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('repair::repair.header.org')</h5>
                                @include('repair::repair.field.trade_id')
                                <div class="form-group">
                                    <label for="date_trade">@lang('repair::repair.date_trade')</label>
                                    <input type="date" name="date_trade" id="date_trade"
                                           class="form-control{{ $errors->has('date_trade') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('repair::repair.placeholder.date_trade')"
                                           value="{{ old('date_trade') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_trade') }}</span>
                                </div>

                                @include('repair::repair.field.launch_id')
                                <div class="form-group">
                                    <label for="date_launch">@lang('repair::repair.date_launch')</label>
                                    <input type="date" name="date_launch" id="date_launch"
                                           class="form-control{{ $errors->has('date_launch') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('repair::repair.placeholder.date_launch')"
                                           value="{{ old('date_launch') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_launch') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('repair::repair.header.call')</h5>
                                @include('repair::repair.field.engineer_id')
                                <div class="form-group">
                                    <label for="date_call">@lang('repair::repair.date_call')</label>
                                    <input type="date" name="date_call" id="date_call"
                                           class="form-control{{ $errors->has('date_call') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('repair::repair.placeholder.date_call')"
                                           value="{{ old('date_call') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_call') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="reason_call">@lang('repair::repair.reason_call')</label>
                                    <textarea name="reason_call" id="reason_call"
                                              placeholder="@lang('repair::repair.placeholder.reason_call')"
                                              class="form-control{{ $errors->has('reason_call') ? ' is-invalid' : '' }}"
                                              required>{{ old('reason_call') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('reason_call') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="diagnostics">@lang('repair::repair.diagnostics')</label>
                                    <textarea name="diagnostics" id="diagnostics"
                                              placeholder="@lang('repair::repair.placeholder.diagnostics')"
                                              class="form-control{{ $errors->has('diagnostics') ? ' is-invalid' : '' }}"
                                              required>{{ old('diagnostics') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('diagnostics') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="works">@lang('repair::repair.works')</label>
                                    <textarea name="works" id="works"
                                              placeholder="@lang('repair::repair.placeholder.works')"
                                              class="form-control{{ $errors->has('works') ? ' is-invalid' : '' }}"
                                              required>{{ old('works') }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('works') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="date_repair">@lang('repair::repair.date_repair')</label>
                                    <input type="date" name="date_repair" id="date_repair"
                                           class="form-control{{ $errors->has('date_repair') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('repair::repair.placeholder.date_repair')"
                                           value="{{ old('date_repair') }}" required>
                                    <span class="invalid-feedback">{{ $errors->first('date_repair') }}</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <fieldset>
                    @foreach($types as $type)
                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">{{$type->name}}</h5>
                                <form method="POST" enctype="multipart/form-data" action="{{route('files.store')}}">
                                    @csrf

                                    <div class="form-group form-control{{ $errors->has('file.'.$type->id) ? ' is-invalid' : '' }}">
                                        <input type="hidden" name="type_id" value="{{$type->id}}"/>
                                        <input type="file" name="path"/>
                                        <input type="button" class="btn btn-primary repair-file-upload"
                                               value="@lang('repair::messages.load')">
                                        <small id="fileHelp-{{$type->id}}"
                                               class="form-text text-muted">{{$type->comment}}</small>

                                    </div>
                                    <span class="invalid-feedback">{{ $errors->first('file.'.$type->id) }}</span>
                                </form>
                                <ul class="list-group" class="file-list">
                                    @if( !$files->isEmpty())
                                        @foreach($files as $file)
                                            @if($file->type_id == $type->id)
                                                @include('repair::repair.field.file')
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </fieldset>
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="repair-create-form" value="1" type="submit"
                                class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('repair::messages.save_add')</span>
                        </button>
                        <button name="_create" form="repair-create-form" value="0" type="submit"
                                class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('repair::messages.save')</span>
                        </button>
                        <a href="{{ route('repairs.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('repair::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection