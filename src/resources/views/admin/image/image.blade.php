<div class="border mx-2 px-2 d-inline-block" id="image-{{$image->id}}">
    @if($image->canDelete())
        <a class="text-danger btn-row-delete"
           data-form="#image-delete-form-{{$image->id}}"
           data-btn-delete="@lang('site::messages.delete')"
           data-btn-cancel="@lang('site::messages.cancel')"
           data-label="@lang('site::messages.delete_confirm')"
           data-message="@lang('site::messages.delete_sure') @lang('site::image.image')? "
           data-toggle="modal" data-target="#form-modal"
           href="javascript:void(0);" title="@lang('site::messages.delete')"><i
                    class="fa fa-close"></i> @lang('site::messages.delete')
        </a>
        <form id="image-delete-form-{{$image->id}}"
              action="{{route('admin.images.destroy', $image)}}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif

    <img style="width:150px;" class="img-fluid" src="{{ Storage::disk($image->storage)->url($image->path) }}">
    <input form="form-content" type="hidden" name="image[{{$image->id}}]" value="{{$image->id}}">
</div>


