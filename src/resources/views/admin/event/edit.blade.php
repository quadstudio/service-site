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
                <a href="{{ route('admin.events.index') }}">@lang('site::event.events')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.events.show', $event) }}">{{$event->title}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$event->title}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="form-content"
                              action="{{ route('admin.events.update', $event) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="title">@lang('site::event.title')</label>
                                    <input type="text" name="title"
                                           id="title"
                                           required
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::event.placeholder.title')"
                                           value="{{ old('title', $event->title) }}">
                                    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="annotation">@lang('site::event.annotation')</label>
                                    <textarea class="form-control{{ $errors->has('annotation') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::event.placeholder.annotation')"
                                              required
                                              name="annotation" id="annotation">{{ old('annotation', $event->annotation) }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('annotation') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3 required">

                                            <label class="control-label" for="type_id">@lang('site::event.type_id')</label>
                                            <select class="form-control{{  $errors->has('type_id') ? ' is-invalid' : '' }}"
                                                    name="type_id"
                                                    required
                                                    id="type_id">
                                                <option value="">@lang('site::messages.select_from_list')</option>
                                                @foreach($types as $type)
                                                    <option
                                                            @if(old('type_id', $event->type_id) == $type->id)
                                                            selected
                                                            @endif
                                                            value="{{ $type->id }}">{{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3 required">

                                            <label class="control-label" for="status_id">@lang('site::event.status_id')</label>
                                            <select class="form-control{{  $errors->has('status_id') ? ' is-invalid' : '' }}"
                                                    name="status_id"
                                                    required
                                                    id="status_id">
                                                <option value="">@lang('site::messages.select_from_list')</option>
                                                @foreach($statuses as $status)
                                                    <option
                                                            @if(old('status_id', $event->status_id) == $status->id)
                                                            selected
                                                            @endif
                                                            value="{{ $status->id }}">{{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('status_id') }}</span>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3 required">

                                            <label class="control-label" for="region_id">@lang('site::event.region_id')</label>
                                            <select class="form-control{{  $errors->has('region_id') ? ' is-invalid' : '' }}"
                                                    name="region_id"
                                                    required
                                                    id="region_id">
                                                <option value="">@lang('site::messages.select_from_list')</option>
                                                @foreach($regions as $region)
                                                    <option
                                                            @if(old('region_id', $event->region_id) == $region->id)
                                                            selected
                                                            @endif
                                                            value="{{ $region->id }}">{{ $region->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('region_id') }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label" for="city">@lang('site::event.city')</label>
                                            <input type="text" name="city"
                                                   id="city"
                                                   required
                                                   class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::event.placeholder.city')"
                                                   value="{{ old('city', $event->city) }}">
                                            <span class="invalid-feedback">{{ $errors->first('city') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label" for="address">@lang('site::event.address')</label>
                                    <input type="text" name="address"
                                           id="address"
                                           class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::event.placeholder.address')"
                                           value="{{ old('address', $event->address) }}">
                                    <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label"
                                               for="date_from">@lang('site::event.date_from_to') @lang('site::event.date_from')</label>
                                        <input type="date"
                                               name="date_from"
                                               id="date_from"
                                               required
                                               class="form-control{{ $errors->has('date_from') ? ' is-invalid' : '' }}"
                                               value="{{ old('date_from', $event->date_from) }}">
                                        <span class="invalid-feedback">{{ $errors->first('date_from') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label"
                                               for="date_to">@lang('site::event.date_from_to') @lang('site::event.date_to')</label>
                                        <input type="date"
                                               name="date_to"
                                               id="date_to"
                                               required
                                               class="form-control{{ $errors->has('date_to') ? ' is-invalid' : '' }}"
                                               value="{{ old('date_to', $event->date_to) }}">
                                        <span class="invalid-feedback">{{ $errors->first('date_to') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" @if(old('confirmed', $event->confirmed) == 1) checked @endif
                                class="custom-control-input{{  $errors->has('confirmed') ? ' is-invalid' : '' }}"
                                       id="confirmed" name="confirmed">
                                <label class="custom-control-label" for="confirmed">@lang('site::event.confirmed')</label>
                                <span class="invalid-feedback">{{ $errors->first('confirmed') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="control-label"
                                       for="description">@lang('site::event.description')</label>
                                <textarea name="description" id="description"
                                          class="summernote form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                          placeholder="@lang('site::event.placeholder.description')">{{ old('description', $event->description) }}</textarea>
                                <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                            </div>

                        </form>

                        <div class="form-group">
                            <label class="control-label"
                                   for="image_id">@lang('site::event.image_id')</label>

                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route('admin.images.field')}}">
                                @csrf
                                <input type="hidden" name="storage" value="events"/>
                                <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                       type="file"
                                       name="path"/>

                                <input type="button" class="btn btn-ferroli image-upload-button"
                                       value="@lang('site::messages.load')"/>
                                <span class="invalid-feedback">{{ $errors->first('image_id') }}</span>
                            </form>

                            <div id="image-src" class="bg-light"
                                 style="width: {{config('site.events.size.image.width', 370)}}px;height: {{config('site.events.size.image.height', 200)}}px;">
                                @include('site::admin.image.field', ['image'   => $event->image])
                            </div>

                        </div>

                        <hr/>
                        <div class=" text-right">
                            <button name="_stay" form="form-content" value="1" type="submit" class="btn btn-ferroli">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save_stay')</span>
                            </button>
                            <button name="_stay" form="form-content" value="0" type="submit" class="btn btn-ferroli">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save')</span>
                            </button>
                            <a href="{{ route('admin.events.show', $event) }}" class="d-block d-sm-inline btn btn-secondary">
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
