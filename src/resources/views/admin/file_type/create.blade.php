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
                <a href="{{ route('admin.file_types.index') }}">@lang('site::file_type.file_types')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::file_type.file_type')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.file_types.store') }}">
                    @csrf

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::file_type.name')</label>
                            <input type="text" name="name"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::file_type.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="comment">@lang('site::file_type.comment')</label>
                            <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::file_type.placeholder.comment')"
                                      name="comment" id="comment">{{ old('comment') }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('comment') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="file_type_group_id">@lang('site::file_type.group_id')</label>
                            <select class="form-control
                                            {{$errors->has('group_id') ? ' is-invalid' : ''}}"
                                    required
                                    name="group_id"
                                    id="file_type_group_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($groups as $group)
                                    <option
                                            @if(old('group_id') == $group->id) selected
                                            @endif
                                            value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('group_id') }}</span>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('enabled', 1) == 1) checked @endif
                        class="custom-control-input{{  $errors->has('enabled') ? ' is-invalid' : '' }}"
                               id="enabled" name="enabled">
                        <label class="custom-control-label" for="enabled">@lang('site::file_type.enabled')</label>
                        <span class="invalid-feedback">{{ $errors->first('enabled') }}</span>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('required', 0) == 1) checked @endif
                        class="custom-control-input{{  $errors->has('required') ? ' is-invalid' : '' }}"
                               id="required" name="required">
                        <label class="custom-control-label" for="required">@lang('site::file_type.required')</label>
                        <span class="invalid-feedback">{{ $errors->first('required') }}</span>
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
                        <a href="{{ route('admin.file_types.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection