<div class="card" id="file-{{$file->id}}">
    <div class="card-header with-elements">
        <div class="card-header-elements">
            <a href="{{ route('files.show', $file) }}" class="card-link">{{$file->name}}</a>
            <input form="{{(isset($form)?$form:'form')}}"
                   type="hidden"
                   name="file[{{$file->type_id}}][{{$file->id}}]" value="{{$file->id}}">
        </div>
        <div class="card-header-elements ml-md-auto">
            <span class="badge text-normal badge-pill badge-light">{{formatFileSize($file->size)}}</span>
        </div>
    </div>
    @if($file->isImage)
        <img src="{{$file->src}}" class="img-fluid card-img-top" alt="{{$file->name}}">
    @endif
    <div class="card-footer">
        <a class="@cannot('delete', $file) disabled @endcannot btn btn-sm btn-danger btn-row-delete"
           data-form="#file-delete-form-{{$file->id}}"
           data-btn-delete="@lang('site::messages.delete')"
           data-btn-cancel="@lang('site::messages.cancel')"
           data-label="@lang('site::messages.delete_confirm')"
           data-message="@lang('site::messages.delete_sure') @lang('site::file.file')? "
           data-toggle="modal" data-target="#form-modal"
           href="javascript:void(0);" title="@lang('site::messages.delete')">
            <i class="fa fa-close"></i> @lang('site::messages.delete')
        </a>
        <form id="file-delete-form-{{$file->id}}" action="{{route('files.destroy', $file)}}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>