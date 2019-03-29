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
                <a href="{{ route('admin.authorization-brands.index') }}">@lang('site::authorization_brand.authorization_brands')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit') {{$authorization_brand->name}}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$authorization_brand->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="authorization-brand-edit-form"
                              action="{{ route('admin.authorization-brands.update', $authorization_brand) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::authorization_brand.name')</label>
                                    <input type="text" name="authorization_brand[name]"
                                           id="name"
                                           required
                                           class="form-control{{ $errors->has('authorization_brand.name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::authorization_brand.placeholder.name')"
                                           value="{{ old('authorization_brand.name', $authorization_brand->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('authorization_brand.name') }}</span>
                                </div>
                            </div>

                            <hr />
                            <div class=" text-right">
                                <button  form="authorization-brand-edit-form" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.authorization-brands.index') }}" class="d-block d-sm-inline btn btn-secondary">
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
