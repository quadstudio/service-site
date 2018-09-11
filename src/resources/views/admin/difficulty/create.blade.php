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
                <a href="{{ route('admin.difficulties.index') }}">@lang('site::difficulty.difficulties')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::difficulty.difficulty')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.difficulties.store') }}">
                    @csrf

                    <input type="hidden" name="sort_order" value="{{$sort_order}}" />

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::difficulty.name')</label>
                            <input type="text" name="name"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::difficulty.placeholder.name')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label d-block"
                                   for="active">@lang('site::distance.active')</label>
                            <div class="custom-control custom-radio  custom-control-inline">
                                <input class="custom-control-input
                                                    {{$errors->has('active') ? ' is-invalid' : ''}}"
                                       type="radio"
                                       name="active"
                                       required
                                       @if(old('active', 1) == 1) checked @endif
                                       id="active_1"
                                       value="1">
                                <label class="custom-control-label"
                                       for="active_1">@lang('site::messages.yes')</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input
                                                    {{$errors->has('active') ? ' is-invalid' : ''}}"
                                       type="radio"
                                       name="active"
                                       required
                                       @if(old('active', 1) == 0) checked @endif
                                       id="active_0"
                                       value="0">
                                <label class="custom-control-label"
                                       for="active_0">@lang('site::messages.no')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="contragent_inn">@lang('site::difficulty.cost')</label>
                            <input type="number"
                                   name="cost"
                                   id="cost"
                                   min="0"
                                   required
                                   class="form-control{{$errors->has('cost') ? ' is-invalid' : ''}}"
                                   placeholder="@lang('site::difficulty.placeholder.cost')"
                                   value="{{ old('cost') }}">
                            <span class="invalid-feedback">{{ $errors->first('cost') }}</span>
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
                        <a href="{{ route('admin.difficulties.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection