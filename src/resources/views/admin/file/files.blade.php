<dl class="row">
    @foreach($file_types as $file_type)
        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'file_'.$file_type->id)) bg-danger text-white @endif">
            <label for="file_{{$file_type->id}}"
                   class="pointer control-label">
                <i class="fa text-danger fa-hand-pointer-o"></i>
                {{$file_type->name}}
            </label>
            <input id="file_{{$file_type->id}}"
                   value="file_{{$file_type->id}}"
                   @if($fails->contains('field', 'file_'.$file_type->id)) checked @endif
                   type="checkbox" name="fail[][field]" class="d-none repair-error-check" />
        </dt>
        <dd class="col-sm-8">
            <ul class="list-group file-list image-box">
                @if( !$files->isEmpty())
                    @foreach($files as $file)
                        @if($file->type_id == $file_type->id)
                            <li class="list-group-item border-0 p-0">
                                @if($file->isImage)
                                    <img style="max-width:150px;cursor: pointer;"
                                         data-toggle="modal"
                                         data-target=".image-modal-{{$file->id}}"
                                         class="img-fluid border"
                                         src="{{ $file->src() }}">
                                    <div style="z-index: 10000" class="modal fade image-modal-{{$file->id}}"
                                         tabindex="-1"
                                         role="dialog" aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered"
                                             role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img class="img-fluid border"
                                                         src="{{ $file->src() }}">
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
                                @else
                                    <a href="{{ route('files.show', $file) }}" class="">{{$file->name}}</a>
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </dd>
    @endforeach
</dl>