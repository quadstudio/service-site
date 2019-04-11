@if(isset($enabled) && (bool)$enabled === true)
    @lang('site::messages.enabled_'.((int)$bool))
@else
    @lang('site::messages.yes')
@endif