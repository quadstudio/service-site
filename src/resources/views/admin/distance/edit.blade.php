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
                <a href="{{ route('admin.distances.index') }}">@lang('site::distance.distances')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit') {{$distance->name}}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$distance->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="product-type-edit-form"
                              action="{{ route('admin.distances.update', $distance) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::distance.name')</label>
                                    <input type="text" name="name"
                                           id="name"
                                           required
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::distance.placeholder.name')"
                                           value="{{ old('name', $distance->name) }}">
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
                                               @if(old('active', $distance->active) == 1) checked @endif
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
                                               @if(old('active', $distance->active) == 0) checked @endif
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
                                           for="contragent_inn">@lang('site::distance.cost')</label>
                                    <input type="number"
                                           name="cost"
                                           id="cost"
                                           min="0"
                                           required
                                           class="form-control{{$errors->has('cost') ? ' is-invalid' : ''}}"
                                           placeholder="@lang('site::distance.placeholder.cost')"
                                           value="{{ old('cost', $distance->cost) }}">
                                    <span class="invalid-feedback">{{ $errors->first('cost') }}</span>
                                </div>

                            </div>
                            <hr />
                            <div class=" text-right">
                                <button name="_stay" form="product-type-edit-form" value="1" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save_stay')</span>
                                </button>
                                <button name="_stay" form="product-type-edit-form" value="0" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.distances.index') }}" class="d-block d-sm-inline btn btn-secondary">
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
