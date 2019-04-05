<form id="form-content" method="POST" action="{{ route('addresses.store') }}">

    @csrf

    <div class="form-row required">
        <div class="col mb-3">
            <label class="control-label" for="name">@lang('site::address.name')</label>
            <input type="text"
                   name="address[name]"
                   id="name"
                   required
                   class="form-control{{ $errors->has('address.name') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::address.placeholder.name')"
                   value="{{ old('address.name') }}">
            <span class="invalid-feedback">{{ $errors->first('address.name') }}</span>
        </div>
    </div>

    <div class="form-group required">
        <label class="control-label"
               for="address_type_id">@lang('site::address.type_id')</label>
        <select required
                class="form-control{{  $errors->has('address.type_id') ? ' is-invalid' : '' }}"
                name="address[type_id]"
                id="address_type_id">
                <option value="{{ $address_type->id }}">{{ $address_type->name }}</option>
        </select>
        <span class="invalid-feedback">{{ $errors->first('address.type_id') }}</span>
    </div>

    <div class="form-row required">
        <div class="col mb-3">

            <label class="control-label" for="country_id">@lang('site::address.country_id')</label>
            <select class="form-control{{  $errors->has('address.country_id') ? ' is-invalid' : '' }}"
                    name="address[country_id]"
                    required
                    id="country_id">
                @if($countries->count() == 0 || $countries->count() > 1)
                    <option value="">@lang('site::messages.select_from_list')</option>
                @endif
                @foreach($countries as $country)
                    <option @if(old('address.country_id') == $country->id)
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
        <div class="col mb-3 required">

            <label class="control-label" for="region_id">@lang('site::address.region_id')</label>
            <select class="form-control{{  $errors->has('address.region_id') ? ' is-invalid' : '' }}"
                    name="address[region_id]"
                    required
                    id="region_id">
                @if($regions->count() == 0 || $regions->count() > 1)
                    <option value="">@lang('site::messages.select_from_list')</option>
                @endif
                @foreach($regions as $region)
                    <option @if(old('address.region_id') == $region->id)
                            selected
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
            <label class="control-label" for="locality">@lang('site::address.locality')</label>
            <input type="text"
                   name="address[locality]"
                   id="locality"
                   required
                   class="form-control{{ $errors->has('address.locality') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::address.placeholder.locality')"
                   value="{{ old('address.locality') }}">
            <span class="invalid-feedback">{{ $errors->first('address.locality') }}</span>
        </div>
    </div>
    <div class="form-row">
        <div class="col mb-3">
            <label class="control-label" for="street">@lang('site::address.street')</label>
            <input type="text"
                   name="address[street]"
                   id="street"
                   class="form-control{{ $errors->has('address.street') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::address.placeholder.street')"
                   value="{{ old('address.street') }}">
            <span class="invalid-feedback">{{ $errors->first('address.street') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-row">
                <div class="col mb-3">
                    <label class="control-label" for="building">@lang('site::address.building')</label>
                    <input type="text"
                           name="address[building]"
                           id="building"
                           class="form-control{{ $errors->has('address.building') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::address.placeholder.building')"
                           value="{{ old('address.building') }}">
                    <span class="invalid-feedback">{{ $errors->first('address.building') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-row">
                <div class="col mb-3">
                    <label class="control-label"
                           for="apartment">@lang('site::address.apartment')</label>
                    <input type="text"
                           name="address[apartment]"
                           id="apartment"
                           class="form-control{{ $errors->has('address.apartment') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::address.placeholder.apartment')"
                           value="{{ old('address.apartment') }}">
                    <span class="invalid-feedback">{{ $errors->first('address.apartment') }}</span>
                </div>
            </div>
        </div>
    </div>

    <hr/>

    <div class="form-row @if($address_type->id == 6) required @endif">
        <div class="col mb-3">
            <label class="control-label" for="address_email">@lang('site::address.email')</label>
            <input type="email"
                   @if($address_type->id == 6) required @endif
                   name="address[email]"
                   id="address_email"
                   class="form-control{{ $errors->has('address.email') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::address.placeholder.email')"
                   value="{{ old('address.email') }}">
            <span class="invalid-feedback">{{ $errors->first('address.email') }}</span>
        </div>
    </div>
    <div class="form-row @if($address_type->id == 5) required @endif">
        <div class="col mb-3">
            <label class="control-label" for="address_web">@lang('site::address.web')</label>
            <input type="text"
                   @if($address_type->id == 5) required @endif
                   name="address[web]"
                   id="address_web"
                   class="form-control{{ $errors->has('address.web') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::address.placeholder.web')"
                   value="{{ old('address.web') }}">
            <span class="invalid-feedback">{{ $errors->first('address.web') }}</span>
        </div>
    </div>
    <hr/>
    <h4 class="mb-2 mt-2">@lang('site::register.sc_phone')</h4>
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
    <div class="row">
        <div class="col-md-6">
            <div class="form-row required">
                <div class="col">
                    <label class="control-label"
                           for="phone_number">@lang('site::phone.number')</label>
                    <input type="tel"
                           required
                           name="phone[number]"
                           id="phone_number"
                           title="@lang('site::phone.placeholder.number')"
                           pattern="^\d{10}$"
                           maxlength="10"
                           class="form-control{{ $errors->has('phone.number') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::phone.placeholder.number')"
                           value="{{ old('phone.number') }}">
                    <span class="invalid-feedback">{{ $errors->first('phone.number') }}</span>
                    <small id="phone_numberHelp" class="mb-4 form-text text-success">
                        @lang('site::phone.help.number')
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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