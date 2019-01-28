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
                <a href="{{ route('admin.templates.index') }}">@lang('site::template.templates')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::template.template')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body" id="summernote">

                <form id="form-content" method="POST" action="{{ route('admin.templates.store') }}">
                    @csrf

                    <div class="form-row required">
                        <div class="col mb-3 required">

                            <label class="control-label" for="type_id">@lang('site::template.type_id')</label>
                            <select class="form-control{{  $errors->has('type_id') ? ' is-invalid' : '' }}"
                                    name="type_id"
                                    required
                                    id="type_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($types as $type)
                                    <option
                                            @if(old('type_id') == $type->id)
                                            selected
                                            @endif
                                            value="{{ $type->id }}">{{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::template.name')</label>
                            <input type="text" name="name"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::template.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="title">@lang('site::template.title')</label>
                            <input type="text" name="title"
                                   id="title"
                                   required
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::template.placeholder.title')"
                                   value="{{ old('title') }}">
                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="content">@lang('site::template.content')</label>
                            <textarea class="summernote form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::template.placeholder.content')"
                                      name="content" id="content">{{ old('content') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('content') }}</span>
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
                        <a href="{{ route('admin.templates.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection