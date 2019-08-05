@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => __('site::cart.cart'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::cart.cart')]
        ]
    ])
@endsection
@section('content')
    <div class="container">

        @if(!Cart::isEmpty())

            <div class=" border p-3 mb-2">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">@lang('site::messages.has_error')</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-secondary d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
                           href="{{ route('products.index') }}"
                           role="button">
                            <i class="fa fa-reply"></i>
                            <span>@lang('site::cart.add_form_cancel')</span>
                        </a>
                        <a href="{{route('clearCart')}}" class="d-block d-sm-inline-block btn btn-danger">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::cart.cart_clear')</span>
                        </a>
                        @if($productGroupTypes->isNotEmpty())
                            <ul class="list-group pt-3 px-0 mb-0">
                                <li class="list-group-item p-0 border-0 font-weight-bold">@lang('site::product_group_type.help.cart')</li>
                                @foreach($productGroupTypes as $productGroupType)
                                    <li class="list-group-item p-0 border-0">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   @if(empty(old()) || (is_array(old('pgt')) && in_array($productGroupType->id, old('pgt'))))
                                                   checked @endempty
                                                   name="pgt[]"
                                                   form="cart-form"
                                                   value="{{$productGroupType->id}}"
                                                   class="custom-control-input"
                                                   id="pgt-{{$productGroupType->id}}">
                                            <label class="custom-control-label" for="pgt-{{$productGroupType->id}}">
                                                <i class="fa fa-{{$productGroupType->icon}} mr-1"></i> {{$productGroupType->name}}
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h4>@lang('site::product_group_type.help.header')</h4>
                        <ul class="list-group">
                            @foreach(trans('site::product_group_type.help.text') as $help_item)
                                <li class="border-0 p-0 pb-2 list-group-item">{{$help_item}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    @foreach(Cart::items() as $item)
                        @include('site::cart.item.row')
                    @endforeach
                    @include('site::cart.modal.delete')
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <form id="cart-form" action="{{route('orders.store')}}" method="post">
                                @csrf
                                <div class="card border-0">

                                    <div class="card-body">
                                        <h5 class="text-right">@lang('site::cart.total')</h5>
                                        <h2 class="text-right">
                                            <span id="cart-total">{{ Site::format(Cart::total()) }}</span>
                                        </h2>
                                        <div class="form-row required">
                                            <label class="control-label"
                                                   for="contragent_id">@lang('site::order.contragent_id')</label>
                                            <select class="form-control{{  $errors->has('order.contragent_id') ? ' is-invalid' : '' }}"
                                                    required
                                                    name="order[contragent_id]"
                                                    id="contragent_id">
                                                @if($contragents->count() == 0 || $contragents->count() > 1)
                                                    <option value="">@lang('site::messages.select_from_list')</option>
                                                @endif
                                                @foreach($contragents as $contragent)
                                                    <option
                                                            @if(old('order.contragent_id') == $contragent->id)
                                                            selected
                                                            @endif
                                                            value="{{ $contragent->id }}">{{ $contragent->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('order.contragent_id') }}</span>
                                        </div>

                                        <div class="form-row required">
                                            <label class="control-label"
                                                   for="address_id">@lang('site::order.address_id')</label>
                                            <select class="form-control{{  $errors->has('order.address_id') ? ' is-invalid' : '' }}"
                                                    required
                                                    name="order[address_id]"
                                                    id="address_id">
                                                @if($warehouses->count() != 1)
                                                    <option value="">@lang('site::messages.select_from_list')</option>
                                                @endif
                                                @foreach($warehouses as $warehouse)
                                                    <option
                                                            @if(old('order.address_id') == $warehouse->id)
                                                            selected
                                                            @endif
                                                            value="{{ $warehouse->id }}">
                                                        {{ $warehouse->name }}
                                                        @if($warehouse->product_group_types()->exists())
                                                            [ {{ $warehouse->product_group_types()->pluck('name')->implode(', ') }}
                                                            ]
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('order.address_id') }}</span>
                                        </div>

                                        <div class="form-row required">
                                            <label class="control-label" for="contacts_comment">
                                                @lang('site::order.contacts_comment')
                                            </label>
                                            <input required
                                                   type="text"
                                                   id="contacts_comment"
                                                   name="order[contacts_comment]"
                                                   class="form-control"
                                                   value="{{ old('order.contacts_comment') }}"
                                                   placeholder="@lang('site::order.placeholder.contacts_comment')">
                                            <span class="invalid-feedback">{{ $errors->first('order.contacts_comment') }}</span>
                                        </div>

                                        <div class="form-row text-right">
                                            <textarea placeholder="@lang('site::cart.order_comment')"
                                                      class="form-control"
                                                      name="message[text]" maxlength="5000" rows="3">
                                            </textarea>
                                            <input type="hidden" name="message[receiver_id]"
                                                   value="{{config('site.receiver_id')}}">
                                            <input type="hidden" name="order[status_id]" value="1">
                                        </div>

                                    </div>
                                    <div class="card-footer text-muted text-center">
                                        <button type="submit" class="btn btn-ferroli btn-lg ">
                                            <i class="fa fa-check"></i> @lang('site::cart.order_confirm')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row my-5">
                <div class="col text-center">
                    <div class="mb-3" style="transform: rotate(15deg);font-size: 2rem;">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <h1 class="font-weight-normal my-3">@lang('site::cart.cart_is_empty')</h1>
                    <a href="{{ route('products.index') }}" role="button"
                       class="btn btn-ferroli">@lang('site::cart.to_products')</a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    try {
        window.addEventListener('load', function () {
            let checks = document.querySelectorAll('[type="checkbox"][name="pgt[]"]');
            for (i = 0; i < checks.length; i++) {
                checks[i].addEventListener('click', function (e) {
                    checkbox = e.target;
                    document.querySelector('[data-product-group-type="' + checkbox.value + '"]').checked = checkbox.checked;
                })
            }
        });
    } catch (e) {
        console.log(e);
    }
</script>
@endpush
