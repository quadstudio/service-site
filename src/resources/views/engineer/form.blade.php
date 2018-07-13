<form id="form-content" method="POST" action="{{ route('engineers.store') }}">
    @csrf
    <div class="form-row required">
        <div class="col mb-3">
            <label class="control-label" for="name">@lang('site::engineer.name')</label>
            <input type="text" name="name"
                   id="name"
                   required
                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::engineer.placeholder.name')"
                   value="{{ old('name') }}">
            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="form-row required">
        <div class="col mb-3 required">
            <label class="control-label" for="country_id">@lang('site::engineer.country_id')</label>
            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                    required
                    name="country_id" id="country_id">
                <option value="">@lang('site::messages.select_from_list')</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
        </div>
    </div>
    <div class="form-row required">
        <div class="col">
            <label class="control-label" for="contact">@lang('site::engineer.phone')</label>
            <input type="tel" name="phone" id="phone"
                   title="@lang('site::engineer.placeholder.phone')"
                   pattern="^\d{10}$" maxlength="10"
                   required
                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::engineer.placeholder.phone')"
                   value="{{ old('phone') }}">
            <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
            <small id="phoneHelp" class="mb-4 form-text text-success">
                @lang('site::engineer.help.phone')
            </small>
        </div>
    </div>
    <div class="form-row required">
        <div class="col mb-3">
            <label for="address">@lang('site::engineer.address')</label>
            <input type="text"
                   name="address"
                   id="address"
                   required
                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::engineer.placeholder.address')"
                   value="{{ old('address') }}">
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
        </div>
    </div>
</form>