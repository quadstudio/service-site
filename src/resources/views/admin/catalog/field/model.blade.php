@if($catalog->model)
    <i data-toggle="tooltip" data-placement="top" title="@lang('equipment::catalog.model')"
       class="fa fa-check text-success"></i>
@else
    <i data-toggle="tooltip" data-placement="top" title="@lang('equipment::catalog.model')"
       class="fa fa-close text-secondary"></i>
@endif