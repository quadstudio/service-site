<form id="form-content" method="POST" action="{{ route('trades.store') }}">
    @csrf
    <div class="form-row">
        <div class="col mb-3">
            <label for="name">@lang('repair::trade.name')</label>
            <input type="text" name="name" id="name" required
                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   placeholder="@lang('repair::trade.placeholder.name')"
                   value="{{ old('name') }}">
            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="form-row">
        <div class="col mb-3">
            <label for="country_id">@lang('repair::trade.country_id')</label>
            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                    name="country_id" id="country_id">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="contact">@lang('repair::trade.phone')</label>
            <input type="tel" name="phone" id="phone"
                   title="@lang('repair::trade.placeholder.phone')"
                   pattern="^\d{10}$" maxlength="10"
                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                   placeholder="@lang('repair::trade.placeholder.phone')"
                   value="{{ old('phone') }}" required>
            <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
            <small id="phoneHelp" class="mb-4 form-text text-success">
                @lang('repair::trade.help.phone')
            </small>
        </div>
    </div>
    <div class="form-row">
        <div class="col mb-3">
            <label for="address">@lang('repair::trade.address')</label>
            <input type="text" name="address" id="address"
                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                   placeholder="@lang('repair::trade.placeholder.address')"
                   value="{{ old('address') }}" required>
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
        </div>
    </div>
</form>