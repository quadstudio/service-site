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
            <div class="col-md-3">
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

            <div class="col-md-3">
                <div class="form-row ">
                    <div class="col">
                        <label class="control-label"
                               for="phone_{{$random}}">@lang('site::participant.phone')</label>
                        <input type="tel"
                               name="participant[{{$random}}][phone]"
                               id="phone_{{$random}}"
                               title="@lang('site::participant.placeholder.phone')"
                               maxlength="10"
                               class="form-control{{ $errors->has('participant.'.$random.'.phone') ? ' is-invalid' : '' }}"
                               placeholder="@lang('site::participant.placeholder.phone')"
                               value="{{ old('participant.'.$random.'.phone') }}">
                        <span class="invalid-feedback">{{ $errors->first('participant.'.$random.'.phone') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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
        <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-sm btn-danger">Удалить</a>
    </div>
</div>