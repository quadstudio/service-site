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

            <div class=" border p-3">
                <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
                   href="{{ route('products.index') }}"
                   role="button">
                    <i class="fa fa-shopping-cart"></i>
                    <span>@lang('site::cart.add_form_cancel')</span>
                </a>
                <a href="{{route('clearCart')}}" class="d-block d-sm-inline-block btn btn-secondary">
                    <i class="fa fa-close"></i>
                    <span>@lang('site::cart.cart_clear')</span>
                </a>
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
                            <form action="{{route('orders.store')}}" method="post">
                                @csrf
                                <div class="card border-0">

                                    <div class="card-body">

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
                                                            @if(old('order.contragent_id') == $contragent->id) selected
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
                                                @if($storehouses->count() != 1)
                                                    <option value="">@lang('site::messages.select_from_list')</option>
                                                @endif
                                                @foreach($storehouses as $storehouse)
                                                    <option
                                                            @if(old('address_id') == $storehouse->id) selected
                                                            @endif
                                                            value="{{ $storehouse->id }}">{{ $storehouse->name }}</option>
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
                                        <h5 class="text-right">@lang('site::cart.total'):</h5>
                                        <h2 class="text-right">
                                            <span id="cart-total">{{ Site::format(Cart::total()) }}</span>
                                        </h2>
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
                    <a href="{{ route('products.index') }}" role="button" class="btn btn-ferroli">@lang('site::cart.to_products')</a>
                </div>
            </div>
        @endif
    </div>
@endsection
