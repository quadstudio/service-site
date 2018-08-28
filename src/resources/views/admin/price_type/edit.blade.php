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
                <a href="{{ route('admin.price_types.index') }}">@lang('site::price_type.price_types')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.price_types.show', $price_type) }}">{{$price_type->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$price_type->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="price-type-edit-form"
                              action="{{ route('admin.price_types.update', $price_type) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label" for="display_name">@lang('site::price_type.display_name')</label>
                                    <input type="text" name="display_name"
                                           id="display_name"
                                           class="form-control{{ $errors->has('display_name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::price_type.placeholder.display_name')"
                                           value="{{ old('display_name', $price_type->display_name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('display_name') }}</span>
                                </div>
                            </div>

                            <hr/>
                            <div class=" text-right">
                                <button name="_stay" form="price-type-edit-form" value="1" type="submit"
                                        class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save_stay')</span>
                                </button>
                                <button name="_stay" form="price-type-edit-form" value="0" type="submit"
                                        class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.price_types.show', $price_type) }}"
                                   class="d-block d-sm-inline btn btn-secondary">
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
