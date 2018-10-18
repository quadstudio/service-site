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
            <li class="breadcrumb-item active">{{$equipment->name}}</li>
        </ol>
        <h1 class="header-title mb-4">{{$equipment->name}}</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body" id="summernote">

                <form id="form-content" method="POST" action="{{ route('admin.equipments.update', $equipment) }}">
                    @csrf
                    @method('PUT')
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('enabled', $equipment->enabled)) checked @endif
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
                            @include('site::admin.equipment.tree.edit', ['value' => $tree, 'level' => 0])
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
                                   value="{{ old('name', $equipment->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="h1">@lang('site::equipment.h1')</label>
                            <input type="text" name="h1"
                                   id="h1"
                                   class="form-control{{ $errors->has('h1') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::equipment.placeholder.h1')"
                                   value="{{ old('h1', $equipment->h1) }}">
                            <span class="invalid-feedback">{{ $errors->first('h1') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="title">@lang('site::equipment.title')</label>
                            <input type="text" name="title"
                                   id="title"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::equipment.placeholder.title')"
                                   value="{{ old('title', $equipment->title) }}">
                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="metadescription">@lang('site::equipment.metadescription')</label>
                            <textarea
                                    class="form-control{{ $errors->has('metadescription') ? ' is-invalid' : '' }}"
                                    placeholder="@lang('site::equipment.placeholder.metadescription')"
                                    name="metadescription"
                                    rows="5"
                                    id="metadescription">{!! old('metadescription', $equipment->metadescription) !!}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('metadescription') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="annotation">@lang('site::equipment.annotation')</label>
                            <input type="text" name="annotation"
                                   id="annotation"
                                   class="form-control{{ $errors->has('annotation') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::equipment.placeholder.annotation')"
                                   value="{{ old('annotation', $equipment->annotation) }}">
                            <span class="invalid-feedback">{{ $errors->first('annotation') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="description">@lang('site::equipment.description')</label>
                            <textarea class="summernote form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::equipment.placeholder.description')"
                                      name="description"
                                      id="description">{{ old('description', $equipment->description) }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="specification">@lang('site::equipment.specification')</label>
                            <textarea class="summernote form-control{{ $errors->has('specification') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::equipment.placeholder.specification')"
                                      name="specification"
                                      id="specification">{{ old('specification', $equipment->specification) }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('specification') }}</span>
                        </div>
                    </div>
                </form>
                {{--<div class="card mt-2 mb-2">--}}
                    {{--<div class="card-body">--}}
                        {{--<h5 class="card-title">@lang('site::image.images')</h5>--}}
                        {{--<form method="POST" enctype="multipart/form-data"--}}
                              {{--action="{{route('admin.images.store')}}">--}}
                            {{--@csrf--}}
                            {{--<div class="form-group form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">--}}
                                {{--<input type="file" name="path"/>--}}
                                {{--<input type="hidden" name="storage" value="equipments"/>--}}
                                {{--<input type="button" class="btn btn-ferroli image-upload"--}}
                                       {{--value="@lang('site::messages.load')">--}}

                            {{--</div>--}}
                            {{--<span class="invalid-feedback">{{ $errors->first('path') }}</span>--}}
                        {{--</form>--}}
                        {{--<div class="d-flex flex-row bd-highlight">--}}
                            {{--@if( !$images->isEmpty())--}}
                                {{--@foreach($images as $image)--}}
                                    {{--@include('site::admin.image.image')--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
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
                    <a href="{{ route('admin.equipments.show', $equipment) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection