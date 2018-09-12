@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('contragents.index') }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::contragent.contragent')</h1>
        @alert()@endalert
        <div class="card mt-2 mb-2">
            <div class="card-body">

                <form id="contragent-form" method="POST" action="{{ route('contragents.store') }}">
                    @csrf
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="contragent_name">@lang('site::contragent.name')</label>
                            <input type="text"
                                   required
                                   name="contragent[name]"
                                   id="contragent_name"
                                   class="form-control{{ $errors->has('contragent.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contragent.placeholder.name')"
                                   value="{{ old('contragent.name') }}">
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('contragent.name') }}</strong>
                            </span>
                            <small id="contragent_nameHelp" class="form-text text-success">
                                @lang('site::contragent.help.name')
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_type_id">@lang('site::contragent.type_id')</label>
                                    @foreach($types as $key => $type)
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input
                                            {{$errors->has('contragent.type_id') ? ' is-invalid' : ''}}"
                                                   type="radio"
                                                   required
                                                   name="contragent[type_id]"
                                                   @if(old('contragent.type_id') == $type->id) checked @endif
                                                   id="contragent_type_id_{{ $type->id }}"
                                                   value="{{ $type->id }}">
                                            <label class="custom-control-label"
                                                   for="contragent_type_id_{{ $type->id }}">
                                                {{ $type->name }}
                                            </label>
                                            @if($key == $types->count()-1)
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('contragent.type_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="contragent_nds">@lang('site::contragent.nds')</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                       id="contragent_nds_1"
                                                       name="contragent[nds]"
                                                       required
                                                       @if(old('contragent.nds') == 1) checked @endif
                                                       value="1"
                                                       class="custom-control-input {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}">
                                                <label class="custom-control-label"
                                                       for="contragent_nds_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                       id="contragent_nds_0"
                                                       name="contragent[nds]"
                                                       required
                                                       @if(old('contragent.nds') == 0) checked @endif
                                                       value="0"
                                                       class="custom-control-input {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}">
                                                <label class="custom-control-label"
                                                       for="contragent_nds_0">@lang('site::messages.no')</label>
                                            </div>
                                            <span class="invalid-feedback">{{ $errors->first('contragent.nds') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="contragent_nds_act">@lang('site::contragent.nds_act')</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                       id="contragent_nds_act_1"
                                                       name="contragent[nds_act]"
                                                       required
                                                       @if(old('contragent.nds_act') == 1) checked @endif
                                                       value="1"
                                                       class="custom-control-input {{$errors->has('contragent.nds_act') ? ' is-invalid' : ''}}">
                                                <label class="custom-control-label"
                                                       for="contragent_nds_act_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                       id="contragent_nds_act_0"
                                                       name="contragent[nds_act]"
                                                       required
                                                       @if(old('contragent.nds_act') == 0) checked @endif
                                                       value="0"
                                                       class="custom-control-input {{$errors->has('contragent.nds_act') ? ' is-invalid' : ''}}">
                                                <label class="custom-control-label"
                                                       for="contragent_nds_act_0">@lang('site::messages.no')</label>
                                            </div>
                                            <span class="invalid-feedback">{{ $errors->first('contragent.nds_act') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4 mt-2" id="company_info">@lang('site::contragent.header.legal')</h4>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_inn">@lang('site::contragent.inn')</label>
                                    <input type="number"
                                           name="contragent[inn]"
                                           id="contragent_inn"
                                           maxlength="12"
                                           required
                                           pattern="\d{10}|\d{12}"
                                           class="form-control{{ $errors->has('contragent.inn') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.inn')"
                                           value="{{ old('contragent.inn') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.inn') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_ogrn">@lang('site::contragent.ogrn')</label>
                                    <input type="number"
                                           name="contragent[ogrn]"
                                           id="contragent_ogrn"
                                           maxlength="15"
                                           required
                                           pattern="\d{13}|\d{15}"
                                           class="form-control{{ $errors->has('contragent.ogrn') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.ogrn')"
                                           value="{{ old('contragent.ogrn') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.ogrn') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_okpo">@lang('site::contragent.okpo')</label>
                                    <input type="number"
                                           name="contragent[okpo]"
                                           id="contragent_okpo"
                                           maxlength="10"
                                           required
                                           pattern="\d{8}|\d{10}"
                                           class="form-control{{ $errors->has('contragent.okpo') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.okpo')"
                                           value="{{ old('contragent.okpo') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.okpo') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_kpp">@lang('site::contragent.kpp')</label>
                                    <input type="number"
                                           name="contragent[kpp]"
                                           id="contragent_kpp"
                                           maxlength="9" pattern=".{0}|\d{9}"
                                           class="form-control{{ $errors->has('contragent.kpp') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.kpp')"
                                           value="{{ old('contragent.kpp') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.kpp') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4 mt-2" id="company_info">@lang('site::contragent.header.payment')</h4>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_rs">@lang('site::contragent.rs')</label>
                                    <input type="number"
                                           name="contragent[rs]"
                                           required
                                           id="contragent_rs" maxlength="20"
                                           pattern="\d{20}"
                                           class="form-control{{ $errors->has('contragent.rs') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.rs')"
                                           value="{{ old('contragent.rs') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.rs') }}</strong>
                                    </span>
                                </div>
                            </div>


                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_bik">@lang('site::contragent.bik')</label>
                                    <input type="number"
                                           name="contragent[bik]"
                                           id="contragent_bik"
                                           required
                                           maxlength="11" pattern="\d{9}|\d{11}"
                                           class="form-control{{ $errors->has('contragent.bik') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.bik')"
                                           value="{{ old('contragent.bik') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.bik') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_bank">@lang('site::contragent.bank')</label>
                                    <input type="text"
                                           name="contragent[bank]"
                                           id="contragent_bank"
                                           required
                                           maxlength="255"
                                           class="form-control{{ $errors->has('contragent.bank') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.bank')"
                                           value="{{ old('contragent.bank') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.bank') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_ks">@lang('site::contragent.ks')</label>
                                    <input type="number"
                                           name="contragent[ks]"
                                           id="contragent_ks"
                                           maxlength="20"
                                           pattern="\d{20}"

                                           class="form-control{{ $errors->has('contragent.ks') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.ks')"
                                           value="{{ old('contragent.ks') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.ks') }}</strong>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            {{-- ЮРИДИЧЕСКИЙ АДРЕС --}}

                            <h4 class="mb-2 mt-4">@lang('site::address.header.legal')</h4>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <input type="hidden"
                                           name="address[legal][type_id]"
                                           value="1">
                                    <label class="control-label"
                                           for="address_legal_country_id">@lang('site::address.country_id')</label>
                                    <select class="country-select form-control
                                    {{$errors->has('address.legal.country_id') ? ' is-invalid' : ''}}"
                                            data-regions="#address_legal_region_id"
                                            data-empty="@lang('site::messages.select_from_list')"
                                            required
                                            name="address[legal][country_id]"
                                            id="address_legal_country_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('address.legal.country_id') == $country->id) selected
                                                    @endif
                                                    value="{{ $country->id }}">{{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.legal.country_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">

                                    <label class="control-label"
                                           for="address_legal_region_id">@lang('site::address.region_id')</label>
                                    <select class="form-control{{  $errors->has('address.legal.region_id') ? ' is-invalid' : '' }}"
                                            name="address[legal][region_id]"
                                            required
                                            id="address_legal_region_id">
                                        <option value="">@lang('site::address.help.select_country')</option>
                                        @foreach($address_legal_regions as $region)
                                            <option
                                                    @if(old('address.legal.region_id') == $region->id) selected
                                                    @endif
                                                    value="{{ $region->id }}">{{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.legal.region_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_legal_locality">@lang('site::address.locality')</label>
                                    <input type="text"
                                           name="address[legal][locality]"
                                           id="address_legal_locality"
                                           required
                                           class="form-control{{ $errors->has('address.legal.locality') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.locality')"
                                           value="{{ old('address.legal.locality') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.legal.locality') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_legal_street">@lang('site::address.street')</label>
                                    <input type="text"
                                           name="address[legal][street]"
                                           id="address_legal_street"
                                           class="form-control{{ $errors->has('address.legal.street') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.street')"
                                           value="{{ old('address.legal.street') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.legal.street') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row required">
                                <div class="col-md-6">
                                    <div class="form-row ">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="address_legal_building">@lang('site::address.building')</label>
                                            <input type="text"
                                                   name="address[legal][building]"
                                                   id="address_legal_building"
                                                   required
                                                   class="form-control{{ $errors->has('address.legal.building') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::address.placeholder.building')"
                                                   value="{{ old('address.legal.building') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.legal.building') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="address_legal_apartment">@lang('site::address.apartment')</label>
                                            <input type="text"
                                                   name="address[legal][apartment]"
                                                   id="address_legal_apartment"
                                                   class="form-control{{ $errors->has('address.legal.apartment') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::address.placeholder.apartment')"
                                                   value="{{ old('address.legal.apartment') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.legal.apartment') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">

                            {{-- ПОЧТОВЫЙ АДРЕС --}}

                            <h4 class="mb-2 mt-4">@lang('site::address.header.postal')</h4>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <input type="hidden"
                                           name="address[postal][type_id]"
                                           value="3">
                                    <label class="control-label"
                                           for="address_postal_country_id">@lang('site::address.country_id')</label>
                                    <select class="country-select form-control{{  $errors->has('address.postal.country_id') ? ' is-invalid' : '' }}"
                                            name="address[postal][country_id]"
                                            required
                                            data-regions="#address_postal_region_id"
                                            data-empty="@lang('site::messages.select_from_list')"
                                            id="address_postal_country_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('address.postal.country_id') == $country->id) selected
                                                    @endif
                                                    value="{{ $country->id }}">{{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.postal.country_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3 required">

                                    <label class="control-label"
                                           for="address_postal_region_id">@lang('site::address.region_id')</label>
                                    <select class="form-control{{  $errors->has('address.postal.region_id') ? ' is-invalid' : '' }}"
                                            name="address[postal][region_id]"
                                            required
                                            id="address_postal_region_id">
                                        <option value="">@lang('site::address.help.select_country')</option>
                                        @foreach($address_postal_regions as $region)
                                            <option
                                                    @if(old('address.postal.region_id') == $region->id) selected
                                                    @endif
                                                    value="{{ $region->id }}">{{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.postal.region_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_postal_locality">@lang('site::address.locality')</label>
                                    <input type="text"
                                           name="address[postal][locality]"
                                           id="address_postal_locality"
                                           required
                                           class="form-control{{ $errors->has('address.postal.locality') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.locality')"
                                           value="{{ old('address.postal.locality') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.postal.locality') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_postal_street">@lang('site::address.street')</label>
                                    <input type="text"
                                           name="address[postal][street]"
                                           id="address_postal_street"
                                           class="form-control{{ $errors->has('address.postal.street') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.street')"
                                           value="{{ old('address.postal.street') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.postal.street') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="address_postal_building">@lang('site::address.building')</label>
                                            <input type="text"
                                                   name="address[postal][building]"
                                                   required
                                                   id="address_postal_building"
                                                   class="form-control{{ $errors->has('address.postal.building') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::address.placeholder.building')"
                                                   value="{{ old('address.postal.building') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.postal.building') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="address_postal_apartment">@lang('site::address.apartment')</label>
                                            <input type="text"
                                                   name="address[postal][apartment]"
                                                   id="address_postal_apartment"
                                                   class="form-control{{ $errors->has('address.postal.apartment') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::address.placeholder.apartment')"
                                                   value="{{ old('address.postal.apartment') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.postal.apartment') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
        <div class=" border p-3 mb-2">
            <button name="_create" form="contragent-form" value="0" type="submit"
                    class="btn btn-ferroli mb-1">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('contragents.index') }}" class="btn btn-secondary mb-1">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>

        </div>
    </div>
@endsection