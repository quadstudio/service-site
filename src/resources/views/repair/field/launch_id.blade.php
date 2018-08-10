<div class="form-group required" id="form-group-launch_id">
    <label class="control-label" for="launch_id">@lang('site::repair.launch_id')</label>
    @if($fails->contains('field', 'launch_id'))
        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
        <select data-form-action="{{ route('launches.create') }}"
                data-btn-ok="@lang('site::messages.save')"
                data-btn-cancel="@lang('site::messages.cancel')"
                data-label="@lang('site::messages.add') @lang('site::launch.launch')"
                class="dynamic-modal-form form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                name="launch_id" id="launch_id">
            <option value="">@lang('site::repair.default.launch_id')</option>
            @foreach($launches as $launch)
                <option @if(old('launch_id', isset($repair) ? $repair->launch_id : null) == $launch->id) selected @endif
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
    @elseif(isset($repair))
        <div class="text-success text-big">{{$repair->launch->name}}</div>
    @endif
</div>