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
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::datasheet.datasheet')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body" id="summernote">
                <form id="form-content" method="POST" action="{{ route('admin.datasheets.store') }}">
                    @csrf

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::datasheet.name')</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::datasheet.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="type_id">@lang('site::datasheet.type_id')</label>
                            <select class="form-control
                                            {{$errors->has('type_id') ? ' is-invalid' : ''}}"
                                    required
                                    name="type_id"
                                    id="type_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}"
                                            @if(old('type_id') == $type->id) selected @endif >
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
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
                                       @if(old('active', 1) == 1) checked @endif
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
                                       @if(old('active', 1) == 0) checked @endif
                                       id="active_0"
                                       value="0">
                                <label class="custom-control-label"
                                       for="active_0">@lang('site::messages.no')</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"
                                       for="date_from">@lang('site::datasheet.date_from_to') @lang('site::datasheet.date_from')</label>
                                <input type="date" name="date_from" id="date_from"
                                       class="form-control{{ $errors->has('date_from') ? ' is-invalid' : '' }}"
                                       value="{{ old('date_from') }}">
                                <span class="invalid-feedback">{{ $errors->first('date_from') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"
                                       for="date_to">@lang('site::datasheet.date_from_to') @lang('site::datasheet.date_to')</label>
                                <input type="date" name="date_to" id="date_to"
                                       class="form-control{{ $errors->has('date_to') ? ' is-invalid' : '' }}"
                                       value="{{ old('date_to') }}">
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
                                      id="tags">{!! old('tags') !!}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('tags') }}</span>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-8">
                        <form method="POST" data-preview="#file-preview" enctype="multipart/form-data"
                              action="{{route('admin.datasheets.file')}}">
                            @csrf
                            <input type="hidden" name="storage" value="datasheets"/>
                            <input type="hidden" name="type_id" value="4"/>

                            <div class="form-group required">
                                <label class="control-label"
                                       for="file_id">@lang('site::datasheet.file_id')</label>

                                <input class="d-inline-block form-control-file {{ $errors->has('file_id') ? ' is-invalid' : '' }}"
                                       type="file"
                                       required
                                       accept="application/pdf"
                                       id="file_id"
                                       name="path"/>
                                <span class="invalid-feedback">{{ $errors->first('file_id') }}</span>
                            </div>

                            <input type="button" class="btn btn-ferroli file-upload-button"
                                   value="@lang('site::messages.load')"/>

                        </form>
                    </div>
                    <div class="col-md-4 bg-light text-center" id="file-preview">
                        @include('site::admin.file.preview', ['file' => $file])
                    </div>
                </div>

                <hr/>
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
                        <a href="{{ route('admin.datasheets.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection