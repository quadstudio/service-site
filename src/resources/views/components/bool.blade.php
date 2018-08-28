@if((bool)$bool === true)
    <i class="fa fa-check text-success"></i> @lang('site::messages.yes')
@else
    <i class="fa fa-close text-danger"></i> @lang('site::messages.no')
@endif