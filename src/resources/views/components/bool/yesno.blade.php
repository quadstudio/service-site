<span class="font-weight-bold @if($bool) text-success @else text-danger @endif">
    <i class="fa @if($bool) fa-check @else fa-close @endif"></i>
    @if($slot != "")
        {{$slot}}
    @else
        @lang('site::messages.yesno_'.(int)$bool)
    @endif
</span>