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
                        <form method="POST" id="event-type-edit-form"
                              action="{{ route('admin.event_types.update', $event_type) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::event_type.name')</label>
                                    <input type="text" name="name"
                                           id="name"
                                           maxlength="64"
                                           required
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::event_type.placeholder.name')"
                                           value="{{ old('name', $event_type->name) }}">
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="annotation">@lang('site::event_type.annotation')</label>
                                    <textarea class="form-control{{ $errors->has('annotation') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::event_type.placeholder.annotation')"
                                              required
                                              name="annotation"
                                              id="annotation">{{ old('annotation', $event_type->annotation) }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('annotation') }}</span>
                                </div>
                            </div>


                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" @if(old('active', $event_type->active) == 1) checked @endif
                                class="custom-control-input{{  $errors->has('active') ? ' is-invalid' : '' }}"
                                       id="active" name="active">
                                <label class="custom-control-label"
                                       for="active">@lang('site::event_type.active')</label>
                                <span class="invalid-feedback">{{ $errors->first('active') }}</span>
                            </div>

                            <hr/>
                            <div class=" text-right">
                                <button name="_stay" form="event-type-edit-form" value="1" type="submit"
                                        class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save_stay')</span>
                                </button>
                                <button name="_stay" form="event-type-edit-form" value="0" type="submit"
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
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
