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
                            <div class="row">
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       @if(old('product.show_ferroli', $product->show_ferroli)) checked @endif
                                                       class="custom-control-input{{  $errors->has('product.show_ferroli') ? ' is-invalid' : '' }}"
                                                       id="show_ferroli"
                                                       name="product[show_ferroli]">
                                                <label class="custom-control-label"
                                                       for="show_ferroli">@lang('site::messages.show_ferroli')</label>
                                                <span class="invalid-feedback">{{ $errors->first('product.show_ferroli') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       @if(old('product.show_lamborghini', $product->show_lamborghini)) checked
                                                       @endif
                                                       class="custom-control-input{{  $errors->has('product.show_lamborghini') ? ' is-invalid' : '' }}"
                                                       id="show_lamborghini"
                                                       name="product[show_lamborghini]">
                                                <label class="custom-control-label"
                                                       for="show_lamborghini">@lang('site::messages.show_lamborghini')</label>
                                                <span class="invalid-feedback">{{ $errors->first('product.show_lamborghini') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-row required">
                                        <div class="col">
                                            <label class="control-label d-block"
                                                   for="enabled">@lang('site::product.enabled')</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.enabled') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[enabled]"
                                                       required
                                                       @if(old('product.enabled', $product->enabled) == 1) checked
                                                       @endif
                                                       id="enabled_1"
                                                       value="1">
                                                <label class="custom-control-label"
                                                       for="enabled_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.enabled') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[enabled]"
                                                       required
                                                       @if(old('product.enabled', $product->enabled) == 0) checked
                                                       @endif
                                                       id="enabled_0"
                                                       value="0">
                                                <label class="custom-control-label"
                                                       for="enabled_0">@lang('site::messages.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-row required">
                                        <div class="col">
                                            <label class="control-label d-block"
                                                   for="forsale">@lang('site::product.forsale')</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.forsale') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[forsale]"
                                                       required
                                                       @if(old('product.forsale', $product->forsale) == 1) checked
                                                       @endif
                                                       id="forsale_1"
                                                       value="1">
                                                <label class="custom-control-label"
                                                       for="forsale_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.forsale') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[forsale]"
                                                       required
                                                       @if(old('product.forsale', $product->forsale) == 0) checked
                                                       @endif
                                                       id="forsale_0"
                                                       value="0">
                                                <label class="custom-control-label"
                                                       for="forsale_0">@lang('site::messages.no')</label>
                                            </div>
                                        </div>
					@lang('site::product.forsale_help')
                                    </div>
								</div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-row required">
                                        <div class="col">
                                            <label class="control-label d-block"
                                                   for="for_preorder">@lang('site::product.for_preorder')</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.for_preorder') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[for_preorder]"
                                                       required
                                                       @if(old('product.for_preorder', $product->for_preorder) == 1) checked
                                                       @endif
                                                       id="for_preorder_1"
                                                       value="1">
                                                <label class="custom-control-label"
                                                       for="for_preorder_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.for_preorder') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[for_preorder]"
                                                       required
                                                       @if(old('product.for_preorder', $product->for_preorder) == 0) checked
                                                       @endif
                                                       id="for_preorder_0"
                                                       value="0">
                                                <label class="custom-control-label"
                                                       for="for_preorder_0">@lang('site::messages.no')</label>
                                            </div>
                                        </div>
					@lang('site::product.for_preorder_help')
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-row required">
                                        <div class="col">
                                            <label class="control-label d-block"
                                                   for="warranty">@lang('site::product.warranty')</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.warranty') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[warranty]"
                                                       required
                                                       @if(old('product.warranty', $product->warranty) == 1) checked
                                                       @endif
                                                       id="warranty_1"
                                                       value="1">
                                                <label class="custom-control-label"
                                                       for="warranty_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                    {{$errors->has('product.warranty') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[warranty]"
                                                       required
                                                       @if(old('product.warranty', $product->warranty) == 0) checked
                                                       @endif
                                                       id="warranty_0"
                                                       value="0">
                                                <label class="custom-control-label"
                                                       for="warranty_0">@lang('site::messages.no')</label>
                                            </div>
                                        </div>
					@lang('site::product.warranty_help')
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-row required">
                                        <div class="col">
                                            <label class="control-label d-block"
                                                   for="service">@lang('site::product.service')</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                        {{$errors->has('product.service') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[service]"
                                                       required
                                                       @if(old('product.service', $product->service) == 1) checked
                                                       @endif
                                                       id="service_1"
                                                       value="1">
                                                <label class="custom-control-label"
                                                       for="service_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input class="custom-control-input
                                                        {{$errors->has('product.service') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="product[service]"
                                                       required
                                                       @if(old('product.service', $product->service) == 0) checked
                                                       @endif
                                                       id="service_0"
                                                       value="0">
                                                <label class="custom-control-label"
                                                       for="service_0">@lang('site::messages.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-row required mt-3">
                                <div class="col">
                                    <label class="control-label text-big" for="name">@lang('site::product.name')</label>
                                    <input type="text"
                                           name="product[name]"
                                           id="name"
                                           required
                                           class="form-control form-control-lg {{ $errors->has('product.name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::product.placeholder.name')"
                                           value="{{ old('product.name', $product->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('product.name') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <label class="control-label"
                                               for="type_id">@lang('site::product.type_id')</label>
                                        <select required
                                                name="product[type_id]"
                                                class="form-control{{  $errors->has('product.type_id') ? ' is-invalid' : '' }}"
                                                id="type_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($product_types as $product_type)
                                                <option @if(old('product.type_id', $product->type_id) == $product_type->id) selected
                                                        @endif
                                                        value="{{ $product_type->id }}">{{ $product_type->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('product.type_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class="control-label"
                                                   for="equipment_id">@lang('site::product.equipment_id')</label>
                                            <select class="form-control
                                            {{$errors->has('product.equipment_id') ? ' is-invalid' : ''}}"
                                                    name="product[equipment_id]"
                                                    id="equipment_id">
                                                <option value="">@lang('site::messages.select_from_list')</option>
                                                @foreach($equipments as $equipment)
                                                    <option
                                                            @if(old('product.equipment_id', $product->equipment_id) == $equipment->id) selected
                                                            @endif
                                                            value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('product.equipment_id') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col">
                                            <label class="control-label" for="sku">@lang('site::product.sku')</label>
                                            <input type="text"
                                                   name="product[sku]"
                                                   id="sku"
                                                   required
                                                   class="form-control{{ $errors->has('product.sku') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.sku')"
                                                   value="{{ old('product.sku', $product->sku) }}">
                                            <span class="invalid-feedback">{{ $errors->first('product.sku') }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class="control-label"
                                                   for="old_sku">@lang('site::product.old_sku')</label>
                                            <input type="text"
                                                   name="product[old_sku]"
                                                   id="old_sku"
                                                   class="form-control{{ $errors->has('product.old_sku') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.old_sku')"
                                                   value="{{ old('product.old_sku', $product->old_sku) }}">
                                            <span class="invalid-feedback">{{ $errors->first('product.old_sku') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class="control-label" for="h1">@lang('site::product.h1')</label>
                                            <input type="text"
                                                   name="product[h1]"
                                                   id="h1"
                                                   class="form-control{{ $errors->has('product.h1') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.h1')"
                                                   value="{{ old('product.h1', $product->h1) }}">
                                            <span class="invalid-feedback">{{ $errors->first('product.h1') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class="control-label"
                                                   for="title">@lang('site::product.title')</label>
                                            <input type="text"
                                                   name="product[title]"
                                                   id="title"
                                                   class="form-control{{ $errors->has('product.title') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::product.placeholder.title')"
                                                   value="{{ old('product.title', $product->title) }}">
                                            <span class="invalid-feedback">{{ $errors->first('product.title') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-row">
                                <div class="col">
                                    <label for="metadescription">@lang('site::product.metadescription')</label>
                                    <textarea
                                            class="form-control{{ $errors->has('product.metadescription') ? ' is-invalid' : '' }}"
                                            placeholder="@lang('site::product.placeholder.metadescription')"
                                            name="product[metadescription]"
                                            rows="5"
                                            id="metadescription">{!! old('product.metadescription', $product->metadescription) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('product.metadescription') }}</span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col">
                                    <label for="description">@lang('site::product.description')</label>
                                    <textarea
                                            class="summernote form-control{{ $errors->has('product.description') ? ' is-invalid' : '' }}"
                                            placeholder="@lang('site::product.placeholder.description')"
                                            name="product[description]"
                                            rows="5"
                                            id="description">{!! old('product.description', $product->description) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('product.description') }}</span>
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label for="specification">@lang('site::product.specification')</label>
                                    <textarea
                                            class="summernote form-control{{ $errors->has('product.specification') ? ' is-invalid' : '' }}"
                                            placeholder="@lang('site::product.placeholder.specification')"
                                            name="product[specification]"
                                            rows="5"
                                            id="specification">{!! old('product.specification', $product->specification) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('product.specification') }}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class=" border p-3 mt-2 mb-4 text-right">
            <button form="form-content" type="submit" class="btn btn-ferroli">
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
