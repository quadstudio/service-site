<div class="form-group" id="form-group-launch_id">
    <label for="launch_id">@lang('site::repair.launch_id')</label>
    <select data-form-action="{{ route('launches.create') }}"
            data-btn-ok="@lang('site::messages.save')"
            data-btn-cancel="@lang('site::messages.cancel')"
            data-label="@lang('site::messages.add') @lang('site::launch.launch')"
            class="dynamic-modal-form form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
            name="launch_id" id="launch_id">
        <option value="">@lang('site::repair.default.launch_id')</option>
        @foreach($launches as $launch)
            <option @if(old('launch_id') == $launch->id) selected @endif
            value="{{ $launch->id }}">{{ $launch->name }}</option>
        @endforeach
        <option disabled value="">@lang('site::repair.help.launch_id')</option>
        <option value="load">✚ @lang('site::messages.add')</option>
    </select>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible mt-1">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p class="mb-0"><i class="icon mr-2 fa fa-check"></i> {!! session('success') !!}</p>
        </div>
    @endif
    <span class="invalid-feedback">{{ $errors->first('launch_id') }}</span>
</div>