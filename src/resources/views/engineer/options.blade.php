<option value="">@lang('site::messages.select_from_list')</option>
@foreach($engineers as $engineer)
    <option @if(isset($engineer_id) && $engineer_id == $engineer->id)
            selected
            @endif
            @if($engineer->certificates()->where('type_id', $certificate_type_id)->doesntExist())
            disabled
            @endif
            value="{{ $engineer->id }}">
        {{ $engineer->name }}
        @if($engineer->certificates()->where('type_id', $certificate_type_id)->doesntExist())
            @lang('site::certificate.error.not_exist')
        @endif
    </option>
@endforeach
<optgroup label="@lang('site::engineer.help.not_found')">
    <option value="load">✚ @lang('site::messages.add')</option>
</optgroup>