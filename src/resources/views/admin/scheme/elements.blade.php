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
                <a href="{{ route('admin.schemes.index') }}">@lang('site::scheme.schemes')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.schemes.show', $scheme) }}">{{$scheme->block->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::element.elements')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::element.elements') {{$scheme->block->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form method="POST" id="form-content"
                              action="{{ route('admin.schemes.elements.update', $scheme) }}">

                            @csrf

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label d-block"
                                                   for="separator_row">@lang('site::messages.separator.row')</label>
                                            @foreach(trans('site::messages.symbol') as $key => $value)
                                                <div class="custom-control d-block custom-radio custom-control-inline">
                                                    <input class="custom-control-input
                                                         {{$errors->has('separator_row') ? ' is-invalid' : ''}}"
                                                           type="radio"
                                                           name="separator_row"
                                                           required
                                                           @if(old('separator_row', '\r\n') == $key) checked @endif
                                                           id="separator_row_{{$key}}"
                                                           value="{{$key}}">
                                                    <label class="custom-control-label"
                                                           for="separator_row_{{$key}}">{!! $value !!}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label d-block"
                                                   for="separator_column">@lang('site::messages.separator.column')</label>
                                            @foreach(trans('site::messages.symbol') as $key => $value)
                                                <div class="custom-control d-block custom-radio custom-control-inline">
                                                    <input class="custom-control-input
                                                         {{$errors->has('separator_column') ? ' is-invalid' : ''}}"
                                                           type="radio"
                                                           name="separator_column"
                                                           required
                                                           @if(old('separator_column', '\s') == $key) checked @endif
                                                           id="separator_column_{{$key}}"
                                                           value="{{$key}}">
                                                    <label class="custom-control-label"
                                                           for="separator_column_{{$key}}">{!! $value !!}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label for="elements">@lang('site::element.elements')</label>
                                            <textarea
                                                    class="form-control{{ $errors->has('elements') ? ' is-invalid' : '' }}"
                                                    placeholder="@lang('site::scheme.placeholder.elements')"
                                                    name="elements" rows="9"
                                                    id="elements">{{ old('elements') }}</textarea>
                                            <span class="invalid-feedback">{{ $errors->first('elements') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form method="post" id="delete-form"
                              action="{{ route('admin.schemes.elements.delete', $scheme) }}">
                            @csrf
                            @method('DELETE')
                            <table class="table">
                                <tbody data-target="{{route('admin.elements.sort')}}"
                                       id="sort-list">
                                @each('site::admin.scheme.show.element', $elements, 'element')
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class=" border p-3 mt-2 mb-4 text-right">
            <button  form="delete-form" type="submit" class="btn btn-danger mr-5">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.delete')</span>
            </button>
            <button name="_stay" form="form-content" value="1" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save_stay')</span>
            </button>
            <button name="_stay" form="form-content" value="0" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>

            <a href="{{ route('admin.schemes.show', $scheme) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection
