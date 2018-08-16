<dl class="row">
    @foreach($types as $type)
        @if(in_array($type->id, [1,2]))
            <dt class="@if($fails->contains('field', 'file_'.$type->id)) bg-danger text-white @endif col-sm-4 text-left text-sm-right">{{$type->name}}</dt>
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

        @endif
    @endforeach
</dl>