<div class="form-group required" id="form-group-engineer_id">
    <label class="control-label" for="engineer_id">@lang('site::repair.engineer_id')</label>

    <select data-form-action="{{ route('engineers.create') }}"
            data-btn-ok="@lang('site::messages.save')"
            data-btn-cancel="@lang('site::messages.cancel')"
            data-label="@lang('site::messages.add') @lang('site::engineer.engineer')"
            class="dynamic-modal-form form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
            name="engineer_id" id="engineer_id">
        <option value="">@lang('site::repair.default.engineer_id')</option>
        @foreach($engineers as $engineer)
            <option @if(old('engineer_id') == $engineer->id) selected @endif
            value="{{ $engineer->id }}">{{ $engineer->name }}</option>
        @endforeach
        <option disabled value="">@lang('site::repair.help.engineer_id')</option>
        <option value="load">✚ @lang('site::messages.add')</option>
    </select>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible mt-1">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p class="mb-0"><i class="icon mr-2 fa fa-check"></i> {!! session('success') !!}</p>
        </div>
    @endif
    <span class="invalid-feedback">{{ $errors->first('engineer_id') }}</span>

</div>