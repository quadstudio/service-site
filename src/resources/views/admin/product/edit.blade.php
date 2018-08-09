@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}">@lang('site::product.cards')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.show', $product) }}">{{$product->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$product->name()}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="product-edit-form" action="{{ route('admin.products.update', $product) }}">

                            @csrf

                            @method('PUT')
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="enabled">@lang('site::product.enabled')</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('enabled') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="enabled"
                                               required
                                               @if(old('enabled', $product->enabled) == 1) checked @endif
                                               id="enabled_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="enabled_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('enabled') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="enabled"
                                               required
                                               @if(old('enabled', $product->enabled) == 0) checked @endif
                                               id="enabled_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="enabled_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="active">@lang('site::product.active')</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('active') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="active"
                                               required
                                               @if(old('active', $product->active) == 1) checked @endif
                                               id="active_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="active_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('active') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="active"
                                               required
                                               @if(old('active', $product->active) == 0) checked @endif
                                               id="active_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="active_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="warranty">@lang('site::product.warranty')</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('warranty') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="warranty"
                                               required
                                               @if(old('warranty', $product->warranty) == 1) checked @endif
                                               id="warranty_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="warranty_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('warranty') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="warranty"
                                               required
                                               @if(old('warranty', $product->warranty) == 0) checked @endif
                                               id="warranty_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="warranty_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="service">@lang('site::product.service')</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('service') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="service"
                                               required
                                               @if(old('service', $product->service) == 1) checked @endif
                                               id="service_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="service_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                        {{$errors->has('service') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="service"
                                               required
                                               @if(old('service', $product->service) == 0) checked @endif
                                               id="service_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="service_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label for="description">@lang('site::product.description')</label>
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::product.placeholder.description')"
                                              name="description"
                                              id="description">{{ old('description', $product->description) }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class=" border p-3 mt-2 mb-4">
            {{--<a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('products.create') }}"--}}
               {{--role="button">--}}
                {{--<i class="fa fa-plus"></i>--}}
                {{--<span>@lang('site::messages.add') @lang('site::product.product')</span>--}}
            {{--</a>--}}
            <button name="_stay" form="product-edit-form" value="1" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save_stay')</span>
            </button>
            <button name="_stay" form="product-edit-form" value="0" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('admin.products.show', $product) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection
