<div class="mx-2 px-2 d-inline-block">
    <img style="width:150px;" class="img-fluid border" src="{{ Storage::disk($image->storage)->url($image->path) }}">
    <input form="form-content" type="hidden" name="image[{{$image->id}}]" value="{{$image->id}}">
</div>


