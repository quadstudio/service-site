<div class="form-row required">
    <div class="col mb-3">
        <label class="control-label" for="name">@lang('site::engineer.name')</label>
        <input @if(request()->route()->getName() == 'engineers.create')
               required
               @else
               disabled
               @endif
               type="text"
               name="engineer[name]"
               id="name"
               class="form-control{{ $errors->has('engineer.name') ? ' is-invalid' : '' }}"
               placeholder="@lang('site::engineer.placeholder.name')"
               value="{{ old('engineer.name', optional($engineer)->name) }}">
        <span class="invalid-feedback">{{ $errors->first('engineer.name') }}</span>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-row required">
            <div class="col mb-3 required">
                <label class="control-label" for="country_id">@lang('site::engineer.country_id')</label>
                <select required
                        name="engineer[country_id]"
                        id="country_id"
                        class="form-control{{  $errors->has('engineer.country_id') ? ' is-invalid' : '' }}">
                    @if($countries->count() == 0 || $countries->count() > 1)
                        <option value="">@lang('site::messages.select_from_list')</option>
                    @endif
                    @foreach($countries as $country)
                        <option @if(old('engineer.country_id', optional($engineer)->country_id) == $country->id)
                                selected
                                @endif
                                value="{{ $country->id }}">
                            {{ $country->name }}
                            {{ $country->phone }}
                        </option>
                    @endforeach
                </select>
                <span class="invalid-feedback">{{ $errors->first('engineer.country_id') }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row required">
            <div class="col">
                <label class="control-label" for="contact">@lang('site::engineer.phone')</label>
                <input required
                       type="tel"
                       name="engineer[phone]"
                       id="phone"
                       oninput="mask_phones()"
                       pattern="{{config('site.phone.pattern')}}"
                       maxlength="{{config('site.phone.maxlength')}}"
                       title="{{config('site.phone.format')}}"
                       data-mask="{{config('site.phone.mask')}}"
                       class="phone-mask form-control{{ $errors->has('engineer.phone') ? ' is-invalid' : '' }}"
                       placeholder="@lang('site::engineer.placeholder.phone')"
                       value="{{ old('engineer.phone', optional($engineer)->phone) }}">
                <span class="invalid-feedback">{{ $errors->first('engineer.phone') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col mb-3">
        <label class="control-label" for="address">@lang('site::engineer.address')</label>
        <input @if(request()->route()->getName() == 'engineers.edit')
               disabled
               @endif
               type="text"
               name="engineer[address]"
               id="address"
               class="form-control{{ $errors->has('engineer.address') ? ' is-invalid' : '' }}"
               placeholder="@lang('site::engineer.placeholder.address')"
               value="{{ old('engineer.address', optional($engineer)->address) }}">
        <span class="invalid-feedback">{{ $errors->first('engineer.address') }}</span>
    </div>
</div>