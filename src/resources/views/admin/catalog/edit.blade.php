@extends('layouts.app')

@section('content')
    <div class="container" id="catalog-edit">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.catalogs.index') }}">@lang('site::catalog.catalogs')</a>
            </li>
            @foreach($catalog->parentTree()->reverse() as $element)
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.catalogs.show', $element) }}">{{ $element->name }}</a>
                </li>
            @endforeach
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{ $catalog->name }}</h1>

        @alert()@endalert
        <div class="card mt-2 mb-2">
            <div class="card-body" id="summernote">

                <form id="form" method="POST" action="{{ route('admin.catalogs.update', $catalog) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="col">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox"
                                       @if(old('catalog.enabled', $catalog->enabled)) checked @endif
                                       class="custom-control-input{{  $errors->has('catalog.enabled') ? ' is-invalid' : '' }}"
                                       id="enabled"
                                       value="1"
                                       name="catalog[enabled]">
                                <label class="custom-control-label" for="enabled">@lang('site::catalog.enabled')</label>
                                <span class="invalid-feedback">{{ $errors->first('catalog.enabled') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="name">@lang('site::catalog.name')</label>
                            <input required
                                   type="text"
                                   name="catalog[name]"
                                   id="name"
                                   class="form-control{{ $errors->has('catalog.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name')"
                                   value="{{ old('catalog.name', $catalog->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('catalog.name') }}</span>
                        </div>
                    </div>
                    <div class="form-row ">
                        <div class="col">
                            <label class="control-label" for="name_plural">@lang('site::catalog.name_plural')</label>
                            <input required
                                   type="text"
                                   name="catalog[name_plural]"
                                   id="name_plural"
                                   class="form-control{{ $errors->has('catalog.name_plural') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name_plural')"
                                   value="{{ old('catalog.name_plural', $catalog->name_plural) }}">
                            <span class="invalid-feedback">{{ $errors->first('catalog.name_plural') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label class="control-label" for="catalog_id">@lang('site::catalog.catalog_id')</label>
                            <select class="form-control{{  $errors->has('catalog.catalog_id') ? ' is-invalid' : '' }}"
                                    name="catalog[catalog_id]"
                                    id="catalog_id">
                                <option value="">@lang('site::catalog.default.catalog_id')</option>
                                @include('site::admin.catalog.tree.edit', ['value' => $tree, 'level' => 0, 'disabled' => $catalog->id])
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('catalog.catalog_id') }}</span>
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
                                   value="{{ old('catalog.h1', $catalog->h1) }}">
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
                                   value="{{ old('catalog.title', $catalog->title) }}">
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
                                   value="{{ old('catalog.metadescription', $catalog->metadescription) }}">
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
                                    id="description">{{ old('catalog.description', $catalog->description) }}</textarea>
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
                                      action="{{route('admin.catalogs.image')}}">
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
                    <button form="form"
                            type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.catalogs.show', $catalog) }}"
                       class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection