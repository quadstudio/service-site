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
                <a href="{{ route('admin.datasheets.index') }}">@lang('site::datasheet.datasheets')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.datasheets.show', $datasheet) }}">{{$datasheet->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::datasheet.header.products')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::datasheet.header.products') {{$datasheet->name}}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin.datasheets.show', $datasheet) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form method="POST" id="form-content"
                              action="{{ route('admin.datasheets.products.update', $datasheet) }}">

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
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label for="products">@lang('site::datasheet.header.products')</label>
                                            <textarea
                                                    class="form-control{{ $errors->has('products') ? ' is-invalid' : '' }}"
                                                    {{--placeholder="@lang('site::datasheet.placeholder.products')"--}}
                                                    name="products" rows="5"
                                                    id="products">{{ old('products') }}</textarea>
                                            <span class="invalid-feedback">{{ $errors->first('products') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="text-right mb-4">
                                <button form="form-content" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                            </div>
                        </form>
                        @if($products->isNotEmpty())
                            <form method="POST" action="{{ route('admin.datasheets.products.delete', $datasheet) }}">
                                @csrf
                                @method('DELETE')
                                <table class="table table-sm">
                                    <tbody id="datasheet-products-list">
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <div class="form-group mb-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                               name="delete[]"
                                                               value="{{$product->id}}"
                                                               class="custom-control-input"
                                                               id="datasheet-product-{{$product->id}}">
                                                        <label class="custom-control-label"
                                                               for="datasheet-product-{{$product->id}}">{{$product->name}}</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr/>
                                <div class="text-right mb-4">
                                    <button type="submit" class="btn btn-ferroli">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.delete')</span>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
