<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-5">
                    <a class="text-large mb-1 d-block"
                       href="{{ route('admin.file_types.show', $type) }}">{{ $type->name }}</a>
                    <span class="text-muted">{!! $type->description !!}</span>
                </div>
                <div class="col-12 col-md-5 col-xl-4">
                    <div class="mb-2 mb-md-0">
                        <a class="mb-1 d-block"
                           href="{{ route('admin.file_groups.show', $type->group) }}">{{ $type->group->name }}</a>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-xl-3">
                    @lang('site::file.files'): {{$type->files()->count()}}
                </div>
            </div>

        </div>
    </div>
</div>