<option value="">@lang('site::messages.select_from_list')</option>
@foreach($trades as $trade)
    <option @if(isset($trade_id) && $trade_id == $trade->id)
            selected
            @endif
            value="{{ $trade->id }}">
        {{ $trade->name }}
    </option>
@endforeach
<optgroup label="@lang('site::trade.help.not_found')">
    <option value="load">✚ @lang('site::messages.add')</option>
</optgroup>