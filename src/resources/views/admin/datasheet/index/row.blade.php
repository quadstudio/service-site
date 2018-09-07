<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <a class="text-large mb-1"
                       href="{{ route('admin.datasheets.show', $datasheet) }}">{{ $datasheet->name ?: $datasheet->file->name }}</a>
                    <span class="text-muted d-block">{{ $datasheet->file->type->name }}</span>
                    <span class="text-muted d-block">@include('site::datasheet.date')</span>
                </div>
                <div class="col-sm-3 text-xlarge text-right">
                    {{$datasheet->products()->count()}}
                </div>
                <div class="col-sm-4 text-right">

                    @include('site::file.download', ['file' => $datasheet->file])
                </div>
            </div>
        </div>
    </div>
</div>