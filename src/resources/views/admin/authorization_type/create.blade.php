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
                <a href="{{ route('admin.authorization-types.index') }}">@lang('site::authorization_type.authorization_types')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::authorization_type.authorization_type')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.authorization-types.store') }}">
                    @csrf

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::authorization_type.name')</label>
                            <input type="text" name="authorization_type[name]"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('authorization_type.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::authorization_type.placeholder.name')"
                                   value="{{ old('authorization_type.name') }}">
                            <span class="invalid-feedback">{{ $errors->first('authorization_type.name') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3 required">

                            <label class="control-label" for="brand_id">@lang('site::authorization_type.brand_id')</label>
                            <select class="form-control{{  $errors->has('authorization_type.brand_id') ? ' is-invalid' : '' }}"
                                    name="authorization_type[brand_id]"
                                    required
                                    id="brand_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($authorization_brands as $authorization_brand)
                                    <option
                                            @if(old('authorization_type.brand_id') == $authorization_brand->id)
                                            selected
                                            @endif
                                            value="{{ $authorization_brand->id }}">{{ $authorization_brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('authorization_type.brand_id') }}</span>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox"
                               class="custom-control-input{{  $errors->has('authorization_type.enabled') ? ' is-invalid' : '' }}"
                               @if(old('authorization_type.enabled', 1) == 1) checked
                               @endif
                               id="enabled"
                               value="1"
                               name="authorization_type[enabled]">
                        <label class="custom-control-label"
                               for="enabled">@lang('site::authorization_type.enabled')</label>
                        <span class="invalid-feedback">{{ $errors->first('authorization_type.enabled') }}</span>
                    </div>

                </form>
                <hr/>
                <div class="form-row">
                    <div class="col text-right">
                        <button form="form-content" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.authorization-types.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection