<div class="card mt-3 participant-item">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-row required">
                    <div class="col mb-3">
                        <label class="control-label" for="name_{{$random}}">@lang('site::participant.name')</label>
                        <input type="text"
                               name="participant[{{$random}}][name]"
                               id="name_{{$random}}"
                               required
                               maxlength="100"
                               class="form-control{{ $errors->has('participant.'.$random.'.name') ? ' is-invalid' : '' }}"
                               placeholder="@lang('site::participant.placeholder.name')"
                               value="{{ old('participant.'.$random.'.name') }}">
                        <span class="invalid-feedback">{{ $errors->first('participant.'.$random.'.name') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-row required">
                    <div class="col mb-3">
                        <label class="control-label"
                               for="headposition_{{$random}}">@lang('site::participant.headposition')</label>
                        <input type="text"
                               name="participant[{{$random}}][headposition]"
                               id="headposition_{{$random}}"
                               required
                               maxlength="100"
                               class="form-control{{ $errors->has('participant.'.$random.'.headposition') ? ' is-invalid' : '' }}"
                               placeholder="@lang('site::participant.placeholder.headposition')"
                               value="{{ old('participant.'.$random.'.headposition') }}">
                        <span class="invalid-feedback">{{ $errors->first('participant.'.$random.'.headposition') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-row required">
                    <div class="col mb-3 required">
                        <label class="control-label"
                               for="country_id">@lang('site::participant.country_id')</label>
                        <select required
                                name="participant[{{$random}}][country_id]"
                                id="country_id"
                                class="form-control{{  $errors->has('participant.'.$random.'.country_id') ? ' is-invalid' : '' }}">
                            @if($countries->count() != 1)
                                <option value="">@lang('site::messages.select_from_list')</option>
                            @endif
                            @foreach($countries as $country)
                                <option @if(old('participant.'.$random.'.country_id') == $country->id)
                                        selected
                                        @endif
                                        value="{{ $country->id }}">
                                    {{ $country->name }}
                                    {{ $country->phone }}
                                </option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('participant.'.$random.'.country_id') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-row ">
                    <div class="col">
                        <label class="control-label"
                               for="phone_{{$random}}">@lang('site::participant.phone')</label>
                        <input type="tel"
                               name="participant[{{$random}}][phone]"
                               id="phone"
                               oninput="mask_phones()"
                               pattern="{{config('site.phone.pattern')}}"
                               maxlength="{{config('site.phone.maxlength')}}"
                               title="{{config('site.phone.format')}}"
                               data-mask="{{config('site.phone.mask')}}"
                               class="phone-mask form-control{{ $errors->has('participant.'.$random.'.phone') ? ' is-invalid' : '' }}"
                               placeholder="@lang('site::member.placeholder.phone')"
                               value="{{ old('participant.'.$random.'.phone') }}">
                        <span class="invalid-feedback">{{ $errors->first('participant.'.$random.'.phone') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-row">
                    <div class="col mb-3">
                        <label class="control-label" for="email_{{$random}}">@lang('site::participant.email')</label>
                        <input type="email"
                               name="participant[{{$random}}][email]"
                               id="email_{{$random}}"
                               maxlength="50"
                               class="form-control{{ $errors->has('participant.'.$random.'.email') ? ' is-invalid' : '' }}"
                               placeholder="@lang('site::participant.placeholder.email')"
                               value="{{ old('participant.'.$random.'.email') }}">
                        <span class="invalid-feedback">{{ $errors->first('participant.'.$random.'.email') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-sm btn-danger">@lang('site::messages.delete')</a>
    </div>
</div>