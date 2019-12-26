<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <a href="{{route('admin.price_types.show', $type)}}" class="text-large mb-1 d-block">{{ $type->name }}</a>
                    <span class="text-muted">{{$type->currency->title}} ({{$type->currency->name}})</span>
		    @lang('site::product.cards'): {{$type->prices()->count()}}
                </div>
		<div class="col-12 col-md-4 col-xl-2">
		<div class="mb-2 mb-md-0 text-large mb-1 d-block">
		{{ $type->display_name }}

		</div>
		</div>
                <div class="col-12 col-md-4 col-xl-2">
                    <div class="mb-2 mb-md-0">
                        @lang('site::price_type.enabled'): @bool(['bool' => $type->enabled == 1])@endbool

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
