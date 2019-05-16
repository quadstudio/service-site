@if(isset($image) && is_object($image) && $image->exists && $image->fileExists)
    <div class="col-md-12 my-2" data-id="{{$image->id}}" id="image-{{$image->id}}">
        <input form="form" type="hidden" name="{{config('site.' . $image->storage . '.name', 'images[]')}}"
               value="{{old(config('site.' . $image->storage . '.dot_name'), $image->id)}}">
        <div class="row">

            <div class="col-md-4 border position-relative">
                <i data-toggle="tooltip"
                   data-placement="top"
                   title="@lang('site::messages.sort')"
                   class="fa fa-arrows position-absolute" style="top:8px;left:8px;"></i>
                @include('site::admin.image.preview')
            </div>
            <div class="col-md-8">
                <strong class="project-attachment-filename">{{$image->name}}</strong>
                <div class="text-muted small">{{formatFileSize($image->size)}}</div>
                <div class="text-muted small">{{formatImageDimension(Storage::disk($image->storage)->url($image->path))}}</div>
                <a class="btn btn-sm py-0 btn-ferroli"
                   href="{{route('admin.images.show', $image)}}">@lang('site::messages.download')</a>
                <a class="btn btn-sm py-0 btn-danger btn-row-delete"
                   data-form="#image-delete-form-{{$image->id}}"
                   data-btn-delete="@lang('site::messages.delete')"
                   data-btn-cancel="@lang('site::messages.cancel')"
                   data-label="@lang('site::messages.delete_confirm')"
                   data-message="@lang('site::messages.delete_sure') @lang('site::image.image')? "
                   data-toggle="modal" data-target="#form-modal"
                   href="javascript:void(0);" title="@lang('site::messages.delete')">
                    <i class="fa fa-close"></i> @lang('site::messages.delete')
                </a>
                <form id="image-delete-form-{{$image->id}}"
                      action="{{route('admin.images.destroy', $image)}}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endif