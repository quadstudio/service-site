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
                <a href="{{ route('admin.catalogs.index') }}">@lang('site::catalog.catalogs')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add') @lang('site::catalog.catalog')</li>
        </ol>
        <h1 class="header-title mb-3">@lang('site::messages.add') @lang('site::catalog.catalog')</h1>
        <hr/>

        @alert()@endalert

        <div class="card mt-2 mb-2">
            <div class="card-body" id="summernote">

                <form id="form" method="POST" action="{{ route('admin.catalogs.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('catalog.show_ferroli')) checked @endif
                                               class="custom-control-input{{  $errors->has('catalog.show_ferroli') ? ' is-invalid' : '' }}"
                                               id="show_ferroli"
                                               name="catalog[show_ferroli]">
                                        <label class="custom-control-label"
                                               for="show_ferroli">@lang('site::messages.show_ferroli')</label>
                                        <span class="invalid-feedback">{{ $errors->first('catalog.show_ferroli') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('catalog.show_lamborghini')) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('catalog.show_lamborghini') ? ' is-invalid' : '' }}"
                                               id="show_lamborghini"
                                               name="catalog[show_lamborghini]">
                                        <label class="custom-control-label"
                                               for="show_lamborghini">@lang('site::messages.show_lamborghini')</label>
                                        <span class="invalid-feedback">{{ $errors->first('catalog.show_lamborghini') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('catalog.enabled')) checked @endif
                                               class="custom-control-input{{  $errors->has('catalog.enabled') ? ' is-invalid' : '' }}"
                                               id="enabled"
                                               name="catalog[enabled]">
                                        <label class="custom-control-label"
                                               for="enabled">@lang('site::catalog.enabled')</label>
                                        <span class="invalid-feedback">{{ $errors->first('catalog.enabled') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('catalog.mounter_enabled')) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('catalog.mounter_enabled') ? ' is-invalid' : '' }}"
                                               id="mounter_enabled"
                                               name="catalog[mounter_enabled]">
                                        <label class="custom-control-label"
                                               for="mounter_enabled">@lang('site::catalog.mounter_enabled')</label>
                                        <span class="invalid-feedback">{{ $errors->first('catalog.mounter_enabled') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <fieldset @if(is_null($parent_catalog_id)) disabled @endif>
                        <div class="form-row">
                            <div class="col">
                                <label class="control-label"
                                       for="catalog_id">@lang('site::catalog.catalog_id')</label>
                                <select class="form-control{{  $errors->has('catalog.catalog_id') ? ' is-invalid' : '' }}"
                                        name="catalog[catalog_id]"
                                        id="catalog_id">
                                    <option value="">@lang('site::catalog.default.catalog_id')</option>
                                    @include('site::admin.catalog.tree.create', ['value' => $tree, 'level' => 0])
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('catalog.catalog_id') }}</span>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="name">@lang('site::catalog.name')</label>
                            <input required
                                   type="text"
                                   name="catalog[name]"
                                   id="name"
                                   class="form-control{{ $errors->has('catalog.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name')"
                                   value="{{ old('catalog.name') }}">
                            <span class="invalid-feedback">{{ $errors->first('catalog.name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label class="control-label" for="name_plural">@lang('site::catalog.name_plural')</label>
                            <input type="text"
                                   name="catalog[name_plural]"
                                   id="name_plural"
                                   class="form-control{{ $errors->has('catalog.name_plural') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name_plural')"
                                   value="{{ old('catalog.name_plural') }}">
                            <span class="invalid-feedback">{{ $errors->first('catalog.name_plural') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label class="control-label" for="h1">@lang('site::catalog.h1')</label>
                            <input type="text"
                                   name="catalog[h1]"
                                   id="h1"
                                   class="form-control{{ $errors->has('catalog.h1') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.h1')"
                                   value="{{ old('catalog.h1') }}">
                            <span class="invalid-feedback">{{ $errors->first('catalog.h1') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label class="control-label" for="title">@lang('site::catalog.title')</label>
                            <input type="text"
                                   name="catalog[title]"
                                   id="title"
                                   class="form-control{{ $errors->has('catalog.title') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.title')"
                                   value="{{ old('catalog.title') }}">
                            <span class="invalid-feedback">{{ $errors->first('catalog.title') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label class="control-label"
                                   for="metadescription">@lang('site::catalog.metadescription')</label>
                            <input type="text"
                                   name="catalog[metadescription]"
                                   id="metadescription"
                                   class="form-control{{ $errors->has('catalog.metadescription') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.metadescription')"
                                   value="{{ old('catalog.metadescription') }}">
                            <span class="invalid-feedback">{{ $errors->first('catalog.metadescription') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label class="control-label" for="description">@lang('site::catalog.description')</label>
                            <textarea
                                    class="summernote form-control{{ $errors->has('catalog.description') ? ' is-invalid' : '' }}"
                                    placeholder="@lang('site::catalog.placeholder.description')"
                                    name="catalog[description]"
                                    id="description">{{ old('catalog.description') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('catalog.description') }}</span>
                        </div>
                    </div>
                </form>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-row mt-2">
                            <div class="col">
                                <label class="control-label" class="control-label"
                                       for="image_id">@lang('site::catalog.image_id')</label>

                                <form method="POST" enctype="multipart/form-data"
                                      action="{{route('admin.images.store')}}">
                                    @csrf
                                    <input type="hidden"
                                           name="storage"
                                           value="catalogs"/>
                                    <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                           type="file"
                                           accept="{{config('site.catalogs.accept')}}"
                                           name="path"/>

                                    <input type="button" class="btn btn-ferroli image-upload-button"
                                           value="@lang('site::messages.load')"/>
                                    <span class="invalid-feedback">{{ $errors->first('image_id') }}</span>
                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="images" class="row bg-white">
                            @include('site::admin.image.edit')
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="mb-2 text-right">
                    <button form="form" type="submit"
                            class="btn btn-ferroli mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.catalogs.index') }}" class="d-block d-sm-inline btn btn-secondary">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection