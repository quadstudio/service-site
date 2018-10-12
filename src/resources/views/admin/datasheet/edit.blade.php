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
                <a href="{{ route('admin.datasheets.index') }}">@lang('site::datasheet.datasheets')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.datasheets.show', $datasheet) }}">{{$datasheet->name ?: $datasheet->file->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$datasheet->name ?: $datasheet->file->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="summernote">
                        <form method="POST" id="form-content"
                              action="{{ route('admin.datasheets.update', $datasheet) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::datasheet.name')</label>
                                    <input type="text" name="name"
                                           id="name"
                                           required
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::datasheet.placeholder.name')"
                                           value="{{ old('name', $datasheet->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="type_id">@lang('site::datasheet.type_id')</label>
                                    <select class="form-control {{$errors->has('type_id') ? ' is-invalid' : ''}}"
                                            required
                                            name="type_id"
                                            id="type_id">
                                        @foreach($types as $type)
                                            <option
                                                    @if(old('type_id', $datasheet->file->type_id) == $type->id) selected
                                                    @endif
                                                    value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('type_id') }}</strong>
                                        </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="active">@lang('site::datasheet.active')</label>
                                    <div class="custom-control custom-radio  custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('active') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="active"
                                               required
                                               @if(old('active', $datasheet->active) == 1) checked @endif
                                               id="active_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="active_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('active') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="active"
                                               required
                                               @if(old('active', $datasheet->active) == 0) checked @endif
                                               id="active_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="active_0">@lang('site::messages.no')</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="date_from">@lang('site::datasheet.date_from_to') @lang('site::datasheet.date_from')</label>
                                        <input type="date" name="date_from" id="date_from"
                                               class="form-control{{ $errors->has('date_from') ? ' is-invalid' : '' }}"
                                               value="{{ old('date_from', $datasheet->date_from) }}">
                                        <span class="invalid-feedback">{{ $errors->first('date_from') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="date_to">@lang('site::datasheet.date_from_to') @lang('site::datasheet.date_to')</label>
                                        <input type="date" name="date_to" id="date_to"
                                               class="form-control{{ $errors->has('date_to') ? ' is-invalid' : '' }}"
                                               value="{{ old('date_to', $datasheet->date_to) }}">
                                        <span class="invalid-feedback">{{ $errors->first('date_to') }}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label" for="tags">@lang('site::datasheet.tags')</label>
                                    <textarea class="summernote form-control{{ $errors->has('tags') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::datasheet.placeholder.tags')"
                                              name="tags"
                                              id="tags">{!! old('tags', $datasheet->tags) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('tags') }}</span>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-8">
                                <form method="POST" enctype="multipart/form-data"
                                      data-preview="#file-preview"
                                      action="{{route('admin.datasheets.file')}}">
                                    @csrf
                                    <input type="hidden" name="storage" value="datasheets"/>
                                    <input type="hidden" name="type_id" value="{{$file->type_id}}"/>

                                    <div class="form-group required">
                                        <label class="control-label"
                                               for="image_id">@lang('site::datasheet.file_id')</label>

                                        <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                               accept="application/pdf"
                                               type="file"
                                               name="path"/>

                                    </div>

                                    <input type="button" class="btn btn-ferroli file-upload-button"
                                           value="@lang('site::messages.load')"/>
                                    <span class="invalid-feedback">{{ $errors->first('image_id') }}</span>
                                </form>
                            </div>
                            <div class="col-md-4 bg-light " id="file-preview">
                                @include('site::admin.file.preview', ['file' => $datasheet->file])
                            </div>
                        </div>

                        <hr/>
                        <div class=" text-right">
                            <button name="_stay" form="form-content" value="1" type="submit"
                                    class="btn btn-ferroli">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save_stay')</span>
                            </button>
                            <button name="_stay" form="form-content" value="0" type="submit"
                                    class="btn btn-ferroli">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save')</span>
                            </button>
                            <a href="{{ route('admin.datasheets.show', $datasheet) }}"
                               class="d-block d-sm-inline btn btn-secondary">
                                <i class="fa fa-close"></i>
                                <span>@lang('site::messages.cancel')</span>
                            </a>
                        </div>


                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
