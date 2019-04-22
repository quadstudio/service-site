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
                <a href="{{ route('admin.mounters.index') }}">@lang('site::mounter.mounters')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.mounters.show', $mounter) }}">№ {{$mounter->id}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::mounter.mounter')</h1>

        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a href="{{ route('mounter-requests') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col">

                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <form id="form-content"
                              method="POST"
                              enctype="multipart/form-data"
                              action="{{ route('admin.mounters.update', $mounter) }}">

                            @csrf
                            @method('PUT')

                            <div class="form-row required">
                                <label class="control-label"
                                       for="status_id">@lang('site::mounter.status_id')</label>
                                <select class="form-control{{  $errors->has('mounter.status_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="mounter[status_id]"
                                        id="status_id">
                                    @if($mounter_statuses->count() == 0 || $mounter_statuses->count() > 1)
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($mounter_statuses as $mounter_status)
                                        <option
                                                @if(old('mounter.status_id', $mounter->status_id) == $mounter_status->id) selected
                                                @endif
                                                value="{{ $mounter_status->id }}">{{ $mounter_status->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounter.status_id') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label"
                                       for="mounter_at">@lang('site::mounter.mounter_at')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_mounter_at"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="mounter[mounter_at]"
                                           id="mounter_at"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::mounter.placeholder.mounter_at')"
                                           data-target="#datetimepicker_mounter_at"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('mounter.mounter_at') ? ' is-invalid' : '' }}"
                                           value="{{ old('mounter.mounter_at', $mounter->mounter_at->format('d.m.Y')) }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_mounter_at"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('mounter.mounter_at') }}</span>
                            </div>

                            <div class="form-row mt-2">
                                <label class="control-label" for="client">@lang('site::mounter.model')</label>
                                <input type="text"
                                       id="model"
                                       name="mounter[model]"
                                       class="form-control{{ $errors->has('mounter.model') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounter.model', $mounter->model) }}"
                                       placeholder="@lang('site::mounter.placeholder.model')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.model') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label" for="address">@lang('site::mounter.address')</label>
                                <input required
                                       type="text"
                                       id="address"
                                       name="mounter[address]"
                                       class="form-control{{ $errors->has('mounter.address') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounter.address', $mounter->address) }}"
                                       placeholder="@lang('site::mounter.placeholder.address')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.address') }}</span>
                            </div>

                            <div class="form-row mt-2 required">
                                <label class="control-label" for="client">@lang('site::mounter.client')</label>
                                <input required
                                       type="text"
                                       id="client"
                                       name="mounter[client]"
                                       class="form-control{{ $errors->has('mounter.client') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounter.client', $mounter->client) }}"
                                       placeholder="@lang('site::mounter.placeholder.client')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.client') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label"
                                       for="country_id">@lang('site::mounter.country_id')</label>
                                <select class="form-control{{  $errors->has('mounter.country_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="mounter[country_id]"
                                        id="country_id">
                                    @if($countries->count() == 0 || $countries->count() > 1)
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($countries as $country)
                                        <option
                                                @if(old('mounter.country_id', $mounter->country_id) == $country->id) selected
                                                @endif
                                                value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounter.country_id') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label"
                                       for="phone">@lang('site::mounter.phone')</label>
                                <input required
                                       type="tel"
                                       oninput="mask_phones()"
                                       id="phone"
                                       name="mounter[phone]"
                                       class="phone-mask form-control{{ $errors->has('mounter.phone') ? ' is-invalid' : '' }}"
                                       pattern="{{config('site.phone.pattern')}}"
                                       maxlength="{{config('site.phone.maxlength')}}"
                                       title="{{config('site.phone.format')}}"
                                       data-mask="{{config('site.phone.mask')}}"
                                       value="{{ old('mounter.phone', $mounter->phone) }}"
                                       placeholder="@lang('site::mounter.placeholder.phone')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.phone') }}</span>
                            </div>
                        </form>
                        <hr/>
                        <div class="form-row">
                            <div class="col text-right">
                                <button form="form-content" type="submit"
                                        class="btn btn-ferroli mb-1">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('mounter-requests') }}" class="btn btn-secondary mb-1">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
