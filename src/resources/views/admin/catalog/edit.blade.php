@extends('layouts.app')

@section('content')
    <div class="container" id="catalog-edit" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('equipment::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.catalogs.index') }}">@lang('equipment::catalog.catalogs')</a>
            </li>
            @foreach($catalog->parentTree()->reverse() as $element)
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.catalogs.show', $element) }}">{{ $element->name }}</a>
                </li>
            @endforeach
            <li class="breadcrumb-item active">@lang('equipment::messages.edit')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">@lang('equipment::messages.edit') {{ $catalog->name }}</h1>
        <hr/>

        @alert()@endalert
        <div class="row justify-content-center mb-5">
            <div class="col">

                <form id="form-content" method="POST" action="{{ route('admin.catalogs.update', $catalog) }}">
                    @csrf
                    @method('PUT')
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('enabled', $catalog->enabled)) checked @endif
                        class="custom-control-input{{  $errors->has('enabled') ? ' is-invalid' : '' }}"
                               id="enabled" name="enabled">
                        <label class="custom-control-label" for="enabled">@lang('equipment::catalog.enabled')</label>
                        <span class="invalid-feedback">{{ $errors->first('enabled') }}</span>
                    </div>
                    <fieldset @if(is_null($catalog->catalog_id)) disabled @endif>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" @if(old('model', $catalog->model)) checked @endif
                            class="custom-control-input{{  $errors->has('model') ? ' is-invalid' : '' }}"
                                   id="model" name="model">
                            <label class="custom-control-label" for="model">@lang('equipment::catalog.model')</label>
                            <span class="invalid-feedback">{{ $errors->first('model') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="catalog_id">@lang('equipment::catalog.catalog_id')</label>
                            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="catalog_id" id="catalog_id">
                                <option value="">@lang('equipment::catalog.default.catalog_id')</option>
                                @include('equipment::admin.catalog.tree.edit', ['value' => $tree, 'level' => 0])
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('catalog_id') }}</span>
                        </div>
                    </fieldset>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name">@lang('equipment::catalog.name')</label>
                            <input type="text" name="name" id="name" required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('equipment::catalog.placeholder.name')"
                                   value="{{ old('name', $catalog->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name_plural">@lang('equipment::catalog.name_plural')</label>
                            <input type="text" name="name_plural" id="name_plural"
                                   class="form-control{{ $errors->has('name_plural') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('equipment::catalog.placeholder.name_plural')"
                                   value="{{ old('name_plural', $catalog->name_plural) }}">
                            <span class="invalid-feedback">{{ $errors->first('name_plural') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="description">@lang('equipment::catalog.description')</label>
                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('equipment::catalog.placeholder.description')"
                                      name="description"
                                      id="description">{{ old('description', $catalog->description) }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>


                </form>

                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('equipment::catalog_image.images')</h5>
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route('admin.catalog_images.store')}}">
                                @csrf
                                <div class="form-group form-control{{ $errors->has('image') ? ' is-invalid' : '' }}">
                                    <input type="file" name="path"/>
                                    <input type="button" class="btn btn-primary catalog-image-upload"
                                           value="@lang('equipment::messages.load')">

                                </div>
                                <span class="invalid-feedback">{{ $errors->first('image') }}</span>
                            </form>
                            <div class="d-flex flex-row bd-highlight">
                                @if( !$images->isEmpty())
                                    @foreach($images as $image)
                                        @include('equipment::admin.catalog.image')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="form-row">
                    <div class="col text-right">
                        <button form="form-content" name="_stay" value="1" type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            <span>@lang('equipment::messages.save_stay')</span>
                        </button>
                        <button form="form-content" name="_stay" value="0" type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            <span>@lang('equipment::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.catalogs.index') }}" class="btn btn-secondary">
                            <i class="fa fa-close"></i>
                            <span>@lang('equipment::messages.cancel')</span>
                        </a>
                    </div>

                </div>


            </div>
            <div class="col" v-bind:class="{'d-none': !isModel}"></div>
        </div>
    </div>
@endsection