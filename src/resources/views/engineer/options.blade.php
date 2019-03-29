<option value="">@lang('site::messages.select_from_list')</option>
@foreach($engineers as $engineer)
    <option @if(isset($engineer_id) && $engineer_id == $engineer->id)
            selected
            @endif
            value="{{ $engineer->id }}">
        {{ $engineer->name }}
    </option>
@endforeach
<optgroup label="@lang('site::engineer.help.not_found')">
    <option value="load">✚ @lang('site::messages.add')</option>
</optgroup>