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
                    <div class="row">
                        <div class="col">
                            <span data-toggle="tooltip" data-placement="top" title="@lang('site::file.downloads')">
                                <i class="fa fa-download"></i>
                                {{$datasheet->file->downloads}}
                            </span>
                            &nbsp;&nbsp;
                            <i class="fa fa-chain"></i>
                            {{$datasheet->products()->count()}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                    @if($datasheet->file->exists())
                        @include('site::file.download', ['file' => $datasheet->file])
                    @else
                        <span class="badge badge-danger text-big">@lang('site::file.error.not_found')</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>