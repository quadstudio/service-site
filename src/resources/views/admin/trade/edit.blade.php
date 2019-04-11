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
                <a href="{{ route('admin.trades.index') }}">@lang('site::trade.trades')</a>
            </li>
            <li class="breadcrumb-item">{{ $trade->name }}</li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::trade.trade')</h1>

        @alert()@endalert

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="trade-edit-form" method="POST" action="{{ route('admin.trades.update', $trade) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="name">@lang('site::trade.name')</label>
                            <input required
                                   type="text"
                                   name="trade[name]"
                                   id="name"
                                   class="form-control{{ $errors->has('trade.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.name')"
                                   value="{{ old('trade.name', optional($trade)->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('trade.name') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="country_id">@lang('site::trade.country_id')</label>
                                    <select required
                                            name="trade[country_id]"
                                            id="country_id"
                                            class="form-control{{  $errors->has('trade.country_id') ? ' is-invalid' : '' }}">
                                        @if($countries->count() == 0 || $countries->count() > 1)
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                        @endif
                                        @foreach($countries as $country)
                                            <option @if(old('trade.country_id', optional($trade)->country_id) == $country->id)
                                                    selected
                                                    @endif
                                                    value="{{ $country->id }}">
                                                {{ $country->name }}
                                                {{ $country->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('trade.country_id') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="contact">@lang('site::trade.phone')</label>
                                    <input required
                                           type="tel"
                                           name="trade[phone]"
                                           id="phone"
                                           oninput="mask_phones()"
                                           pattern="{{config('site.phone.pattern')}}"
                                           maxlength="{{config('site.phone.maxlength')}}"
                                           title="{{config('site.phone.format')}}"
                                           data-mask="{{config('site.phone.mask')}}"
                                           class="phone-mask form-control{{ $errors->has('trade.phone') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::trade.placeholder.phone')"
                                           value="{{ old('trade.phone', optional($trade)->phone) }}">
                                    <span class="invalid-feedback">{{ $errors->first('trade.phone') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="address">@lang('site::trade.address')</label>
                            <input type="text"
                                   name="trade[address]"
                                   id="address"
                                   class="form-control{{ $errors->has('trade.address') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.address')"
                                   value="{{ old('trade.address', optional($trade)->address) }}">
                            <span class="invalid-feedback">{{ $errors->first('trade.address') }}</span>
                        </div>
                    </div>
                </form>
                <div class="form-row border-top pt-3">
                    <div class="col text-right">
                        <button form="trade-edit-form" type="submit"
                                class="btn btn-ferroli  mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.trades.index', ['filter[user]='.$trade->user_id]) }}" class="d-block d-sm-inline btn btn-secondary">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection