<div class="form-row required">
    <div class="col">
        <label class="control-label" for="name">@lang('site::trade.name')</label>
        <input @if(request()->route()->getName() == 'trades.create')
               required
               @else
               disabled
               @endif
               type="text"
               name="trade[name]"
               id="name"
               class="form-control{{ $errors->has('trade.name') ? ' is-invalid' : '' }}"
               placeholder="@lang('site::trade.placeholder.name')"
               value="{{ old('trade.name', optional($trade)->name) }}">
        <span class="invalid-feedback">{{ $errors->first('trade.name') }}</span>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-row required">
            <div class="col">
                <label class="control-label" for="country_id">@lang('site::trade.country_id')</label>
                <select required
                        name="trade[country_id]"
                        id="country_id"
                        class="form-control{{  $errors->has('trade.country_id') ? ' is-invalid' : '' }}">
                    @if($countries->count() == 0 || $countries->count() > 1)
                        <option value="">@lang('site::messages.select_from_list')</option>
                    @endif
                    @foreach($countries as $country)
                        <option @if(old('trade.country_id', optional($trade)->country_id) == $country->id)
                                selected
                                @endif
                                value="{{ $country->id }}">
                            {{ $country->name }}
                            {{ $country->phone }}
                        </option>
                    @endforeach
                </select>
                <span class="invalid-feedback">{{ $errors->first('trade.country_id') }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row required">
            <div class="col">
                <label class="control-label" for="contact">@lang('site::trade.phone')</label>
                <input required
                       type="tel"
                       name="trade[phone]"
                       id="phone"
                       oninput="mask_phones()"
                       pattern="{{config('site.phone.pattern')}}"
                       maxlength="{{config('site.phone.maxlength')}}"
                       title="{{config('site.phone.format')}}"
                       data-mask="{{config('site.phone.mask')}}"
                       class="phone-mask form-control{{ $errors->has('trade.phone') ? ' is-invalid' : '' }}"
                       placeholder="@lang('site::trade.placeholder.phone')"
                       value="{{ old('trade.phone', optional($trade)->phone) }}">
                <span class="invalid-feedback">{{ $errors->first('trade.phone') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col mb-3">
        <label class="control-label" for="address">@lang('site::trade.address')</label>
        <input @if(request()->route()->getName() == 'trades.edit')
               disabled
               @endif
               type="text"
               name="trade[address]"
               id="address"
               class="form-control{{ $errors->has('trade.address') ? ' is-invalid' : '' }}"
               placeholder="@lang('site::trade.placeholder.address')"
               value="{{ old('trade.address', optional($trade)->address) }}">
        <span class="invalid-feedback">{{ $errors->first('trade.address') }}</span>
    </div>
</div>