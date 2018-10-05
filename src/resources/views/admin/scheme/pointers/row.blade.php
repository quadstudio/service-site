<div id="pointer-{{$pointer->id}}">
    <button class="pointer img-pointer btn-row-delete"
            data-number="{{$element->number}}"
            data-form="#pointer-delete-form-{{$pointer->id}}"
            data-btn-delete="@lang('site::messages.delete')"
            data-btn-cancel="@lang('site::messages.cancel')"
            data-label="@lang('site::messages.delete_confirm')"
            data-message="@lang('site::messages.delete_sure') @lang('site::pointer.pointer')? "
            data-toggle="modal" data-target="#form-modal"
            style="top:{{$pointer->y}}px;left:{{$pointer->x}}px"
            href="javascript:void(0);" title="@lang('site::messages.delete')">
        {{$pointer->element->number}}
    </button>
    <form id="pointer-delete-form-{{$pointer->id}}"
          action="{{route('admin.pointers.destroy', $pointer)}}"
          method="POST">
        @csrf
        @method('DELETE')
    </form>
</div>