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
                <a href="{{ route('admin.pages.index') }}">@lang('site::page.pages')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::page.page')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.pages.store') }}">
                    @csrf
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="route">@lang('site::page.route')</label>
                            <input type="text" name="route"
                                   id="route"
                                   required
                                   class="form-control{{ $errors->has('route') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::page.placeholder.route')"
                                   value="{{ old('route') }}">
                            <span class="invalid-feedback">{{ $errors->first('route') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="h1">@lang('site::page.h1')</label>
                            <input type="text" name="h1"
                                   id="h1"
                                   required
                                   class="form-control{{ $errors->has('h1') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::page.placeholder.h1')"
                                   value="{{ old('h1') }}">
                            <span class="invalid-feedback">{{ $errors->first('h1') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="title">@lang('site::page.title')</label>
                            <input type="text" name="title"
                                   id="title"
                                   required
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::page.placeholder.title')"
                                   value="{{ old('title') }}">
                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="description">@lang('site::page.description')</label>
                            <textarea class="summernote form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::page.placeholder.description')"
                                      name="description" id="description">{{ old('description') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
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
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection