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
                <a href="{{ route('admin.mounting-bonuses.index') }}">@lang('site::mounting_bonus.mounting_bonuses')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.show', $mounting_bonus->product) }}">
                    {{ $mounting_bonus->product->name}}
                    ({{ $mounting_bonus->product->sku }})
                </a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::mounting_bonus.mounting_bonus')</h1>

        @alert()@endalert()
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('site::messages.has_error')</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center mb-5">
            <div class="col">
                <form id="form-content"
                      method="POST"
                      enctype="multipart/form-data"
                      action="{{ route('admin.mounting-bonuses.update', $mounting_bonus) }}">

                    @csrf
                    @method('PUT')

                    {{-- КЛИЕНТ --}}
                    <div class="card mt-2 mb-2">
                        <div class="card-body">

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="product_id">@lang('site::mounting_bonus.product_id')</label>
                                    <select class="form-control{{  $errors->has('mounting_bonus.product_id') ? ' is-invalid' : '' }}"
                                            required
                                            name="mounting_bonus[product_id]"
                                            id="product_id">
                                            <option value="{{ $mounting_bonus->product_id }}">
                                                {{ $mounting_bonus->product->name }}
                                                ({{ $mounting_bonus->product->sku }})
                                            </option>
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('mounting_bonus.product_id') }}</span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="mounting_bonus_value">@lang('site::mounting_bonus.value')</label>
                                    <input type="number"
                                           name="mounting_bonus[value]"
                                           id="mounting_bonus_value"
                                           min="0"
                                           step="100"
                                           max="10000"
                                           required
                                           class="form-control{{$errors->has('mounting_bonus.value') ? ' is-invalid' : ''}}"
                                           placeholder="@lang('site::mounting_bonus.placeholder.value')"
                                           value="{{ old('mounting_bonus.value', $mounting_bonus->value) }}">
                                    <span class="invalid-feedback">{{ $errors->first('mounting_bonus.value') }}</span>
                                </div>

                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="mounting_bonus_social">@lang('site::mounting_bonus.social')</label>
                                    <input type="number"
                                           name="mounting_bonus[social]"
                                           id="mounting_bonus_social"
                                           min="0"
                                           step="100"
                                           max="10000"
                                           required
                                           class="form-control{{$errors->has('mounting_bonus.social') ? ' is-invalid' : ''}}"
                                           placeholder="@lang('site::mounting_bonus.placeholder.social')"
                                           value="{{ old('mounting_bonus.social', $mounting_bonus->social) }}">
                                    <span class="invalid-feedback">{{ $errors->first('mounting_bonus.social') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>

                <div class="card my-2">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col text-right">
                                <button form="form-content" type="submit"
                                        class="btn btn-ferroli mb-1">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.products.show', $mounting_bonus->product) }}" class="btn btn-secondary mb-1">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
