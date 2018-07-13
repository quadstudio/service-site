@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.catalogs.index') }}">@lang('site::catalog.catalogs')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add') @lang('site::catalog.catalog')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">@lang('site::messages.add') @lang('site::catalog.catalog')</h1>
        <hr/>

        @alert()@endalert

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">

                <form id="form-content" method="POST" action="{{ route('admin.catalogs.store') }}">
                    @csrf
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('enabled', true)) checked @endif
                        class="custom-control-input{{  $errors->has('enabled') ? ' is-invalid' : '' }}"
                               id="enabled" name="enabled">
                        <label class="custom-control-label" for="enabled">@lang('site::catalog.enabled')</label>
                        <span class="invalid-feedback">{{ $errors->first('enabled') }}</span>
                    </div>
                    <fieldset @if(is_null($parent_catalog_id)) disabled @endif>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" @if(old('model', false)) checked @endif
                            class="custom-control-input{{  $errors->has('model') ? ' is-invalid' : '' }}"
                                   id="model" name="model">
                            <label class="custom-control-label" for="model">@lang('site::catalog.model')</label>
                            <span class="invalid-feedback">{{ $errors->first('model') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="catalog_id">@lang('site::catalog.catalog_id')</label>
                            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="catalog_id" id="catalog_id">
                                <option value="">@lang('site::catalog.default.catalog_id')</option>
                                @include('site::admin.catalog.tree.create', ['value' => $tree, 'level' => 0])
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('catalog_id') }}</span>
                        </div>
                    </fieldset>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name">@lang('site::catalog.name')</label>
                            <input type="text" name="name" id="name" required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name_plural">@lang('site::catalog.name_plural')</label>
                            <input type="text" name="name_plural" id="name_plural"
                                   class="form-control{{ $errors->has('name_plural') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name_plural')"
                                   value="{{ old('name_plural') }}">
                            <span class="invalid-feedback">{{ $errors->first('name_plural') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="description">@lang('site::catalog.description')</label>
                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::catalog.placeholder.description')"
                                      name="description" id="description">{{ old('description') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                </form>
                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::catalog_image.images')</h5>
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route('admin.catalog_images.store')}}">
                                @csrf
                                <div class="form-group form-control{{ $errors->has('image') ? ' is-invalid' : '' }}">
                                    <input type="file" name="path"/>
                                    <input type="button" class="btn btn-primary catalog-image-upload"
                                           value="@lang('site::messages.load')">

                                </div>
                                <span class="invalid-feedback">{{ $errors->first('image') }}</span>
                            </form>
                            <div class="d-flex flex-row bd-highlight">
                                @if( !$images->isEmpty())
                                    @foreach($images as $image)
                                        @include('site::admin.catalog.image')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="form-content" value="1" type="submit" class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save_add')</span>
                        </button>
                        <button name="_create" form="form-content" value="0" type="submit" class="btn btn-primary mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.catalogs.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection