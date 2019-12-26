<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <a class="text-large d-block"
                       href="{{ route('admin.equipments.show', $equipment) }}">{{ $equipment->name }}</a>
                    <span class="text-muted">@lang('site::equipment.catalog_id')</span>
                    <a class="d-block" href="{{route('admin.catalogs.show', $equipment->catalog)}}">{{$equipment->catalog->name}}</a>
                </div>
                <div class="col-12 col-md-5 col-xl-5">
                    <div class="mb-2 mb-md-0">
                        @if($equipment->products()->count())
                            <span class="text-muted">@lang('site::product.header.boiler')</span>
                            @foreach($equipment->products as $product)
                                <a class="d-block mr-2"
                                   href="{{route('admin.products.show', $product)}}">{{$product->name}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-3 col-xl-3">
                    <div class="mb-2 mb-md-0 text-left text-md-right">
                        @include('site::admin.equipment.images')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>