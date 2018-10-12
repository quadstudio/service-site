<tr class="sort-item" data-id="{{$image->id}}">

    <td class="p-1 width-150">
        <div class="custom-control custom-checkbox">
            <input type="checkbox"
                   form="delete-form"
                   name="images[]"
                   value="{{$image->id}}"
                   class="custom-control-input"
                   id="image-{{$image->id}}">
            <label class="custom-control-label" for="image-{{$image->id}}">
                <img style="width:150px;" class="img-fluid border" src="{{ Storage::disk($image->storage)->url($image->path) }}">
            </label>
        </div>
    </td>
    <td class="p-1">
        {!! $image->name !!}
        <input form="form-content" type="hidden" name="image[{{$image->id}}]" value="{{$image->id}}">
    </td>
    <td class="p-1 width-10 text-center"><i class="fa fa-arrows"></i></td>
</tr>