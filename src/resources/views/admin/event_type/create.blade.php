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
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::event_type.event_type')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.event_types.store') }}">
                    @csrf

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::event_type.name')</label>
                            <input type="text" name="name"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::event_type.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="annotation">@lang('site::event_type.annotation')</label>
                            <textarea class="form-control{{ $errors->has('annotation') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::event_type.placeholder.annotation')"
                                      required
                                      name="annotation" id="annotation">{{ old('annotation') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('annotation') }}</span>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('active', 1) == 1) checked @endif
                        class="custom-control-input{{  $errors->has('active') ? ' is-invalid' : '' }}"
                               id="active" name="active">
                        <label class="custom-control-label" for="active">@lang('site::event_type.active')</label>
                        <span class="invalid-feedback">{{ $errors->first('active') }}</span>
                    </div>


                </form>
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
                        <a href="{{ route('admin.event_types.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection