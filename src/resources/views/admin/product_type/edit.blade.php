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
                <a href="{{ route('admin.product_types.index') }}">@lang('site::product_type.product_types')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.product_types.show', $product_type) }}">{{$product_type->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$product_type->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="product-type-edit-form"
                              action="{{ route('admin.product_types.update', $product_type) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::product_type.name')</label>
                                    <input type="text" name="name"
                                           id="name"
                                           required
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::product_type.placeholder.name')"
                                           value="{{ old('name', $product_type->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label for="description">@lang('site::product_type.description')</label>
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::product_type.placeholder.description')"
                                              name="description"
                                              id="description">{{ old('description', $product_type->description) }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <hr />
                            <div class=" text-right">
                                {{--<a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('products.create') }}"--}}
                                {{--role="button">--}}
                                {{--<i class="fa fa-plus"></i>--}}
                                {{--<span>@lang('site::messages.add') @lang('site::product_type.product')</span>--}}
                                {{--</a>--}}
                                <button name="_stay" form="product-type-edit-form" value="1" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save_stay')</span>
                                </button>
                                <button name="_stay" form="product-type-edit-form" value="0" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.product_types.show', $product_type) }}" class="d-block d-sm-inline btn btn-secondary">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
