<div class="col-12 p-1 sort-item" data-id="{{$image->id}}" id="image-{{$image->id}}">
    <div class="project-attachment ui-bordered p-2">
        <div class="border project-attachment-img"
             style="background-image: url({{ Storage::disk($image->storage)->url($image->path) }})"></div>
        <div class="media-body ml-3">
            <strong class="project-attachment-filename"><i class="fa fa-arrows"></i> {{$image->name}}</strong>
            <div class="text-muted small">{{formatFileSize($image->size)}}</div>
            <div>
                {{--<a href="javascript:void(0)">View</a> &nbsp;--}}
                <a href="{{route('admin.images.show', $image)}}">@lang('site::messages.download')</a>
                <a class="text-danger btn btn-sm btn-light pull-right btn-row-delete"
                   data-form="#image-delete-form-{{$image->id}}"
                   data-btn-delete="@lang('site::messages.delete')"
                   data-btn-cancel="@lang('site::messages.cancel')"
                   data-label="@lang('site::messages.delete_confirm')"
                   data-message="@lang('site::messages.delete_sure') @lang('site::image.image')? "
                   data-toggle="modal" data-target="#form-modal"
                   href="javascript:void(0);" title="@lang('site::messages.delete')">
                    <i class="fa fa-close"></i>
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
</div>