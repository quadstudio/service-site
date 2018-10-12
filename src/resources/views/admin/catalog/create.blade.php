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
        <h1 class="header-title mb-3">@lang('site::messages.add') @lang('site::catalog.catalog')</h1>
        <hr/>

        @alert()@endalert

        <div class="card mt-2 mb-2">
            <div class="card-body" id="summernote">

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

                        <div class="form-group">
                            <label class="control-label" for="catalog_id">@lang('site::catalog.catalog_id')</label>
                            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="catalog_id" id="catalog_id">
                                <option value="">@lang('site::catalog.default.catalog_id')</option>
                                @include('site::admin.catalog.tree.create', ['value' => $tree, 'level' => 0])
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('catalog_id') }}</span>
                        </div>
                    </fieldset>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::catalog.name')</label>
                            <input type="text" name="name" id="name" required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="name_plural">@lang('site::catalog.name_plural')</label>
                            <input type="text" name="name_plural" id="name_plural"
                                   class="form-control{{ $errors->has('name_plural') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::catalog.placeholder.name_plural')"
                                   value="{{ old('name_plural') }}">
                            <span class="invalid-feedback">{{ $errors->first('name_plural') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="description">@lang('site::catalog.description')</label>
                            <textarea class="summernote form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::catalog.placeholder.description')"
                                      name="description" id="description">{{ old('description') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class=" border p-3 mb-2">

            <button form="form-content" name="_create" value="1" type="submit"
                    class="btn btn-ferroli mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save_add')</span>
            </button>
            <button form="form-content" name="_create" value="0" type="submit"
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
@endsection