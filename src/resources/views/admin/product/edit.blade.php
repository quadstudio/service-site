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
                <a href="{{ route('admin.products.show', $product) }}">{!! $product->name !!}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {!! $product->name !!}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="summernote">
                        <form method="POST" id="form-content"
                              action="{{ route('admin.products.update', $product) }}">

                            @csrf

                            @method('PUT')
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label text-big" for="name">@lang('site::product.name')</label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           required
                                           class="form-control form-control-lg {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::product.placeholder.name')"
                                           value="{{ old('name', $product->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <label class="control-label"
                                               for="type_id">@lang('site::product.type_id')</label>
                                        <select class="form-control{{  $errors->has('type_id') ? ' is-invalid' : '' }}"
                                                required
                                                name="type_id"
                                                id="type_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($product_types as $type)
                                                <option @if(old('type_id', $product->type_id) == $type->id) selected
                                                        @endif
                                                        value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="equipment_id">@lang('site::product.equipment_id')</label>
                                            <select class="form-control
                                            {{$errors->has('equipment_id') ? ' is-invalid' : ''}}"
                                                    name="equipment_id"
                                                    id="equipment_id">
                                                <option value="">@lang('site::messages.select_from_list')</option>
                                                @foreach($equipments as $equipment)
                                                    <option
                                                            @if(old('equipment_id', $product->equipment_id) == $equipment->id) selected
                                                            @endif
                                                            value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('equipment_id') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label" for="sku">@lang('site::product.sku')</label>
                                            <input type="text"
                                                   name="sku"
                                                   id="sku"
                                                   required
                                                   class="form-control{{ $errors->has('sku') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.sku')"
                                                   value="{{ old('sku', $product->sku) }}">
                                            <span class="invalid-feedback">{{ $errors->first('sku') }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="old_sku">@lang('site::product.old_sku')</label>
                                            <input type="text"
                                                   name="old_sku"
                                                   id="old_sku"
                                                   class="form-control{{ $errors->has('old_sku') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.old_sku')"
                                                   value="{{ old('old_sku', $product->old_sku) }}">
                                            <span class="invalid-feedback">{{ $errors->first('old_sku') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label" for="h1">@lang('site::product.h1')</label>
                                            <input type="text" name="h1"
                                                   id="h1"
                                                   class="form-control{{ $errors->has('h1') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.h1')"
                                                   value="{{ old('h1', $product->h1) }}">
                                            <span class="invalid-feedback">{{ $errors->first('h1') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label" for="title">@lang('site::product.title')</label>
                                            <input type="text" name="title"
                                                   id="title"
                                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.title')"
                                                   value="{{ old('title', $product->title) }}">
                                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
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
                                </div>
                                <div class="col-md-3 col-sm-6">
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
                                </div>
                                <div class="col-md-3 col-sm-6">
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
                                </div>
                                <div class="col-md-3 col-sm-6">
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
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col mb-3">
                                    <label for="metadescription">@lang('site::product.metadescription')</label>
                                    <textarea
                                            class="form-control{{ $errors->has('metadescription') ? ' is-invalid' : '' }}"
                                            placeholder="@lang('site::product.placeholder.metadescription')"
                                            name="metadescription"
                                            rows="5"
                                            id="metadescription">{!! old('metadescription', $product->metadescription) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('metadescription') }}</span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label for="description">@lang('site::product.description')</label>
                                    <textarea
                                            class="summernote form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                            placeholder="@lang('site::product.placeholder.description')"
                                            name="description"
                                            rows="5"
                                            id="description">{!! old('description', $product->description) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label for="specification">@lang('site::product.specification')</label>
                                    <textarea
                                            class="summernote form-control{{ $errors->has('specification') ? ' is-invalid' : '' }}"
                                            placeholder="@lang('site::product.placeholder.specification')"
                                            name="specification"
                                            rows="5"
                                            id="specification">{!! old('specification', $product->specification) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('specification') }}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class=" border p-3 mt-2 mb-4 text-right">
            <button name="_stay" form="form-content" value="1" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save_stay')</span>
            </button>
            <button name="_stay" form="form-content" value="0" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('admin.products.show', $product) }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection
