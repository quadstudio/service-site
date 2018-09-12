@extends('layouts.app')

@section('header')
    @include('site::header.front',[
        'h1' => __('site::register.title'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::register.title')]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col">
                {{dump($errors ?: null)}}

                <form id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::user.name')</label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           required
                                           class="form-control form-control-lg
                                    {{ $errors->has('name')
                                    ? ' is-invalid'
                                    : (old('name') ? ' is-valid' : '') }}"
                                           placeholder="@lang('site::user.placeholder.name')"
                                           value="{{ old('name') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    <small id="nameHelp" class="form-text text-success">
                                        @lang('site::user.help.name')
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="type_id">@lang('site::user.type_id')</label>
                                    @foreach($types as $key => $type)
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input
                                            {{$errors->has('type_id') ? ' is-invalid' : ''}}"
                                                   type="radio"
                                                   required
                                                   name="type_id"
                                                   @if(old('type_id') == $type->id) checked @endif
                                                   id="type_id_{{ $type->id }}"
                                                   value="{{ $type->id }}">
                                            <label class="custom-control-label"
                                                   for="type_id_{{ $type->id }}">{{ $type->name }}</label>
                                            @if($key == $types->count()-1)
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('user.type_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- КОНТАКТНОЕ ЛИЦО --}}

                    <h4 class=" mt-4 mb-2" id="sc_info">@lang('site::contact.header')</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <input type="hidden" name="contact[type_id]" value="1">
                                    <label class="control-label" for="contact_name">@lang('site::contact.name')</label>
                                    <input type="text" name="contact[name]" id="contact_name"
                                           class="form-control
                                           required
                                           {{$errors->has('contact.name')
                                           ? ' is-invalid'
                                           : (old('contact.name') ? ' is-valid' : '')}}"
                                           placeholder="@lang('site::contact.placeholder.name')"
                                           value="{{ old('contact.name') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contact.name') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contact_position">@lang('site::contact.position')</label>
                                    <input type="text" name="contact[position]" id="contact_position"
                                           class="form-control{{ $errors->has('contact.position') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contact.placeholder.position')"
                                           value="{{ old('contact.position') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contact.position') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-row required">
                                <div class="col mb-3">

                                    <label class="control-label"
                                           for="phone_contact_country_id">@lang('site::phone.country_id')</label>
                                    <select class="form-control{{  $errors->has('phone.contact.country_id') ? ' is-invalid' : '' }}"
                                            required
                                            name="phone[contact][country_id]"
                                            id="phone_contact_country_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('phone.contact.country_id') == $country->id) selected
                                                    @endif
                                                    value="{{ $country->id }}">{{ $country->name }}
                                                ({{ $country->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone.contact.country_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="phone_contact_number">@lang('site::phone.number')</label>
                                    <input type="text"
                                           name="phone[contact][number]"
                                           id="phone_contact_number"
                                           title="@lang('site::phone.placeholder.number')"
                                           required
                                           pattern="^\d{10}$"
                                           maxlength="10"
                                           class="form-control{{ $errors->has('phone.contact.number') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::phone.placeholder.number')"
                                           value="{{ old('phone.contact.number') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone.contact.number') }}</strong>
                                    </span>
                                    <small id="contact_phone_numberHelp" class="mb-4 form-text text-success">
                                        @lang('site::phone.help.number')
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="phone_contact_extra">@lang('site::phone.extra')</label>
                                    <input type="text"
                                           name="phone[contact][extra]"
                                           id="phone_contact_extra"
                                           class="form-control{{ $errors->has('phone.contact.extra') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::phone.placeholder.extra')"
                                           value="{{ old('phone.contact.extra') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone.contact.extra') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset id="sc-content">
                                {{-- ИНФОРМАЦИЯ ДЛЯ ПОЛЬЗОВТЕЛЕЙ --}}

                                <h4 class="mt-4">@lang('site::register.header.sc')</h4>
                                {{--<h4 class="mb-2 text-success small">@lang('site::register.help.sc')</h4>--}}

                                <div class="custom-control custom-checkbox mb-1">
                                    <input value="1" name="dealer" type="checkbox" class="custom-control-input" id="dealer">
                                    <label class="custom-control-label text-big"
                                           for="dealer">@lang('site::user.help.dealer')</label>
                                </div>

                                <div class="form-row required">
                                    <div class="col mb-3">

                                        <label class="control-label"
                                               for="address_sc_name">@lang('site::address.name')</label>
                                        <input type="text"
                                               name="address[sc][name]"
                                               id="address_sc_name"
                                               required
                                               class="form-control{{ $errors->has('address.sc.name') ? ' is-invalid' : '' }}"
                                               placeholder="@lang('site::address.placeholder.name')"
                                               value="{{ old('address.sc.name') }}">
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.sc.name') }}</strong>
                                    </span>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col mb-3">
                                        <label class="control-label" for="web">@lang('site::user.web')</label>
                                        <input type="text"
                                               name="web"
                                               id="web"
                                               class="form-control{{ $errors->has('web') ? ' is-invalid' : '' }}"
                                               pattern="https?://.+" title="@lang('site::user.help.web')"
                                               placeholder="@lang('site::user.placeholder.web')"
                                               value="{{ old('web') }}">
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('web') }}</strong>
                                    </span>
                                        <small id="webHelp" class="form-text text-success">
                                            @lang('site::user.help.web')
                                        </small>
                                    </div>
                                </div>

                                {{-- ТЕЛЕФОН АСЦ --}}

                                <h4 class="mb-2 mt-2">@lang('site::register.sc_phone')</h4>
                                <div class="form-row required">
                                    <div class="col mb-3">

                                        <label class="control-label"
                                               for="phone_sc_country_id">@lang('site::phone.country_id')</label>
                                        <select class="form-control{{  $errors->has('phone.sc.country_id') ? ' is-invalid' : '' }}"
                                                name="phone[sc][country_id]"
                                                required
                                                id="phone_sc_country_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($countries as $country)
                                                <option
                                                        @if(old('phone.sc.country_id') == $country->id) selected
                                                        @endif
                                                        value="{{ $country->id }}">{{ $country->name }}
                                                    ({{ $country->phone }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone.sc.country_id') }}</strong>
                                    </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-row required">
                                            <div class="col">
                                                <label class="control-label"
                                                       for="phone_sc_number">@lang('site::phone.number')</label>
                                                <input type="tel"
                                                       required
                                                       name="phone[sc][number]"
                                                       id="phone_sc_number"
                                                       title="@lang('site::phone.placeholder.number')"
                                                       pattern="^\d{10}$"
                                                       maxlength="10"
                                                       class="form-control{{ $errors->has('phone.sc.number') ? ' is-invalid' : '' }}"
                                                       placeholder="@lang('site::phone.placeholder.number')"
                                                       value="{{ old('phone.sc.number') }}">
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('phone.sc.number') }}</strong>
                                            </span>
                                                <small id="sc_phone_numberHelp"
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
                                                       for="phone_sc_extra">@lang('site::phone.extra')</label>
                                                <input type="text"
                                                       name="phone[sc][extra]"
                                                       id="phone_sc_extra"
                                                       class="form-control{{ $errors->has('phone.sc.extra') ? ' is-invalid' : '' }}"
                                                       placeholder="@lang('site::phone.placeholder.extra')"
                                                       value="{{ old('phone.sc.extra') }}">
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('phone.sc.extra') }}</strong>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">

                            {{-- АДРЕС АСЦ --}}

                            <h4 class="mb-2 mt-4">@lang('site::register.sc_address')</h4>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <input type="hidden" name="address[sc][type_id]" value="2">
                                    <label class="control-label"
                                           for="address_sc_country_id">@lang('site::address.country_id')</label>
                                    <select class="country-select form-control{{  $errors->has('address.sc.country_id') ? ' is-invalid' : '' }}"
                                            name="address[sc][country_id]"
                                            required
                                            data-regions="#address_sc_region_id"
                                            data-empty="@lang('site::messages.select_from_list')"
                                            id="address_sc_country_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('address.sc.country_id') == $country->id) selected
                                                    @endif
                                                    value="{{ $country->id }}">{{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.sc.country_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">

                                    <label class="control-label"
                                           for="address_sc_region_id">@lang('site::address.region_id')</label>
                                    <select class="form-control{{  $errors->has('address.sc.region_id') ? ' is-invalid' : '' }}"
                                            name="address[sc][region_id]"
                                            required
                                            id="address_sc_region_id">
                                        <option value="">@lang('site::address.help.select_country')</option>
                                        @foreach($address_sc_regions as $region)
                                            <option
                                                    @if(old('address.sc.region_id') == $region->id) selected
                                                    @endif
                                                    value="{{ $region->id }}">{{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.sc.region_id') }}</strong>
                                    </span>
                                </div>
                            </div>


                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_sc_locality">@lang('site::address.locality')</label>
                                    <input type="text"
                                           name="address[sc][locality]"
                                           id="address_sc_locality"
                                           required
                                           class="form-control{{ $errors->has('address.sc.locality') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.locality')"
                                           value="{{ old('address.sc.locality') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.sc.locality') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="address_sc_street">@lang('site::address.street')</label>
                                    <input type="text"
                                           name="address[sc][street]"
                                           id="address_sc_street"
                                           class="form-control{{ $errors->has('address.sc.street') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.street')"
                                           value="{{ old('address.sc.street') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address.sc.street') }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="address_sc_building">@lang('site::address.building')</label>
                                            <input type="text"
                                                   name="address[sc][building]"
                                                   required
                                                   id="address_sc_building"
                                                   class="form-control{{ $errors->has('address.sc.building') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::address.placeholder.building')"
                                                   value="{{ old('address.sc.building') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.sc.building') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="address_sc_apartment">@lang('site::address.apartment')</label>
                                            <input type="text"
                                                   name="address[sc][apartment]"
                                                   id="address_sc_apartment"
                                                   class="form-control{{ $errors->has('address.sc.apartment') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::address.placeholder.apartment')"
                                                   value="{{ old('address.sc.apartment') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.sc.apartment') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- КОНТРАГЕНТ --}}

                    <h4 class=" mt-3" id="sc_info">@lang('site::contragent.header.contragent')</h4>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="contragent_name">@lang('site::contragent.help.name')</label>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_type_id">@lang('site::contragent.type_id')</label>
                                    @foreach($types as $key => $type)
                                        <div class="form-check">
                                            <input class="form-check-input
                                            {{$errors->has('contragent.type_id') ? ' is-invalid' : ''}}"
                                                   type="radio"
                                                   required
                                                   name="contragent[type_id]"
                                                   @if(old('contragent.type_id') == $type->id) checked @endif
                                                   id="contragent_type_id_{{ $type->id }}"
                                                   value="{{ $type->id }}">
                                            <label class="form-check-label"
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
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_nds">@lang('site::contragent.nds')</label>

                                    <div class="form-check">
                                        <input class="form-check-input
                                            {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="contragent[nds]"
                                               required
                                               @if(old('contragent.nds') == 1) checked @endif
                                               id="contragent_nds_1"
                                               value="1">
                                        <label class="form-check-label"
                                               for="contragent_nds_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input
                                            {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="contragent[nds]"

                                               @if(old('contragent.nds') == 0) checked @endif
                                               id="contragent_nds_0"
                                               value="0">
                                        <label class="form-check-label"
                                               for="contragent_nds_0">@lang('site::messages.no')</label>
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('contragent.nds') }}</strong>
                                        </span>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
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


                    <h4 class="mb-4 mt-2" id="company_info">@lang('site::user.header.info')</h4>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="email">@lang('site::user.email')</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   required
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::user.placeholder.email')"
                                   value="{{ old('email') }}">
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            <small id="emailHelp" class="form-text text-success">
                                @lang('site::user.help.email')
                            </small>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="password">@lang('site::user.password')</label>
                            <input type="password"
                                   name="password"
                                   required
                                   id="password"
                                   minlength="6"
                                   maxlength="20"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::user.placeholder.password')"
                                   value="{{ old('password') }}">
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>

                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="password-confirmation">@lang('site::user.password_confirmation')</label>
                            <input id="password-confirmation"
                                   type="password"
                                   required
                                   class="form-control"
                                   placeholder="@lang('site::user.placeholder.password_confirmation')"
                                   name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-row">
                        <button class="btn btn-ferroli" type="submit">@lang('site::user.sign_up')</button>
                    </div>
                </form>
                <div class="text-center">
                    <a class="d-block" href="{{route('login')}}">@lang('site::user.already')</a>
                </div>

            </div>
        </div>
    </div>
@endsection