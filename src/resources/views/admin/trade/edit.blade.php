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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.trades.show', $trade) }}">{{ $trade->name }}</a>
            </li>
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
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::trade.name')</label>
                            <input type="text"
                                   required
                                   name="name"
                                   id="name"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.name')"
                                   value="{{ old('name', $trade->name) }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">

                            <label class="control-label" for="country_id">@lang('site::trade.country_id')</label>
                            <select class="form-control{{  $errors->has('country_id') ? ' is-invalid' : '' }}"
                                    required
                                    name="country_id" id="country_id" >
                                @foreach($countries as $country)
                                    <option @if($country->id == $trade->country_id) selected
                                            @endif value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="contact">@lang('site::trade.phone')</label>
                            <input type="tel"
                                   required
                                   name="phone"
                                   id="phone"
                                   title="@lang('site::trade.placeholder.phone')"
                                   pattern="^\d{9,10}$" maxlength="10"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.phone')"
                                   value="{{ old('phone', $trade->phone) }}" >
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                            <small id="phoneHelp" class="mb-4 form-text text-success">
                                @lang('site::trade.help.phone')
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="address">@lang('site::trade.address')</label>
                            <input type="text"
                                   name="address"
                                   id="address"
                                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.address')"
                                   value="{{ old('address', $trade->address) }}">
                            @if ($errors->has('address'))
                                <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class=" border p-3 mb-2">

            <button form="trade-edit-form" name="_stay" value="0" type="submit"
                    class="btn btn-ferroli  mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('admin.trades.show', $trade) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection