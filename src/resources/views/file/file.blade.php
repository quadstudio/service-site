
<li class="list-group-item" id="file-{{$file->id}}">
    @if($file->canDelete())
        <a class="text-danger btn-row-delete"
           data-form="#file-delete-form-{{$file->id}}"
           data-btn-delete="@lang('site::messages.delete')"
           data-btn-cancel="@lang('site::messages.cancel')"
           data-label="@lang('site::messages.delete_confirm')"
           data-message="@lang('site::messages.delete_sure') @lang('site::file.file')? "
           data-toggle="modal" data-target="#form-modal"
           href="javascript:void(0);" title="@lang('site::messages.delete')"><i
                    class="fa fa-close"></i> @lang('site::messages.delete')
        </a>
        <form id="file-delete-form-{{$file->id}}"
              action="{{route('files.destroy', $file)}}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif
        <a href="{{ route('files.show', $file) }}"
           class="">{{$file->name}}</a>
    {{--<img style="width:150px;" class="img-fluid" src="{{ Storage::disk($file->storage)->url($file->path) }}">--}}
    <input form="repair-create-form" type="hidden" name="file[{{$file->type_id}}][{{$file->id}}]" value="{{$file->id}}">
    {{--<a href="#" onclick="$(this).parent().remove();return false;" title="@lang('site::messages.delete')"--}}
       {{--class="d-inline-block text-danger mr-2"><i class="fa fa-close"></i></a>--}}
    {{--<a href="{{ route('files.show', $file) }}"--}}
       {{--class="">{{$file->name}}</a>--}}
    {{--<input form="repair-create-form" type="hidden" name="file[{{$file->type_id}}][]" value="{{$file->id}}">--}}
</li>


