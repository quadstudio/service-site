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
                <a href="{{ route('admin.equipments.index') }}">@lang('site::equipment.equipments')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::equipment.equipment')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.equipments.store') }}">
                    @csrf
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('enabled', true)) checked @endif
                        class="custom-control-input{{  $errors->has('enabled') ? ' is-invalid' : '' }}"
                               id="enabled"
                               name="enabled">
                        <label class="custom-control-label" for="enabled">@lang('site::equipment.enabled')</label>
                        <span class="invalid-feedback">{{ $errors->first('enabled') }}</span>
                    </div>

                    <div class="form-group required">
                        <label class="control-label" for="catalog_id">@lang('site::equipment.catalog_id')</label>
                        <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                name="catalog_id"
                                required
                                id="catalog_id">
                            <option value="">@lang('site::equipment.default.catalog_id')</option>
                            @include('site::admin.catalog.tree.create', ['value' => $tree, 'level' => 0])
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('catalog_id') }}</span>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::equipment.name')</label>
                            <input type="text" name="name"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::equipment.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="annotation">@lang('site::equipment.annotation')</label>
                            <textarea class="form-control{{ $errors->has('annotation') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::equipment.placeholder.annotation')"
                                      name="annotation" id="annotation">{{ old('annotation') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('annotation') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="description">@lang('site::equipment.description')</label>
                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::equipment.placeholder.description')"
                                      name="description" id="description">{{ old('description') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                </form>
                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::image.images')</h5>
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route('admin.images.store')}}">
                                @csrf
                                <div class="form-group form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                                    <input type="file" name="path"/>
                                    <input type="hidden" name="storage" value="equipments"/>
                                    <input type="button" class="btn btn-ferroli image-upload"
                                           value="@lang('site::messages.load')">

                                </div>
                                <span class="invalid-feedback">{{ $errors->first('path') }}</span>
                            </form>
                            <div class="d-flex flex-row bd-highlight">
                                @if( !$images->isEmpty())
                                    @foreach($images as $image)
                                        @include('site::admin.image.image')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>
                <hr />
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="form-content" value="1" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save_add')</span>
                        </button>
                        <button name="_create" form="form-content" value="0" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.equipments.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection