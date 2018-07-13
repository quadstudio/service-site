<form id="form-content" method="POST" action="{{ route('trades.store') }}">
    @csrf
    <div class="form-row">
        <div class="col mb-3">
            <label for="name">@lang('site::trade.name')</label>
            <input type="text" name="name" id="name" required
                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::trade.placeholder.name')"
                   value="{{ old('name') }}">
            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="form-row">
        <div class="col mb-3">
            <label for="country_id">@lang('site::trade.country_id')</label>
            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                    name="country_id" id="country_id">
                <option value="">@lang('site::messages.select_from_list')</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="contact">@lang('site::trade.phone')</label>
            <input type="tel" name="phone" id="phone"
                   title="@lang('site::trade.placeholder.phone')"
                   pattern="^\d{10}$" maxlength="10"
                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::trade.placeholder.phone')"
                   value="{{ old('phone') }}" required>
            <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
            <small id="phoneHelp" class="mb-4 form-text text-success">
                @lang('site::trade.help.phone')
            </small>
        </div>
    </div>
    <div class="form-row">
        <div class="col mb-3">
            <label for="address">@lang('site::trade.address')</label>
            <input type="text" name="address" id="address"
                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                   placeholder="@lang('site::trade.placeholder.address')"
                   value="{{ old('address') }}" required>
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
        </div>
    </div>
</form>