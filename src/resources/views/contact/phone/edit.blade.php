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
            <li class="breadcrumb-item">{{$contact->name}}</li>
            <li class="breadcrumb-item">{{$phone->country->phone}} {{$phone->number}}</li>
            <li class="breadcrumb-item active">@lang('site::messages.edit') @lang('site::phone.phone')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::phone.phone')</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="form" method="POST" action="{{ route('contacts.phones.update', [$contact, $phone]) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-row required">
                                <div class="col mb-3">

                                    <label class="control-label"
                                           for="country_id">@lang('site::phone.country_id')</label>
                                    <select class="form-control{{  $errors->has('phone.country_id') ? ' is-invalid' : (old('phone.country_id') ? ' is-valid' : '') }}"
                                            required
                                            name="phone[country_id]"
                                            id="country_id">
                                        @if($countries->count() == 0 || $countries->count() > 1)
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                        @endif
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('phone.country_id', $phone->country->id) == $country->id) selected
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
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="number">@lang('site::phone.number')</label>
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
                                           value="{{ old('phone.number', $phone->number) }}">
                                    <span class="invalid-feedback">{{ $errors->first('phone.number') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="extra">@lang('site::phone.extra')</label>
                                    <input type="text"
                                           name="phone[extra]"
                                           id="extra"
                                           class="form-control{{ $errors->has('phone.extra') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::phone.placeholder.extra')"
                                           value="{{ old('phone.extra', $phone->extra) }}">
                                    <span class="invalid-feedback">{{ $errors->first('phone.extra') }}</span>
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
                    <a href="{{ route('contacts.show', $contact) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection