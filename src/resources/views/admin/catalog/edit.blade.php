@extends('layouts.app')

@section('content')
    <div class="container" id="catalog-edit" xmlns:v-bind="http://www.w3.org/1999/xhtml">
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
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.catalogs.update', $catalog) }}">
                    @csrf
                    @method('PUT')
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('enabled', $catalog->enabled)) checked @endif
                        class="custom-control-input{{  $errors->has('enabled') ? ' is-invalid' : '' }}"
                               id="enabled" name="enabled">
                        <label class="custom-control-label" for="enabled">@lang('site::catalog.enabled')</label>
                        <span class="invalid-feedback">{{ $errors->first('enabled') }}</span>
                    </div>
                    {{--@if(is_null($catalog->catalog_id)) disabled @endif--}}
                    <fieldset >
                        <div class="form-group">
                            <label for="catalog_id">@lang('site::catalog.catalog_id')</label>
                            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="catalog_id" id="catalog_id">
                                <option value="">@lang('site::catalog.default.catalog_id')</option>
                                @include('site::admin.catalog.tree.edit', ['value' => $tree, 'level' => 0])
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
                                   value="{{ old('name', $catalog->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name_plural">@lang('site::catalog.name_plural')</label>
                            <input type="text" name="name_plural" id="name_plural" required
                                   class="form-control{{ $errors->has('name_plural') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name_plural')"
                                   value="{{ old('name_plural', $catalog->name_plural) }}">
                            <span class="invalid-feedback">{{ $errors->first('name_plural') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="description">@lang('site::catalog.description')</label>
                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::catalog.placeholder.description')"
                                      name="description"
                                      id="description">{{ old('description', $catalog->description) }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="form-content" type="submit" name="_stay" value="1"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save_stay')</span>
                    </button>
                    <button form="form-content" type="submit" name="_stay" value="0"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.catalogs.show', $catalog) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection