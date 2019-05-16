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
                    <div class="card-body">
                        <form method="POST" id="form"
                              action="{{ route('admin.datasheets.update', $datasheet) }}">

                            @csrf

                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       @if(old('datasheet.show_ferroli', $datasheet->show_ferroli)) checked @endif
                                                       class="custom-control-input{{  $errors->has('datasheet.show_ferroli') ? ' is-invalid' : '' }}"
                                                       id="show_ferroli"
                                                       name="datasheet[show_ferroli]">
                                                <label class="custom-control-label"
                                                       for="show_ferroli">@lang('site::messages.show_ferroli')</label>
                                                <span class="invalid-feedback">{{ $errors->first('datasheet.show_ferroli') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       @if(old('datasheet.show_lamborghini', $datasheet->show_lamborghini)) checked
                                                       @endif
                                                       class="custom-control-input{{  $errors->has('datasheet.show_lamborghini') ? ' is-invalid' : '' }}"
                                                       id="show_lamborghini"
                                                       name="datasheet[show_lamborghini]">
                                                <label class="custom-control-label"
                                                       for="show_lamborghini">@lang('site::messages.show_lamborghini')</label>
                                                <span class="invalid-feedback">{{ $errors->first('datasheet.show_lamborghini') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       @if(old('datasheet.active', $datasheet->active)) checked
                                                       @endif
                                                       class="custom-control-input{{  $errors->has('datasheet.active') ? ' is-invalid' : '' }}"
                                                       id="active"
                                                       name="datasheet[active]">
                                                <label class="custom-control-label"
                                                       for="active">@lang('site::datasheet.active')</label>
                                                <span class="invalid-feedback">{{ $errors->first('datasheet.active') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row required mt-3">
                                <div class="col">
                                    <label class="control-label" for="name">@lang('site::datasheet.name')</label>
                                    <input type="text"
                                           name="datasheet[name]"
                                           id="name"
                                           required
                                           class="form-control{{ $errors->has('datasheet.name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::datasheet.placeholder.name')"
                                           value="{{ old('datasheet.name', $datasheet->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('datasheet.name') }}</span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="type_id">
                                        @lang('site::datasheet.type_id')
                                    </label>
                                    <select class="form-control {{$errors->has('datasheet.type_id') ? ' is-invalid' : ''}}"
                                            required
                                            name="datasheet[type_id]"
                                            id="type_id">
                                        @foreach($types as $type)
                                            <option
                                                    @if(old('datasheet.type_id', $datasheet->file->type_id) == $type->id) selected
                                                    @endif
                                                    value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('datasheet.type_id') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="date_from">@lang('site::datasheet.date_from')</label>
                                        <div class="input-group date datetimepicker" id="datetimepicker_date_from"
                                             data-target-input="nearest">
                                            <input type="text"
                                                   name="datasheet[date_from]"
                                                   id="date_from"
                                                   maxlength="10"
                                                   placeholder="@lang('site::datasheet.placeholder.date_from')"
                                                   data-target="#datetimepicker_date_from"
                                                   data-toggle="datetimepicker"
                                                   class="datetimepicker-input form-control{{ $errors->has('datasheet.date_from') ? ' is-invalid' : '' }}"
                                                   value="{{ old('datasheet.date_from', optional($datasheet->date_from)->format('d.m.Y')) }}">
                                            <div class="input-group-append"
                                                 data-target="#datetimepicker_date_from"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('datasheet.date_from') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="date_to">@lang('site::datasheet.date_to')</label>
                                        <div class="input-group date datetimepicker" id="datetimepicker_date_to"
                                             data-target-input="nearest">
                                            <input type="text"
                                                   name="datasheet[date_to]"
                                                   id="date_to"
                                                   maxlength="10"
                                                   placeholder="@lang('site::datasheet.placeholder.date_to')"
                                                   data-target="#datetimepicker_date_to"
                                                   data-toggle="datetimepicker"
                                                   class="datetimepicker-input form-control{{ $errors->has('datasheet.date_to') ? ' is-invalid' : '' }}"
                                                   value="{{ old('datasheet.date_to', optional($datasheet->date_to)->format('d.m.Y')) }}">
                                            <div class="input-group-append"
                                                 data-target="#datetimepicker_date_to"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('datasheet.date_to') }}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col">
                                    <label class="control-label" for="tags">@lang('site::datasheet.tags')</label>
                                    <textarea class="form-control{{ $errors->has('datasheet.tags') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::datasheet.placeholder.tags')"
                                              name="datasheet[tags]"
                                              id="tags">{!! old('datasheet.tags', $datasheet->tags) !!}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('datasheet.tags') }}</span>
                                </div>
                            </div>
                        </form>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-row mt-2">
                                    <div class="col">
                                        <label class="control-label" class="control-label"
                                               for="file_id">@lang('site::datasheet.file_id')</label>

                                        <form method="POST" enctype="multipart/form-data"
                                              action="{{route('admin.files.store')}}">
                                            @csrf
                                            <input type="hidden"
                                                   name="type_id"
                                                   value="{{$datasheet->file->type_id}}"/>
                                            <input type="hidden"
                                                   name="storage"
                                                   value="datasheets"/>
                                            <input class="d-inline-block form-control-file{{ $errors->has('file_id') ? ' is-invalid' : '' }}"
                                                   type="file"
                                                   accept="{{config('site.datasheets.accept')}}"
                                                   name="path"/>

                                            <input type="button" class="btn btn-ferroli file-upload-button"
                                                   value="@lang('site::messages.load')"/>
                                            <span class="invalid-feedback">{{ $errors->first('file_id') }}</span>
                                        </form>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="files" class="row bg-white">
                                    @include('site::admin.file.edit')
                                </div>
                            </div>
                        </div>

                        <hr/>
                        <div class=" text-right">
                            <button form="form" type="submit"
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
