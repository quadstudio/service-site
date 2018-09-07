<div class="items-col col-12">
    <div class="card item-hover mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-9">
                    <span class="text-lighter d-block">{{ $datasheet->file->type->name }}</span>
                    <a class="text-large mb-1"
                       href="{{ route('datasheets.show', $datasheet) }}">{{ $datasheet->name ?: $datasheet->file->name }}</a>

                    <span class="text-muted d-block">@include('site::datasheet.date')</span>
                    @if(!($products = $datasheet->products()->where('enabled', 1)->orderBy('equipment_id')->orderBy('name')->get())->isEmpty())
                        @include('site::datasheet.index.row.products')
                    @endif
                </div>
                <div class="col-sm-3 text-right">
                    @include('site::file.download', ['file' => $datasheet->file])
                </div>
            </div>
        </div>
    </div>
</div>