@isset($image)
    <img style="width:{{config('site.'.$image->storage.'.size.preview.width', 150)}}px;height:{{config('site.'.$image->storage.'.size.preview.height', 150)}}px;cursor: pointer;"
         data-toggle="modal"
         data-target=".image-modal-{{$image->id}}"
         class="img-fluid img-preview"
         src="{{ $image->src() }}">
    <div style="z-index: 10000" class="modal fade image-modal-{{$image->id}}"
         tabindex="-1"
         role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered"
             role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img class="img-fluid"
                         src="{{ Storage::disk($image->storage)->url($image->path) }}">
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        @lang('site::messages.close')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endisset