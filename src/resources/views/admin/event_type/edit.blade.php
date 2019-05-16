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
                <a href="{{ route('admin.event_types.index') }}">@lang('site::event_type.event_types')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.event_types.show', $event_type) }}">{{$event_type->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$event_type->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="form"
                              action="{{ route('admin.event_types.update', $event_type) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('event_type.show_ferroli', $event_type->show_ferroli)) checked @endif
                                               class="custom-control-input{{  $errors->has('event_type.show_ferroli') ? ' is-invalid' : '' }}"
                                               id="show_ferroli"
                                               name="event_type[show_ferroli]">
                                        <label class="custom-control-label"
                                               for="show_ferroli">@lang('site::messages.show_ferroli')</label>
                                        <span class="invalid-feedback">{{ $errors->first('event_type.show_ferroli') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('event_type.show_lamborghini', $event_type->show_lamborghini)) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('event_type.show_lamborghini') ? ' is-invalid' : '' }}"
                                               id="show_lamborghini"
                                               name="event_type[show_lamborghini]">
                                        <label class="custom-control-label"
                                               for="show_lamborghini">@lang('site::messages.show_lamborghini')</label>
                                        <span class="invalid-feedback">{{ $errors->first('event_type.show_lamborghini') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row required mt-3">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::event_type.name')</label>
                                    <input required
                                           type="text"
                                           name="event_type[name]"
                                           id="name"
                                           maxlength="64"
                                           class="form-control{{ $errors->has('event_type.name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::event_type.placeholder.name')"
                                           value="{{ old('event_type.name', $event_type->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('event_type.name') }}</span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="annotation">@lang('site::event_type.annotation')</label>
                                    <textarea required
                                              class="form-control{{ $errors->has('event_type.annotation') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::event_type.placeholder.annotation')"
                                              name="event_type[annotation]"
                                              id="annotation">{{ old('event_type.annotation', $event_type->annotation) }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('event_type.annotation') }}</span>
                                </div>
                            </div>

                        </form>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-row mt-2">
                                    <div class="col">
                                        <label class="control-label" class="control-label"
                                               for="image_id">@lang('site::event_type.image_id')</label>

                                        <form method="POST" enctype="multipart/form-data"
                                              action="{{route('admin.images.store')}}">
                                            @csrf
                                            <input type="hidden"
                                                   name="storage"
                                                   value="event_types"/>
                                            <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                                   type="file"
                                                   accept="{{config('site.event_types.accept')}}"
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
                        <div class=" text-right">
                            <button form="form" type="submit"
                                    class="btn btn-ferroli">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save')</span>
                            </button>
                            <a href="{{ route('admin.event_types.show', $event_type) }}"
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
