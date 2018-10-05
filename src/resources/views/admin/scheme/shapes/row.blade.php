<div id="shape-{{$shape->id}}">
    <area data-number="{{$element->number}}"
          class="shape-pointer"
          shape="{{$shape->shape}}"
          coords="{{$shape->coords}}"
          onclick="$(this).next().trigger('click');"
          data-maphilight='{"strokeColor":"ed9068","strokeWidth":2,"fillColor":"ed9068","fillOpacity":0.3}'/>
    <button style="display: none" class="btn-row-delete"
            data-number="{{$element->number}}"
            data-form="#shape-delete-form-{{$shape->id}}"
            data-btn-delete="@lang('site::messages.delete')"
            data-btn-cancel="@lang('site::messages.cancel')"
            data-label="@lang('site::messages.delete_confirm')"
            data-message="@lang('site::messages.delete_sure') @lang('site::shape.shape')? "
            data-toggle="modal" data-target="#form-modal"
            href="javascript:void(0);" title="@lang('site::messages.delete')">
    </button>
    <form id="shape-delete-form-{{$shape->id}}"
          action="{{route('admin.shapes.destroy', $shape)}}"
          method="POST">
        @csrf
        @method('DELETE')
    </form>
</div>