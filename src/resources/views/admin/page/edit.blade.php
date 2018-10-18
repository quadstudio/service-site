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
            <li class="breadcrumb-item active">@lang('site::messages.edit') {{$page->name}}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$page->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="page-edit-form"
                              action="{{ route('admin.pages.update', $page) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="route">@lang('site::page.route')</label>
                                    <input type="text" name="route"
                                           id="route"
                                           required
                                           class="form-control{{ $errors->has('route') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::page.placeholder.route')"
                                           value="{{ old('route', $page->route) }}">
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
                                           value="{{ old('h1', $page->h1) }}">
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
                                           value="{{ old('title', $page->title) }}">
                                    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label" for="description">@lang('site::page.description')</label>
                                    <textarea class="summernote form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"

                                              placeholder="@lang('site::page.placeholder.description')"
                                              name="description" id="description">{{ old('description', $page->description) }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                </div>
                            </div>

                            <hr />
                            <div class=" text-right">
                                <button name="_stay" form="page-edit-form" value="1" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save_stay')</span>
                                </button>
                                <button name="_stay" form="page-edit-form" value="0" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.pages.index') }}" class="d-page d-sm-inline btn btn-secondary">
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
