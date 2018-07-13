@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('trades.index') }}">@lang('site::trade.trades')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('trades.show', $trade) }}">{{ $trade->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::trade.trade')</h1>
        <hr/>

        @alert()@endalert

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">

                <form method="POST" action="{{ route('trades.update', $trade) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name">@lang('site::trade.name')</label>
                            <input type="text" name="name" id="name" disabled
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.name')"
                                   value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">

                            <label for="country_id">@lang('site::trade.country_id')</label>
                            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="country_id" id="country_id">
                                @foreach($countries as $country)
                                    <option @if($country->id == $trade->country_id) selected @endif value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="contact">@lang('site::trade.phone')</label>
                            <input type="tel" name="phone" id="phone"
                                   title="@lang('site::trade.placeholder.phone')"
                                   pattern="^\d{10}$" maxlength="10"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.phone')"
                                   value="{{ old('phone', $trade->phone) }}" required>
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
                            <label for="address">@lang('site::trade.address')</label>
                            <input type="text" name="address" id="address"
                                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::trade.placeholder.address')"
                                   value="{{ old('address', $trade->address) }}" disabled>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col text-right">
                            <button name="_stay" value="1" type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save_stay')</span>
                            </button>
                            <button name="_stay" value="0" type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save')</span>
                            </button>
                            <a href="{{ route('trades.index') }}" class="btn btn-secondary">
                                <i class="fa fa-close"></i>
                                <span>@lang('site::messages.cancel')</span>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection