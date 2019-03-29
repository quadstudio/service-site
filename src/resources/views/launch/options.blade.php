<option value="">@lang('site::messages.select_from_list')</option>
@foreach($launches as $launch)
    <option @if(isset($launch_id) && $launch_id == $launch->id)
            selected
            @endif
            value="{{ $launch->id }}">
        {{ $launch->name }}
    </option>
@endforeach
<optgroup label="@lang('site::launch.help.not_found')">
    <option value="load">✚ @lang('site::messages.add')</option>
</optgroup>