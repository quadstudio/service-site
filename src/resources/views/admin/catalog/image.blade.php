<div class="p-2 bd-highlight" id="catalog-image-{{$image->id}}" style="width: 150px;">
    {{--<h5 class="card-title">Название карточки</h5>--}}
    @if($image->canDelete())
        <a class="text-danger btn-row-delete"
           data-form="#catalog-image-delete-form-{{$image->id}}"
           data-btn-delete="@lang('equipment::messages.delete')"
           data-btn-cancel="@lang('equipment::messages.cancel')"
           data-label="@lang('equipment::messages.delete_confirm')"
           data-message="@lang('equipment::messages.delete_sure') @lang('equipment::catalog_image.image')? "
           data-toggle="modal" data-target="#form-modal"
           href="javascript:void(0);" title="@lang('equipment::messages.delete')"><i
                    class="fa fa-close"></i> @lang('equipment::messages.delete')
        </a>
        <form id="catalog-image-delete-form-{{$image->id}}"
              action="{{route('admin.catalog_images.destroy', $image)}}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif
    <img class="img-fluid img-thumbnail" src="{{ Storage::disk('equipment')->url($image->path) }}">
    <input form="form-content" type="hidden" name="image[]" value="{{$image->id}}">
</div>