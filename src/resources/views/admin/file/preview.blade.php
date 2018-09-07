@if($file)
    <object style="width: 100%; height:100%" data="{{$file->src()}}" type="{{$file->mime}}">
        <iframe src="https://docs.google.com/viewer?url={{$file->src()}}&embedded=true"></iframe>
    </object>
    <input type="hidden" form="form-content" name="file_id" value="{{$file->id}}">
@endif