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
                <a href="{{ route('admin.contragents.index') }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.contragents.show', $contragent) }}">{{$contragent->name}}</a>
            </li>
            <li class="breadcrumb-item">{{$address->type->name}}</li>
            <li class="breadcrumb-item active">@lang('site::messages.edit') @lang('site::address.address')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$address->type->name}}</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="form" method="POST" action="{{ route('admin.contragents.addresses.update', [$contragent, $address]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row required">
                        <div class="col mb-3">
                            <input type="hidden"
                                   name="address[type_id]"
                                   value="{{$address->type_id}}">
                            <label class="control-label"
                                   for="address_country_id">@lang('site::address.country_id')</label>
                            <select class="country-select form-control
                                    {{$errors->has('address.country_id') ? ' is-invalid' : ''}}"
                                    data-regions="#address_region_id"
                                    data-empty="@lang('site::messages.select_from_list')"
                                    required
                                    name="address[country_id]"
                                    id="address_country_id">
                                @if($countries->count() == 0 || $countries->count() > 1)
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                @endif
                                @foreach($countries as $country)
                                    <option
                                            @if(old('address.country_id', $address->country_id) == $country->id)
                                            selected
                                            @endif
                                            value="{{ $country->id }}">{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('address.country_id') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">

                            <label class="control-label"
                                   for="address_region_id">@lang('site::address.region_id')</label>
                            <select class="form-control{{  $errors->has('address.region_id') ? ' is-invalid' : '' }}"
                                    name="address[region_id]"
                                    required
                                    id="address_region_id">
                                @if($regions->count() == 0 || $regions->count() > 1)
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                @endif
                                @foreach($regions as $region)
                                    <option
                                            @if(old('address.region_id', $address->region_id) == $region->id) selected
                                            @endif
                                            value="{{ $region->id }}">{{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('address.region_id') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="address_locality">@lang('site::address.locality')</label>
                            <input type="text"
                                   name="address[locality]"
                                   id="address_locality"
                                   required
                                   class="form-control{{ $errors->has('address.locality') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.locality')"
                                   value="{{ old('address.locality', $address->locality) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.locality') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="address_street">@lang('site::address.street')</label>
                            <input type="text"
                                   name="address[street]"
                                   id="address_street"
                                   class="form-control{{ $errors->has('address.street') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.street')"
                                   value="{{ old('address.street', $address->street) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.street') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_building">@lang('site::address.building')</label>
                                    <input type="text"
                                           name="address[building]"
                                           id="address_building"
                                           required
                                           class="form-control{{ $errors->has('address.building') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.building')"
                                           value="{{ old('address.building', $address->building) }}">
                                    <span class="invalid-feedback">{{ $errors->first('address.building') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_apartment">@lang('site::address.apartment')</label>
                                    <input type="text"
                                           name="address[apartment]"
                                           id="address_apartment"
                                           class="form-control{{ $errors->has('address.apartment') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.apartment')"
                                           value="{{ old('address.apartment', $address->apartment) }}">
                                    <span class="invalid-feedback">{{ $errors->first('address.apartment') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="form" type="submit" class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.contragents.show', $contragent) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection