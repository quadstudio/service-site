<form id="form-content" method="POST" action="{{ route('launches.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-row">
                <div class="col mb-3">
                    <label for="name">@lang('site::launch.name')</label>
                    <input type="text" name="name" id="name" required
                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::launch.placeholder.name')"
                           value="{{ old('name') }}">
                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                </div>
            </div>
            <div class="form-row">
                <div class="col mb-3">
                    <label for="country_id">@lang('site::launch.country_id')</label>
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
                    <label for="contact">@lang('site::launch.phone')</label>
                    <input type="tel" name="phone" id="phone"
                           title="@lang('site::launch.placeholder.phone')"
                           pattern="^\d{10}$" maxlength="10"
                           class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::launch.placeholder.phone')"
                           value="{{ old('phone') }}" required>
                    <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                    <small id="phoneHelp" class="mb-4 form-text text-success">
                        @lang('site::launch.help.phone')
                    </small>
                </div>
            </div>
            <div class="form-row">
                <div class="col mb-3">
                    <label for="address">@lang('site::launch.address')</label>
                    <input type="text" name="address" id="address"
                           class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::launch.placeholder.address')"
                           value="{{ old('address') }}" required>
                    <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">


            <div class="form-row">
                <div class="col mb-3">
                    <label for="document_name">@lang('site::launch.document_name')</label>
                    <input type="text" name="document_name" id="document_name"
                           class="form-control{{ $errors->has('document_name') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::launch.placeholder.document_name')"
                           value="{{ old('document_name') }}" required>
                    <span class="invalid-feedback">{{ $errors->first('document_name') }}</span>
                </div>
            </div>
            <div class="form-row">
                <div class="col mb-3">
                    <label for="document_number">@lang('site::launch.document_number')</label>
                    <input type="text" name="document_number" id="document_number"
                           class="form-control{{ $errors->has('document_number') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::launch.placeholder.document_number')"
                           value="{{ old('document_number') }}" required>
                    <span class="invalid-feedback">{{ $errors->first('document_number') }}</span>
                </div>
            </div>
            <div class="form-row">
                <div class="col mb-3">
                    <label for="document_who">@lang('site::launch.document_who')</label>
                    <input type="text" name="document_who" id="document_who"
                           class="form-control{{ $errors->has('document_who') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::launch.placeholder.document_who')"
                           value="{{ old('document_who') }}" required>
                    <span class="invalid-feedback">{{ $errors->first('document_who') }}</span>
                </div>
            </div>
            <div class="form-row">
                <div class="col mb-3">
                    <label for="document_date">@lang('site::launch.document_date')</label>
                    <input type="date" name="document_date" id="document_date"
                           class="form-control{{ $errors->has('document_date') ? ' is-invalid' : '' }}"
                           placeholder="@lang('site::launch.placeholder.document_date')"
                           value="{{ old('document_date') }}" required>
                    <span class="invalid-feedback">{{ $errors->first('document_date') }}</span>
                </div>
            </div>
        </div>

    </div>


</form>