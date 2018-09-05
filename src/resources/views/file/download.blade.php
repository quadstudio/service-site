@if($file)
    <a class="btn btn-success
            @if(isset($small) && $small === true) btn-sm @endif
    @if (!is_null($file->fileable) && $current_user->cannot('view', $file)) disabled @endif"
       href="{{route('files.show', $file)}}">
        <i class="fa fa-download"></i>
        @lang('site::messages.download') @if($file->size > 0)({{formatFileSize($file->size)}})@endif
    </a>
@endif