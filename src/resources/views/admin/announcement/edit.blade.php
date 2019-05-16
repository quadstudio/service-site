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
                <a href="{{ route('admin.announcements.index') }}">@lang('site::announcement.announcements')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.announcements.show', $announcement) }}">{{$announcement->title}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$announcement->title}}</h1>
        @alert()@endalert
        <div class="card">
            <div class="card-body" id="summernote">
                <form method="POST" id="form"
                      action="{{ route('admin.announcements.update', $announcement) }}">

                    @csrf

                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('announcement.show_ferroli', $announcement->show_ferroli)) checked @endif
                                               class="custom-control-input{{  $errors->has('announcement.show_ferroli') ? ' is-invalid' : '' }}"
                                               id="show_ferroli"
                                               name="announcement[show_ferroli]">
                                        <label class="custom-control-label"
                                               for="show_ferroli">@lang('site::messages.show_ferroli')</label>
                                        <span class="invalid-feedback">{{ $errors->first('announcement.show_ferroli') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('announcement.show_lamborghini', $announcement->show_lamborghini)) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('announcement.show_lamborghini') ? ' is-invalid' : '' }}"
                                               id="show_lamborghini"
                                               name="announcement[show_lamborghini]">
                                        <label class="custom-control-label"
                                               for="show_lamborghini">@lang('site::messages.show_lamborghini')</label>
                                        <span class="invalid-feedback">{{ $errors->first('announcement.show_lamborghini') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <div class="col">
                                    <label class="control-label"
                                           for="date">@lang('site::announcement.date')</label>
                                    <div class="input-group date datetimepicker" id="datetimepicker_date"
                                         data-target-input="nearest">
                                        <input type="text"
                                               name="announcement[date]"
                                               id="date"
                                               maxlength="10"
                                               required
                                               placeholder="@lang('site::announcement.placeholder.date')"
                                               data-target="#datetimepicker_date"
                                               data-toggle="datetimepicker"
                                               class="datetimepicker-input form-control{{ $errors->has('announcement.date') ? ' is-invalid' : '' }}"
                                               value="{{ old('announcement.date', $announcement->date->format('d.m.Y')) }}">
                                        <div class="input-group-append"
                                             data-target="#datetimepicker_date"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback">{{ $errors->first('announcement.date') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="title">@lang('site::announcement.title')</label>
                            <input type="text"
                                   name="announcement[title]"
                                   id="title"
                                   maxlength="64"
                                   required
                                   class="form-control{{ $errors->has('announcement.title') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::announcement.placeholder.title')"
                                   value="{{ old('announcement.title', $announcement->title) }}">
                            <span class="invalid-feedback">{{ $errors->first('announcement.title') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="annotation">@lang('site::announcement.annotation')</label>
                            <textarea
                                    class="form-control{{ $errors->has('announcement.annotation') ? ' is-invalid' : '' }}"
                                    placeholder="@lang('site::announcement.placeholder.annotation')"
                                    name="announcement[annotation]"
                                    maxlength="255"
                                    rows="5"
                                    required
                                    id="annotation">{!! old('announcement.annotation', $announcement->annotation) !!}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('announcement.annotation') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="description">@lang('site::announcement.description')</label>
                            <textarea
                                    class="summernote form-control{{ $errors->has('announcement.description') ? ' is-invalid' : '' }}"
                                    placeholder="@lang('site::announcement.placeholder.description')"
                                    name="announcement[description]"
                                    rows="5"
                                    id="description">{!! old('announcement.description', $announcement->description) !!}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('announcement.description') }}</span>
                        </div>
                    </div>
                </form>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-row mt-2">
                            <div class="col">
                                <label class="control-label" class="control-label"
                                       for="image_id">@lang('site::announcement.image_id')</label>

                                <form method="POST" enctype="multipart/form-data"
                                      action="{{route('admin.images.store')}}">
                                    @csrf
                                    <input type="hidden"
                                           name="storage"
                                           value="announcements"/>
                                    <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                           type="file"
                                           accept="{{config('site.announcement.accept')}}"
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

                <div class="form-row">
                    <div class="col text-right">
                        <button form="form" type="submit" class="btn btn-ferroli">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.announcements.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection
