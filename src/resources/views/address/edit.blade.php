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
            @if($address->addressable_type == 'contragents')
                <li class="breadcrumb-item">
                    <a href="{{ route('contragents.index') }}">@lang('site::contragent.contragents')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('contragents.show', $address->addressable) }}">{{$address->addressable->name}}</a>
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ route('addresses.index') }}">@lang('site::address.addresses')</a>
                </li>
            @endif
            <li class="breadcrumb-item">
                <a href="{{ route('addresses.show', $address) }}">{{$address->type->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{ $address->type->name }}</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="address-form" method="POST"
                      action="{{ route('addresses.update', $address) }}">

                    @csrf
                    @method('PUT')

                    <div class="form-row required">
                        <div class="col mb-3">
                            <input type="hidden"
                                   name="type_id"
                                   value="{{$address->type_id}}">
                            <label class="control-label" for="country_id">@lang('site::address.country_id')</label>
                            <select class="country-select form-control{{  $errors->has('country_id') ? ' is-invalid' : '' }}"
                                    name="country_id"
                                    required
                                    data-regions="#region_id"
                                    data-empty="@lang('site::messages.select_from_list')"
                                    id="country_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($countries as $country)
                                    <option
                                            @if(old('country_id', $address->country_id) == $country->id) selected
                                            @endif
                                            value="{{ $country->id }}">{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3 required">

                            <label class="control-label" for="region_id">@lang('site::address.region_id')</label>
                            <select class="form-control{{  $errors->has('region_id') ? ' is-invalid' : '' }}"
                                    name="region_id"
                                    required
                                    id="region_id">
                                <option value="">@lang('site::address.help.select_country')</option>
                                @foreach($regions as $region)
                                    <option
                                            @if(old('region_id', $address->region_id) == $region->id) selected
                                            @endif
                                            value="{{ $region->id }}">{{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('region_id') }}</strong>
                                    </span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="locality">@lang('site::address.locality')</label>
                            <input type="text"
                                   name="locality"
                                   id="locality"
                                   required
                                   class="form-control{{ $errors->has('locality') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.locality')"
                                   value="{{ old('locality', $address->locality) }}">
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('locality') }}</strong>
                                    </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="street">@lang('site::address.street')</label>
                            <input type="text"
                                   name="street"
                                   id="street"
                                   class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.street')"
                                   value="{{ old('street', $address->street) }}">
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="building">@lang('site::address.building')</label>
                                    <input type="text"
                                           name="building"
                                           required
                                           id="building"
                                           class="form-control{{ $errors->has('building') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.building')"
                                           value="{{ old('building', $address->building) }}">
                                    <span class="invalid-feedback">
                                                <strong>{{ $errors->first('building') }}</strong>
                                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="apartment">@lang('site::address.apartment')</label>
                                    <input type="text"
                                           name="apartment"
                                           id="apartment"
                                           class="form-control{{ $errors->has('apartment') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.apartment')"
                                           value="{{ old('apartment', $address->apartment) }}">
                                    <span class="invalid-feedback">
                                                <strong>{{ $errors->first('apartment') }}</strong>
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="address-form" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('addresses.show', $address) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection