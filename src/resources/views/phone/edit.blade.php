@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            @if($phone->phoneable_type == 'addresses')
                <li class="breadcrumb-item">
                    <a href="{{ route('addresses.index') }}">@lang('site::address.addresses')</a>
                </li>
            @elseif($phone->phoneable_type == 'contacts')
                <li class="breadcrumb-item">
                    <a href="{{ route('contacts.index') }}">@lang('site::contact.contacts')</a>
                </li>
            @endif
            <li class="breadcrumb-item active">@lang('site::messages.edit') @lang('site::phone.phone')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit')  @lang('site::phone.phone') {{ $phone->format() }}</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="phone-form" method="POST"
                      action="{{ route('phones.update', $phone) }}">

                    @csrf
                    @method('PUT')

                    <div class="form-row required">
                        <div class="col mb-3">

                            <label class="control-label"
                                   for="country_id">@lang('site::phone.country_id')</label>
                            <select class="form-control{{  $errors->has('country_id') ? ' is-invalid' : '' }}"
                                    name="country_id"
                                    required
                                    id="country_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($countries as $country)
                                    <option
                                            @if(old('country_id', $phone->country_id) == $country->id) selected
                                            @endif
                                            value="{{ $country->id }}">{{ $country->name }}
                                        ({{ $country->phone }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="number">@lang('site::phone.number')</label>
                                    <input type="tel"
                                           required
                                           name="number"
                                           id="number"
                                           title="@lang('site::placeholder.number')"
                                           pattern="^\d{9,10}$"
                                           maxlength="10"
                                           class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::phone.placeholder.number')"
                                           value="{{ old('number', $phone->number) }}">
                                    <span class="invalid-feedback">{{ $errors->first('number') }}</span>
                                    <small id="phone_numberHelp"
                                           class="mb-4 form-text text-success">
                                        @lang('site::phone.help.number')
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="extra">@lang('site::phone.extra')</label>
                                    <input type="text"
                                           name="extra"
                                           id="phone_extra"
                                           class="form-control{{ $errors->has('extra') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::phone.placeholder.extra')"
                                           value="{{ old('extra', $phone->extra) }}">
                                    <span class="invalid-feedback">{{ $errors->first('extra') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="phone-form" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    @if($phone->phoneable_type == 'addresses')
                        <a href="{{ route('addresses.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    @elseif($phone->phoneable_type == 'contacts')
                        <a href="{{ route('contacts.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection