<div class="toast newest" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
    <div class="toast-header">

        <strong class="mr-auto ">@if(isset($title)) {{$title}}}} @else @lang('site::messages.toast') @endif</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        @if(isset($status))
            <i class="fa fa-check text-{{$status}}"></i>
        @endif
        {{$message}}
    </div>
</div>
