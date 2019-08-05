<div class="card my-2 cart-item" id="cart-item-{{$item->product_id}}">
    <div class="card-body p-2">
        <div class="row">
            <div class="col-xl-6">

                <div class="width-120 d-inline-block">
                    <div class="d-flex" style="justify-content: flex-start">
                        <div style="flex-grow:1">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       form="cart-form"
                                       name="products[]"
                                       @if(empty(old()) || (is_array(old('products')) && in_array($item->product_id, old('products')))) checked
                                       @endempty
                                       value="{{$item->product_id}}"
                                       @if($item->hasGroupType())
                                       data-product-group-type="{{$item->group_type_id}}"
                                       @endif
                                       class="custom-control-input "
                                       id="it-{{$item->product_id}}">
                                <label class="custom-control-label" for="it-{{$item->product_id}}"></label>
                            </div>
                        </div>
                        <div style="flex-grow:4">
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
                    </div>

                </div>
                <div class="d-inline-block pt-1 ml-2 align-top"
                     style="width: calc(100% - 150px)">

                    <a href="{{ $item->url() }}" class="text-big">
                        {!! htmlspecialchars_decode($item->name) !!}
                        @if($item->hasSku())
                            <span class="item-sku">({{ $item->sku }})</span>
                        @endif
                    </a>
                    @if($item->hasGroupType())
                        <div class="text-muted"><i
                                    class="fa fa-{{$item->group_type_icon}} mr-1"></i> {{$item->group_type_name}}</div>
                    @endif

                    {{--<div>--}}
                    {{--@if($item->availability)--}}
                    {{--<span class="item-availability badge badge-success">@lang('site::cart.in_stock')</span>--}}
                    {{--@else--}}
                    {{--<span class="item-availability badge badge-light">@lang('site::cart.out_of_stock')</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}

                    <a class="text-danger text-tiny d-block btn-row-delete mt-3"
                       data-form="#cart-item-delete-form-{{$item->product_id}}"
                       data-btn-delete="@lang('site::messages.delete')"
                       data-btn-cancel="@lang('site::messages.cancel')"
                       data-label="@lang('site::messages.delete_confirm')"
                       data-message="@lang('site::messages.delete_sure') {{ $item->name }}?"
                       data-toggle="modal" data-target="#form-modal"
                       href="javascript:void(0);" title="@lang('site::messages.delete')"><i
                                class="fa fa-close"></i> @lang('site::cart.item_delete')
                    </a>


                    <form id="cart-item-delete-form-{{$item->product_id}}"
                          action="{{route('removeCartItem')}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                    </form>
                    @if(count($item->storehouse_addresses) > 0)
                        {{--<span class="d-block text-muted">@lang('site::product.quantity')</span>--}}
                        <table class="table table-sm mt-1 mb-0">
                            @foreach($item->storehouse_addresses as $address)
                                <tr>
                                    <td class="pl-0">
                                        {{$address['name']}}
                                    </td>
                                    <td class="text-right pr-0">
                                        <span class="badge badge-success">
                                        {{number_format($address['quantity'], 0, '.', ' ')}} {{ $item->unit }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            <div class="col-xl-6 mt-2 mt-xl-0">
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="text-muted">
                            @lang('site::cart.quantity')
                        </div>
                        <form action="{{route('updateCart')}}" method="post">
                            @csrf
                            @method('put')
                            <input type="hidden" name="product_id"
                                   value="{{ $item->product_id }}">
                            <button class="btn btn-light qty-btn btn-minus" style="height: 31px;"
                                    @if($item->quantity() == 1)
                                    disabled
                                    @endif>
                                <i class="fa fa-minus"></i>
                            </button>
                            <input class="mx-0" data-toggle="popover" data-placement="top"
                                   data-trigger="focus"
                                   title="@lang('site::cart.item_hint_title')" name="quantity"
                                   data-content="@lang('site::cart.item_hint_content', ['max' => config('cart.item_max_quantity')])"
                                   min="1" max="{{ config('cart.item_max_quantity') }}"
                                   pattern="([1-9])|([1-9][0-9])" type="number"
                                   value="{{ $item->quantity() }}" required/>
                            <button class="btn btn-light qty-btn btn-plus" style="height: 31px;"
                                    @if($item->quantity() == config('cart.item_max_quantity'))
                                    disabled
                                    @endif>
                                <i class="fa fa-plus"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-muted">@lang('site::cart.price')</div>
                        <div class="pt-2">{{ Cart::price_format($item->price) }}</div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-muted">@lang('site::cart.subtotal')</div>
                        <div class="pt-2">{{ Cart::price_format($item->subtotal()) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>