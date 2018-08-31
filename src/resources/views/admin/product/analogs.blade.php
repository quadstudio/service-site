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
                <a href="{{ route('admin.products.index') }}">@lang('site::product.cards')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.show', $product) }}">{{$product->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::analog.analogs')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::analog.analogs') {{$product->name}} {{$product->sku}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="form-content"
                              action="{{ route('admin.products.analogs.update', $product) }}">

                            @csrf

                            @method('PUT')
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
                                                           @if(old('separator_row', 'rn') == $key) checked @endif
                                                           id="separator_row_{{$key}}"
                                                           value="1">
                                                    <label class="custom-control-label"
                                                           for="separator_row_{{$key}}">{!! $value !!}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label for="description">@lang('site::product.description')</label>
                                            <textarea
                                                    class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                    placeholder="@lang('site::product.placeholder.description')"
                                                    name="description" rows="5"
                                                    id="description">{{ old('description', $product->description) }}</textarea>
                                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-row required">--}}
                            {{--<div class="col mb-3">--}}
                            {{--<label class="control-label d-block"--}}
                            {{--for="separator_column">@lang('site::messages.separator.column')</label>--}}
                            {{--@foreach(trans('site::messages.symbol') as $key => $value)--}}
                            {{--<div class="custom-control custom-radio custom-control-inline">--}}
                            {{--<input class="custom-control-input--}}
                            {{--{{$errors->has('separator_column') ? ' is-invalid' : ''}}"--}}
                            {{--type="radio"--}}
                            {{--name="separator_column"--}}
                            {{--required--}}
                            {{--@if(old('separator_column', 'tab') == $key) checked @endif--}}
                            {{--id="separator_column_{{$key}}"--}}
                            {{--value="1">--}}
                            {{--<label class="custom-control-label"--}}
                            {{--for="separator_column_{{$key}}">{!! $value !!}</label>--}}
                            {{--</div>--}}
                            {{--@endforeach--}}
                            {{--</div>--}}
                            {{--</div>--}}


                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class=" border p-3 mt-2 mb-4">
            {{--<a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('products.create') }}"--}}
            {{--role="button">--}}
            {{--<i class="fa fa-plus"></i>--}}
            {{--<span>@lang('site::messages.add') @lang('site::product.product')</span>--}}
            {{--</a>--}}
            <button name="_stay" form="form-content" value="1" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save_stay')</span>
            </button>
            <button name="_stay" form="form-content" value="0" type="submit" class="btn btn-ferroli">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('admin.products.show', $product) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection
