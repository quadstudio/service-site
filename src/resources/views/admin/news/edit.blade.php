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
                <a href="{{ route('admin.news.index') }}">@lang('site::news.news')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.news.show', $item) }}">{{$item->title}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$item->title}}</h1>
        @alert()@endalert
        <div class="card">
            <div class="card-body" id="summernote">
                <form method="POST" id="form-content"
                      action="{{ route('admin.news.update', $item) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="title">@lang('site::news.title')</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   maxlength="64"
                                   required
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::news.placeholder.title')"
                                   value="{{ old('title', $item->title) }}">
                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="annotation">@lang('site::news.annotation')</label>
                            <textarea
                                    class="form-control{{ $errors->has('annotation') ? ' is-invalid' : '' }}"
                                    placeholder="@lang('site::news.placeholder.annotation')"
                                    name="annotation"
                                    maxlength="255"
                                    rows="5"
                                    required
                                    id="annotation">{!! old('annotation', $item->annotation) !!}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('annotation') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="description">@lang('site::news.description')</label>
                            <textarea
                                    class="summernote form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    placeholder="@lang('site::news.placeholder.description')"
                                    name="description"
                                    rows="5"
                                    id="description">{!! old('description', $item->description) !!}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>

                    <div class="form-group required col-sm-2">
                        <label class="control-label"
                               for="date">@lang('site::news.date')</label>
                        <div class="input-group date datetimepicker" id="datetimepicker_date"
                             data-target-input="nearest">
                            <input type="text"
                                   name="date"
                                   id="date"
                                   maxlength="10"
                                   required
                                   placeholder="@lang('site::news.placeholder.date')"
                                   data-target="#datetimepicker_date"
                                   data-toggle="datetimepicker"
                                   class="datetimepicker-input form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                   value="{{ old('date', $item->date()) }}">
                            <div class="input-group-append"
                                 data-target="#datetimepicker_date"
                                 data-toggle="datetimepicker">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <span class="invalid-feedback">{{ $errors->first('date') }}</span>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label d-block"
                                   for="active">@lang('site::news.published')</label>
                            <div class="custom-control custom-radio  custom-control-inline">
                                <input class="custom-control-input
                                                    {{$errors->has('published') ? ' is-invalid' : ''}}"
                                       type="radio"
                                       name="published"
                                       required
                                       @if(old('published', 1) == 1) checked @endif
                                       id="published_1"
                                       value="1">
                                <label class="custom-control-label"
                                       for="published_1">@lang('site::messages.yes')</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input
                                                    {{$errors->has('published') ? ' is-invalid' : ''}}"
                                       type="radio"
                                       name="published"
                                       required
                                       @if(old('published', 1) == 0) checked @endif
                                       id="published_0"
                                       value="0">
                                <label class="custom-control-label"
                                       for="published_0">@lang('site::messages.no')</label>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="image_id">@lang('site::news.image_id')</label>

                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route('admin.news.image')}}">
                                @csrf
                                <input type="hidden" name="storage" value="news"/>
                                <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                       type="file"
                                       name="path"/>

                                <input type="button" class="btn btn-ferroli image-upload-button"
                                       value="@lang('site::messages.load')"/>
                                <span class="invalid-feedback">{{ $errors->first('image_id') }}</span>
                                <small class="mb-4 form-text text-success">
                                    @lang('site::news.help.image_id')
                                </small>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="image-src" class="bg-light"
                             style="width: {{config('site.news.size.image.width', 300)}}px;height: {{config('site.news.size.image.height', 200)}}px;">
                            @include('site::admin.image.field', ['image'   => $item->image])
                        </div>
                    </div>
                </div>

                <hr/>

                <div class="form-row">
                    <div class="col text-right">
                        <button name="_stay" form="form-content" value="1" type="submit" class="btn btn-ferroli">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save_stay')</span>
                        </button>
                        <button name="_stay" form="form-content" value="0" type="submit" class="btn btn-ferroli">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="d-block d-sm-inline btn btn-secondary">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection
