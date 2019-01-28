@if(isset($image))
    <div class="custom-control p-0 border d-inline-block" id="image-{{$image->id}}">
        <img class="img-fluid" src="{{ Storage::disk($image->storage)->url($image->path) }}">
        <input form="form-content" type="hidden" name="image_id" value="{{$image->id}}">
    </div>
@endif