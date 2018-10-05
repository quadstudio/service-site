<div class="items-col col-12">
    <div class="card item-hover mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <span class="text-lighter d-block">{{ $datasheet->file->type->name }}</span>
                    <a class="text-large mb-1"
                       href="{{ route('datasheets.show', $datasheet) }}">{{ $datasheet->name ?: $datasheet->file->name }}</a>
                    <span class="text-muted d-block">@include('site::datasheet.date')</span>

                    @if(!($products = $datasheet->products()->where('enabled', 1)->orderBy('equipment_id')->orderBy('name')->get())->isEmpty())
                        @include('site::datasheet.index.row.products')
                    @endif
                </div>
                <div class="col-sm-3">

                    @if($datasheet->schemes()->count() > 0)
                        @if($products->isNotEmpty())
                            <div class="dropdown">
                                <a class="btn btn-ferroli dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('site::scheme.schemes')
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach($products as $product)
                                    <a class="dropdown-item" href="{{route('products.scheme', [$product, $datasheet->schemes()->first()])}}">{!! $product->name !!}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="col-sm-3 text-left text-xl-right">

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