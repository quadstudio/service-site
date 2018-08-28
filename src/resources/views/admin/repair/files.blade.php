<dl class="row">
    @foreach($types as $type)

        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'file_'.$type->id)) bg-danger text-white @endif">
            <label for="file_{{$type->id}}"
                   class="pointer control-label"><i class="fa text-danger fa-hand-pointer-o"></i> {{$type->name}}
            </label>
            <input id="file_{{$type->id}}"
                   value="file_{{$type->id}}"
                   @if($fails->contains('field', 'file_'.$type->id)) checked @endif
                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
        </dt>
        <dd class="col-sm-8">
            <ul class="list-group file-list">
                @if( !$files->isEmpty())
                    @foreach($files as $file)
                        @if($file->type_id == $type->id)
                            <li class="list-group-item">
                                <a href="{{ route('files.show', $file) }}" class="">{{$file->name}}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </dd>


    @endforeach
</dl>