@if($catalog->enabled)
    <i data-toggle="tooltip" data-placement="top" title="@lang('equipment::catalog.enabled')"
       class="fa fa-check text-success"></i>
@else
    <i data-toggle="tooltip" data-placement="top" title="@lang('equipment::catalog.enabled')"
       class="fa fa-close text-secondary"></i>
@endif