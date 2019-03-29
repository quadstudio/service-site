@foreach($file_types as $file_type)
    <div class="form-group p-3 border @if($file_type->required) required @endif">
        <div class="row">
            <div class="col-sm-6">

                <label class="control-label d-block">{{$file_type->name}}</label>
                <form method="POST" enctype="multipart/form-data" action="{{route('files.store')}}">
                    @csrf
                    <input type="hidden" name="type_id" value="{{$file_type->id}}"/>
                    <input type="hidden" name="storage" value="{{$file_type->group->storage}}"/>
                    <input type="file" name="path"/>
                    <button data-multiple="{{$file_type->multiple}}" data-list="#file-type-{{$file_type->id}}-list"
                            class="btn btn-ferroli file-type-upload">
                        <i class="fa fa-download"></i>
                        @lang('site::messages.load')
                    </button>
                    <small id="fileHelp-{{$file_type->id}}" class="form-text text-muted">
                        {{$file_type->comment}}
                        <b>@lang('site::mounting.help.button')</b>
                    </small>
                </form>
            </div>
            <div class="col-sm-6" id="file-type-{{$file_type->id}}-list">
                @if($files->isNotEmpty())
                    @foreach($files as $file)
                        @if($file->type_id == $file_type->id)
                            @include('site::file.create.card')
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        <div style="height: 0;" class="form-control border-0 {{ $errors->has('file.'.$file_type->id) ? ' is-invalid' : '' }}"></div>
        <div class="invalid-feedback">{{ $errors->first('file.'.$file_type->id) }}</div>
    </div>

@endforeach
