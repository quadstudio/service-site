@if((bool)$bool === true)
    <i class="fa fa-check text-success"></i> @if(isset($enabled) && (bool)$enabled === true) @lang('site::messages.enabled_'.((int)$bool)) @else @lang('site::messages.yes') @endif
@else
    <i class="fa fa-close text-danger"></i> @if(isset($enabled) && (bool)$enabled === true) @lang('site::messages.enabled_'.((int)$bool)) @else @lang('site::messages.no') @endif
@endif