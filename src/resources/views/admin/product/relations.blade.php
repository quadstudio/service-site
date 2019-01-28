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
            <li class="breadcrumb-item active">@lang('site::relation.header.relations')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::relation.header.relations') {{$product->name}} {{$product->sku}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form method="POST" id="form-content"
                              action="{{ route('admin.products.relations.update', $product) }}">

                            @csrf
        <div class=" border p-3 mt-2 mb-4">
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
                                            <label for="relations">@lang('site::relation.header.relations')</label>
                                            <textarea
                                                    class="form-control{{ $errors->has('relations') ? ' is-invalid' : '' }}"
                                                    {{--placeholder="@lang('site::product.placeholder.relations')"--}}
                                                    name="relations" rows="5"
                                                    id="relations">{{ old('relations') }}</textarea>
                                            <span class="invalid-feedback">{{ $errors->first('relations') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="list-group list-group-flush" id="product-relations-list">
                            @foreach($relations as $relation)
                                @include('site::admin.product.show.relation')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class=" border p-3 mt-2 mb-4">
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
