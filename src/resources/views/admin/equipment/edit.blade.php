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
                <a href="{{ route('admin.equipments.index') }}">@lang('site::equipment.equipments')</a>
            </li>
            <li class="breadcrumb-item active">{{$equipment->name}}</li>
        </ol>
        <h1 class="header-title mb-4">{{$equipment->name}}</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.equipments.update', $equipment) }}">
                    @csrf
                    @method('PUT')
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('enabled', $equipment->enabled)) checked @endif
                        class="custom-control-input{{  $errors->has('enabled') ? ' is-invalid' : '' }}"
                               id="enabled"
                               name="enabled">
                        <label class="custom-control-label" for="enabled">@lang('site::equipment.enabled')</label>
                        <span class="invalid-feedback">{{ $errors->first('enabled') }}</span>
                    </div>

                    <div class="form-group required">
                        <label class="control-label" for="catalog_id">@lang('site::equipment.catalog_id')</label>
                        <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                name="catalog_id"
                                required
                                id="catalog_id">
                            <option value="">@lang('site::equipment.default.catalog_id')</option>
                            @include('site::admin.equipment.tree.edit', ['value' => $tree, 'level' => 0])
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('catalog_id') }}</span>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::equipment.name')</label>
                            <input type="text" name="name"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::equipment.placeholder.name')"
                                   value="{{ old('name', $equipment->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="description">@lang('site::equipment.description')</label>
                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      placeholder="@lang('site::equipment.placeholder.description')"
                                      name="description"
                                      id="description">{{ old('description', $equipment->description) }}</textarea>
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::equipment.cost_work')</label>
                            <input type="number"
                                   name="cost_work"
                                   id="cost_work"
                                   min="0"
                                   max="10000"
                                   required
                                   class="form-control{{ $errors->has('cost_work') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::equipment.placeholder.cost_work')"
                                   value="{{ old('cost_work', $equipment->cost_work) }}">
                            <span class="invalid-feedback">{{ $errors->first('cost_work') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::equipment.cost_road')</label>
                            <input type="number"
                                   name="cost_road"
                                   id="cost_road"
                                   min="0"
                                   max="10000"
                                   required
                                   class="form-control{{ $errors->has('cost_road') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::equipment.placeholder.cost_road')"
                                   value="{{ old('cost_road', $equipment->cost_road) }}">
                            <span class="invalid-feedback">{{ $errors->first('cost_road') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">

                            <label class="control-label"
                                   for="currency_id">@lang('site::equipment.currency_id')</label>
                            <select class="form-control{{  $errors->has('currency_id') ? ' is-invalid' : '' }}"
                                    required
                                    name="currency_id"
                                    id="currency_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($currencies as $currency)
                                    <option
                                            @if(old('currency_id', $equipment->currency_id) == $currency->id) selected
                                            @endif
                                            value="{{ $currency->id }}">{{ $currency->title }}
                                        ({{ $currency->name }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('currency_id') }}</strong>
                            </span>
                        </div>
                    </div>
                </form>
                <fieldset>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::image.images')</h5>
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route('admin.images.store')}}">
                                @csrf
                                <div class="form-group form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                                    <input type="file" name="path"/>
                                    <input type="hidden" name="storage" value="equipments"/>
                                    <input type="button" class="btn btn-primary image-upload"
                                           value="@lang('site::messages.load')">

                                </div>
                                <span class="invalid-feedback">{{ $errors->first('path') }}</span>
                            </form>
                            <div class="d-flex flex-row bd-highlight">
                                @if( !$images->isEmpty())
                                    @foreach($images as $image)
                                        @include('site::admin.image.image')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-row">
                    <div class="col text-right">
                        <button form="form-content" name="_stay" value="1" type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save_stay')</span>
                        </button>
                        <button form="form-content" name="_stay" value="0" type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.equipments.index') }}" class="btn btn-secondary">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection