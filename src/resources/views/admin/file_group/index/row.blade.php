<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-9 col-xl-9">
                    <a class="text-large mb-1 d-block"
                       href="{{ route('admin.file_groups.show', $group) }}">{{ $group->name }}</a>
                </div>
                <div class="col-12 col-md-3 col-xl-3">
                    @lang('site::file_type.file_types'): {{$group->types()->count()}}
                </div>
            </div>

        </div>
    </div>
</div>