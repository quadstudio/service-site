<span class="badge text-normal badge-pill @if($bool) badge-success @else badge-danger @endif">
    <i class="fa @if($bool) fa-check @else fa-close @endif"></i>
    @if($slot != "")
        {{$slot}}
    @else
        @lang('site::messages.enabled_'.(int)$bool)
    @endif
</span>