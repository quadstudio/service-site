@if((bool)$bool === true)
    @includeWhen(isset($enabled) && (bool)$enabled === true, 'site::components.bool.enabled')
    <i class="fa fa-check text-success"></i>
@else
    @includeWhen(isset($enabled) && (bool)$enabled === true, 'site::components.bool.enabled')
    <i class="fa fa-close text-danger"></i>
@endif