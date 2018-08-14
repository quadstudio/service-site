<span class="width-20 ml-1 d-inline-block">
    @if($user->isOnline())
        <i data-toggle="tooltip"
           data-placement="top"
           title="@if($user->isOnline()) @lang('site::user.is_online') @endif "
           class="fa fa-circle text-@if($user->isOnline()) text-success @endif"></i>
    @endif
</span>