@if(isset($file) && is_object($file) && $file->exists)
    <div class="col-md-12 my-2" id="file-{{$file->id}}">

        <input form="form" type="hidden" name="{{config('site.' . $file->storage . '.name', 'files[]')}}"
               value="{{old(config('site.' . $file->storage . '.dot_name'), $file->id)}}">
        <div class="row">
            @if(!in_array($file->mime, array(
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            )))
                <div class="col-md-6 border position-relative">
                    @include('site::admin.file.preview')
                </div>
            @endif
            <div class="col-md-6">
                <a href="{{route('admin.files.show', $file)}}" class="project-attachment-filename">{{$file->name}}</a>
                <div class="text-muted small">
                    {{formatFileSize($file->size)}}

                    {{--<span class="text-muted">(@lang('site::file.real_size'):--}}
                    {{--{{formatFileSize(filesize(Storage::disk($file->storage)->getAdapter()->getPathPrefix().$file->path))}}--}}
                    {{--)--}}
                    {{--</span>--}}
                </div>
                @if((!isset($delete) || $delete === true))
                    <a class="btn btn-sm py-0 btn-danger btn-row-delete"
                       data-form="#file-delete-form-{{$file->id}}"
                       data-btn-delete="@lang('site::messages.delete')"
                       data-btn-cancel="@lang('site::messages.cancel')"
                       data-label="@lang('site::messages.delete_confirm')"
                       data-message="@lang('site::messages.delete_sure') @lang('site::file.file')? "
                       data-toggle="modal" data-target="#form-modal"
                       href="javascript:void(0);" title="@lang('site::messages.delete')">
                        <i class="fa fa-close"></i> @lang('site::messages.delete')
                    </a>
                    <form id="file-delete-form-{{$file->id}}"
                          action="{{route('admin.files.destroy', $file)}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>
@endif