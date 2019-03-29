<div class="form-group required mt-2" id="form-group-address_id">
    <label class="control-label"
           for="address_id">{{$address_type->name}}</label>
    <select data-form-action="{{ route('addresses.create', $address_type) }}"
            data-btn-ok="@lang('site::messages.save')"
            data-btn-cancel="@lang('site::messages.cancel')"
            data-label="@lang('site::messages.add') @lang('site::address.address')"
            class="dynamic-modal-form form-control{{  $errors->has('address_id') ? ' is-invalid' : '' }}"
            required
            name="address_id"
            id="address_id">
        <option value="">@lang('site::messages.select_from_list')</option>
        @foreach($addresses as $address)
            <option value="{{ $address->id }}"
                    @if(old('address_id', isset($selected) ? $selected : null) == $address->id) selected @endif>
                {{ $address->name }}
                ({{ $address->full }})
            </option>
        @endforeach
        <option disabled value="">@lang('site::authorization.help.address_id')</option>
        <option value="load">✚ @lang('site::messages.add')</option>
    </select>
    <span class="invalid-feedback">{{ $errors->first('address_id') }}</span>
</div>