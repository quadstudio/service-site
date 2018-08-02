@if(!$repair->files->isEmpty())
    <ul class="list-group" class="file-list">
        @foreach($repair->files as $key => $file)
            <li class="list-group-item">
                <a href="{{ route('files.show', $file) }}" class="">{{$file->name}}</a>
            </li>
        @endforeach
    </ul>
@endif
