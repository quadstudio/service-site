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
                    <span class="text-muted">{{$product->type->name}}</span>
                    <h5 class="item-content-name mb-1">
                        <a href="{{ route('admin.products.show', $product) }}" class="text-dark">{!! $product->name() !!}</a>
                    </h5>
                    {{--<div class="item-content-user text-muted mb-2">--}}
                        {{--@lang('site::product.address') : {{$product->address}}--}}
                    {{--</div>--}}
                    {{--<div class="item-content-user text-muted small mb-2">--}}
                        {{--<img style="width: 30px;" class="img-fluid border" src="{{ asset($product->country->flag) }}"--}}
                             {{--alt="">--}}
                        {{--{{ $product->country->name }}--}}
                    {{--</div>--}}
                    <hr class="border-light">
                    <div>
                        {{--<span class="text-secondary mr-3">{{$product->country->phone}}{{$product->phone}}</span>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>