<div class="card my-2 cart-item" id="cart-item-{{$item->product_id}}">
    <div class="card-body p-2">
        <div class="row">
            <div class="col-xl-6">

                <div class="width-90 d-inline-block">
                    @if($item->hasImage())
                        <img style="cursor: pointer;"
                             data-toggle="modal"
                             data-target=".image-modal-{{$item->product_id}}"
                             class="img-fluid border img-preview"
                             src="{{ $item->image }}">
                        <div style="z-index: 10000"
                             class="modal fade image-modal-{{$item->product_id}}"
                             tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered"
                                 role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img class="img-fluid"
                                             src="{{ $item->image }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-dismiss="modal">
                                            @lang('site::messages.close')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-inline-block pt-1 ml-2 align-top"
                     style="width: calc(100% - 120px)">
                    <a href="{{ $item->url() }}" class="text-big">
                        {!! htmlspecialchars_decode($item->name) !!}
                        @if($item->hasSku())
                            <span class="item-sku">({{ $item->sku }})</span>
                        @endif
                    </a>
                    {{--<div>--}}
                        {{--@if($item->availability)--}}
                            {{--<span class="item-availability badge badge-success">@lang('site::cart.in_stock')</span>--}}
                        {{--@else--}}
                            {{--<span class="item-availability badge badge-light">@lang('site::cart.out_of_stock')</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    <a class="text-danger d-block btn-row-delete mt-3"
                       data-form="#cart-item-delete-form-{{$item->id}}"
                       data-btn-delete="@lang('site::messages.delete')"
                       data-btn-cancel="@lang('site::messages.cancel')"
                       data-label="@lang('site::messages.delete_confirm')"
                       data-message="@lang('site::messages.delete_sure') {{ $item->name }}?"
                       data-toggle="modal" data-target="#form-modal"
                       href="javascript:void(0);" title="@lang('site::messages.delete')"><i
                                class="fa fa-close"></i> @lang('site::cart.item_delete')
                    </a>
                    <form id="cart-item-delete-form-{{$item->id}}"
                          action="{{route('removeCartItem')}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                    </form>

                </div>
            </div>
            <div class="col-xl-6 mt-2 mt-xl-0">
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="text-muted">
                            @lang('site::cart.quantity')
                            @if($item->hasUnit()), {{ $item->unit }}@endif
                        </div>
                        <form action="{{route('updateCart')}}" method="post">
                            @csrf
                            @method('put')
                            <input type="hidden" name="product_id"
                                   value="{{ $item->product_id }}">
                            <button class="btn btn-light qty-btn btn-minus"
                                    @if($item->quantity() == 1)
                                    disabled
                                    @endif>
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <input data-toggle="popover" data-placement="top"
                                   data-trigger="focus"
                                   title="@lang('site::cart.item_hint_title')" name="quantity"
                                   data-content="@lang('site::cart.item_hint_content', ['max' => config('cart.item_max_quantity')])"
                                   min="1" max="{{ config('cart.item_max_quantity') }}"
                                   pattern="([1-9])|([1-9][0-9])" type="number"
                                   value="{{ $item->quantity() }}" required/>
                            <button class="btn btn-light qty-btn btn-plus"
                                    @if($item->quantity() == config('cart.item_max_quantity'))
                                    disabled
                                    @endif>
                                <i class="fa fa-chevron-up"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-muted">@lang('site::cart.price')</div>
                        <div>{{ Cart::price_format($item->price) }}</div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-muted">@lang('site::cart.subtotal')</div>
                        {{ Cart::price_format($item->subtotal()) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>