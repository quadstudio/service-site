<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="items-dropdown btn-group">
                <button type="button"
                        class="btn btn-sm btn-ferroli border btn-round md-btn-flat dropdown-toggle icon-btn hide-arrow"
                        data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="items-dropdown-menu dropdown-menu dropdown-menu-right"
                     x-placement="bottom-end"
                     style="position: absolute; will-change: top, left; top: 26px; left: -134px;">
                    <a class="dropdown-item"
                       href="{{ route('admin.products.edit', $product) }}">@lang('site::messages.edit')</a>
                </div>
            </div>
            <div class="item-content">
                <div class="item-content-about">
                    <span class="text-muted">{{$product->type ? $product->type->name : null}}</span>
					
                    <h5 class="item-content-name mb-1">
                        <a href="{{ route('admin.products.show', $product) }}" class="text-dark">{!! $product->name() !!}</a>
                    </h5> 
					<div class="col-md-3 col-xl-3 d-inline-block">
						 @if($product->mounting_bonus) 
						 <div class="text-muted d-inline-block">@lang('site::mounting_bonus.header.mounting_bonus')
						 </div>
						 <div class="d-inline-block">{{ $product->mounting_bonus->value }} + {{ $product->mounting_bonus->social }}
						 </div>
						 @endif
					</div>
					<div class="col-md-2 col-xl-2 d-inline-block text-muted">
						@lang('site::product.enabled') @bool(['bool' => $product->enabled == 1])@endbool
					</div>
					<div class="col-md-2 col-xl-2 d-inline-block text-muted">
						@lang('site::product.active') @bool(['bool' => $product->active == 1])@endbool
					</div>
					<div class="col-md-2 col-xl-2 d-inline-block text-muted">
						@lang('site::product.forsale') @bool(['bool' => $product->forsale == 1])@endbool
					</div>
					<div class="col-md-2 col-xl-2 d-inline-block text-muted">
						@lang('site::product.warranty') @bool(['bool' => $product->warranty == 1])@endbool
					</div>
					
                </div>
            </div>
        </div>
    </div>
</div>