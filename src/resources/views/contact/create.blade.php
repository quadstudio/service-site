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
            <li class="breadcrumb-item">
                <a href="{{ route('contacts.index') }}">@lang('site::contact.contacts')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.create') @lang('site::contact.contact')</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="contact-form" method="POST"
                      action="{{ route('contacts.store') }}">

                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::contact.name')</label>
                                    <input type="text"
                                           name="contact[name]"
                                           id="name"
                                           required
                                           class="form-control{{ $errors->has('contact.name') ? ' is-invalid' : '' }}"
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
                                    <label class="control-label" for="position">@lang('site::contact.position')</label>
                                    <input type="text"
                                           name="contact[position]"
                                           id="position"
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

                    <div class="form-group required">
                        <label class="control-label"
                               for="type_id">@lang('site::contact.type_id')</label>
                        <select class="form-control{{  $errors->has('contact.type_id') ? ' is-invalid' : '' }}"
                                required
                                name="contact[type_id]"
                                id="type_id">
                            @if($types->count() == 0 || $types->count() > 1)
                                <option value="">@lang('site::messages.select_from_list')</option>
                            @endif
                            @foreach($types as $type)
                                <option @if(old('contact.type_id') == $type->id) selected
                                        @endif
                                        value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('contact.type_id') }}</span>
                    </div>

                    {{-- ТЕЛЕФОН --}}

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col mb-3">

                                    <label class="control-label"
                                           for="phone_country_id">@lang('site::phone.country_id')</label>
                                    <select class="form-control{{  $errors->has('phone.country_id') ? ' is-invalid' : '' }}"
                                            name="phone[country_id]"
                                            required
                                            id="phone_country_id">
                                        @if($countries->count() == 0 || $countries->count() > 1)
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                        @endif
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('phone.country_id') == $country->id) selected
                                                    @endif
                                                    value="{{ $country->id }}">{{ $country->name }}
                                                ({{ $country->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('phone.country_id') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="phone_number">@lang('site::phone.number')</label>
                                    <input required
                                           type="tel"
                                           name="phone[number]"
                                           id="number"
                                           oninput="mask_phones()"
                                           pattern="{{config('site.phone.pattern')}}"
                                           maxlength="{{config('site.phone.maxlength')}}"
                                           title="{{config('site.phone.format')}}"
                                           data-mask="{{config('site.phone.mask')}}"
                                           class="phone-mask form-control{{ $errors->has('phone.number') ? ' is-invalid' : (old('phone.number') ? ' is-valid' : '') }}"
                                           placeholder="@lang('site::phone.placeholder.number')"
                                           value="{{ old('phone.number') }}">
                                    <span class="invalid-feedback">{{ $errors->first('phone.number') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="phone_extra">@lang('site::phone.extra')</label>
                                    <input type="text"
                                           name="phone[extra]"
                                           id="phone_extra"
                                           class="form-control{{ $errors->has('phone.extra') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::phone.placeholder.extra')"
                                           value="{{ old('phone.extra') }}">
                                    <span class="invalid-feedback">{{ $errors->first('phone.extra') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="contact-form" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection