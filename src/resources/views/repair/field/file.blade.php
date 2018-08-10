<li class="list-group-item">
    <a href="#" onclick="$(this).parent().remove();return false;" title="@lang('site::messages.delete')"
       class="d-inline-block text-danger mr-2"><i class="fa fa-close"></i></a>
    <a href="{{ route('files.show', $file) }}"
       class="">{{$file->name}}</a>
    <input form="repair-form" type="hidden" name="file[{{$file->type_id}}][]" value="{{$file->id}}">
</li>