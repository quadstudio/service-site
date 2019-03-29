<div class="form-row required">
    <div class="col">
        <label class="control-label" for="name">@lang('site::launch.name')</label>
        <input @if(request()->route()->getName() == 'launches.create')
               required
               @else
               disabled
               @endif
               type="text"
               name="launch[name]"
               id="name"
               class="form-control{{ $errors->has('launch.name') ? ' is-invalid' : '' }}"
               placeholder="@lang('site::launch.placeholder.name')"
               value="{{ old('launch.name', optional($launch)->name) }}">
        <span class="invalid-feedback">{{ $errors->first('launch.name') }}</span>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-row required">
            <div class="col">
                <label class="control-label" for="country_id">@lang('site::launch.country_id')</label>
                <select required
                        name="launch[country_id]"
                        id="country_id"
                        class="form-control{{  $errors->has('launch.country_id') ? ' is-invalid' : '' }}">
                    @if($countries->count() == 0 || $countries->count() > 1)
                        <option value="">@lang('site::messages.select_from_list')</option>
                    @endif
                    @foreach($countries as $country)
                        <option @if(old('launch.country_id', optional($launch)->country_id) == $country->id)
                                selected
                                @endif
                                value="{{ $country->id }}">
                            {{ $country->name }}
                            {{ $country->phone }}
                        </option>
                    @endforeach
                </select>
                <span class="invalid-feedback">{{ $errors->first('launch.country_id') }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row required">
            <div class="col">
                <label class="control-label" for="contact">@lang('site::launch.phone')</label>
                <input required
                       type="tel"
                       name="launch[phone]"
                       id="phone"
                       oninput="mask_phones()"
                       pattern="{{config('site.phone.pattern')}}"
                       maxlength="{{config('site.phone.maxlength')}}"
                       title="{{config('site.phone.format')}}"
                       data-mask="{{config('site.phone.mask')}}"
                       class="phone-mask form-control{{ $errors->has('launch.phone') ? ' is-invalid' : '' }}"
                       placeholder="@lang('site::launch.placeholder.phone')"
                       value="{{ old('launch.phone', optional($launch)->phone) }}">
                <span class="invalid-feedback">{{ $errors->first('launch.phone') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <label class="control-label" for="address">@lang('site::launch.address')</label>
        <input @if(request()->route()->getName() == 'launches.edit')
               disabled
               @endif
               type="text"
               name="launch[address]"
               id="address"
               class="form-control{{ $errors->has('launch.address') ? ' is-invalid' : '' }}"
               placeholder="@lang('site::launch.placeholder.address')"
               value="{{ old('launch.address', optional($launch)->address) }}">
        <span class="invalid-feedback">{{ $errors->first('launch.address') }}</span>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-row ">
            <div class="col">
                <label class="control-label" for="document_name">@lang('site::launch.document_name')</label>
                <input type="text"
                       name="launch[document_name]"
                       id="document_name"
                       class="form-control{{ $errors->has('launch.document_name') ? ' is-invalid' : '' }}"
                       placeholder="@lang('site::launch.placeholder.document_name')"
                       value="{{ old('launch.document_name', optional($launch)->document_name) }}">
                <span class="invalid-feedback">{{ $errors->first('launch.document_name') }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row ">
            <div class="col">
                <label class="control-label" for="document_number">@lang('site::launch.document_number')</label>
                <input type="text"
                       name="launch[document_number]"
                       id="document_number"
                       class="form-control{{ $errors->has('launch.document_number') ? ' is-invalid' : '' }}"
                       placeholder="@lang('site::launch.placeholder.document_number')"
                       value="{{ old('launch.document_number', optional($launch)->document_number) }}">
                <span class="invalid-feedback">{{ $errors->first('launch.document_number') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-row">
            <div class="col">
                <label class="control-label" for="document_who">@lang('site::launch.document_who')</label>
                <input type="text"
                       name="launch[document_who]"
                       id="document_who"
                       class="form-control{{ $errors->has('launch.document_who') ? ' is-invalid' : '' }}"
                       placeholder="@lang('site::launch.placeholder.document_who')"
                       value="{{ old('launch.document_who', optional($launch)->document_who) }}">
                <span class="invalid-feedback">{{ $errors->first('launch.document_who') }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row ">
            <label class="control-label"
                   for="document_date">@lang('site::launch.document_date')</label>
            <div class="input-group datetimepicker" id="datetimepicker_document_date"
                 data-target-input="nearest">
                <input type="text"
                       name="launch[document_date]"
                       id="document_date"
                       maxlength="10"
                       placeholder="@lang('site::launch.placeholder.document_date')"
                       data-target="#datetimepicker_document_date"
                       data-toggle="datetimepicker"
                       class="form-control{{ $errors->has('launch.document_date') ? ' is-invalid' : '' }}"
                       value="{{ old('launch.document_date') }}">
                <div class="input-group-append"
                     data-target="#datetimepicker_document_date"
                     data-toggle="datetimepicker">
                    <div class="input-group-text">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
            <span class="invalid-feedback">{{ $errors->first('launch.document_date') }}</span>
        </div>
    </div>
</div>