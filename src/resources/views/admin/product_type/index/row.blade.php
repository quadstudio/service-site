<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <a class="text-large mb-1 d-block"
                       href="{{ route('admin.product_types.show', $type) }}">{{ $type->name }}</a>

                </div>
                <div class="col-12 col-md-5 col-xl-5">
                    <div class="mb-2 mb-md-0 text-muted">
                        {!! $type->description !!}
                    </div>
                </div>
                <div class="col-12 col-md-3 col-xl-3">
                    @lang('site::product.cards'): {{$type->products()->count()}}
                </div>
            </div>

        </div>
    </div>
</div>