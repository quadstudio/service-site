@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('mounters.index') }}">@lang('site::mounter.mounters')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('mounters.show', $mounter) }}">№ {{$mounter->id}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::mounter.mounter')</h1>

        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a href="{{ route('mounters.show', $mounter) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col">

                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <form id="form-content"
                              method="POST"
                              enctype="multipart/form-data"
                              action="{{ route('mounters.update', $mounter) }}">

                            @csrf
                            @method('PUT')

                            <div class="form-row required">
                                <label class="control-label"
                                       for="status_id">@lang('site::mounter.status_id')</label>
                                <select class="form-control{{  $errors->has('mounter.status_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="mounter[status_id]"
                                        id="status_id">
                                    @if($mounter_statuses->count() == 0 || $mounter_statuses->count() > 1)
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($mounter_statuses as $mounter_status)
                                        <option
                                                @if(old('mounter.status_id', $mounter->status_id) == $mounter_status->id) selected
                                                @endif
                                                value="{{ $mounter_status->id }}">{{ $mounter_status->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounter.status_id') }}</span>
                            </div>

                            <div class="form-row mt-2">
                                <label class="control-label" for="client">@lang('site::mounter.model')</label>
                                <input type="text"
                                       id="model"
                                       name="mounter[model]"
                                       class="form-control{{ $errors->has('mounter.model') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounter.model', $mounter->model) }}"
                                       placeholder="@lang('site::mounter.placeholder.model')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.model') }}</span>
                            </div>

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label for="comment">@lang('site::mounter.comment')</label>
                                    <textarea class="form-control{{ $errors->has('mounter.comment') ? ' is-invalid' : '' }}"
                                              placeholder="@lang('site::mounter.placeholder.comment')"
                                              name="mounter[comment]"
                                              id="comment">{{ old('mounter.comment', $mounter->comment) }}</textarea>
                                    <span class="invalid-feedback">{{ $errors->first('mounter.comment') }}</span>
                                </div>
                            </div>

                        </form>
                        <hr/>
                        <div class="form-row">
                            <div class="col text-right">
                                <button form="form-content" type="submit"
                                        class="btn btn-ferroli mb-1">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('mounters.show', $mounter) }}" class="btn btn-secondary mb-1">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
