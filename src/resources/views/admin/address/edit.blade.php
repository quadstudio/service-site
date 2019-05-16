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
                <a href="{{ route('admin.addresses.index') }}">@lang('site::address.addresses')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.addresses.show', $address) }}">{{$address->full}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{ $address->full }}</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="address-form" method="POST"
                      action="{{ route('admin.addresses.update', $address) }}">

                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('address.show_ferroli', $address->show_ferroli)) checked @endif
                                               class="custom-control-input{{  $errors->has('address.show_ferroli') ? ' is-invalid' : '' }}"
                                               id="show_ferroli"
                                               name="address[show_ferroli]">
                                        <label class="custom-control-label"
                                               for="show_ferroli">@lang('site::messages.show_ferroli')</label>
                                        <span class="invalid-feedback">{{ $errors->first('address.show_ferroli') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('address.show_lamborghini', $address->show_lamborghini)) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('address.show_lamborghini') ? ' is-invalid' : '' }}"
                                               id="show_lamborghini"
                                               name="address[show_lamborghini]">
                                        <label class="custom-control-label"
                                               for="show_lamborghini">@lang('site::messages.show_lamborghini')</label>
                                        <span class="invalid-feedback">{{ $errors->first('address.show_lamborghini') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" @if(old('address.is_shop', $address->is_shop)) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('address.is_shop') ? ' is-invalid' : '' }}"
                                               id="is_shop"
                                               name="address[is_shop]">
                                        <label class="custom-control-label"
                                               for="is_shop">@lang('site::address.is_shop')</label>
                                        <span class="invalid-feedback">{{ $errors->first('address.is_shop') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('address.is_service', $address->is_service)) checked @endif
                                               class="custom-control-input{{  $errors->has('address.is_service') ? ' is-invalid' : '' }}"
                                               id="is_service"
                                               name="address[is_service]">
                                        <label class="custom-control-label"
                                               for="is_service">@lang('site::address.is_service')</label>
                                        <span class="invalid-feedback">{{ $errors->first('address.is_service') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" @if(old('address.is_eshop', $address->is_eshop)) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('address.is_eshop') ? ' is-invalid' : '' }}"
                                               id="is_eshop"
                                               name="address[is_eshop]">
                                        <label class="custom-control-label"
                                               for="is_eshop">@lang('site::address.is_eshop')</label>
                                        <span class="invalid-feedback">{{ $errors->first('address.is_eshop') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('address.is_mounter', $address->is_mounter)) checked @endif
                                               class="custom-control-input{{  $errors->has('address.is_mounter') ? ' is-invalid' : '' }}"
                                               id="is_mounter"
                                               name="address[is_mounter]">
                                        <label class="custom-control-label"
                                               for="is_mounter">@lang('site::address.is_mounter')</label>
                                        <span class="invalid-feedback">{{ $errors->first('address.is_mounter') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="address_sort_order">@lang('site::address.sort_order')</label>
                            <input type="number"
                                   name="address[sort_order]"
                                   id="sort_order"
                                   min="0"
                                   max="200"
                                   step="1"
                                   required
                                   class="form-control{{$errors->has('address.sort_order') ? ' is-invalid' : ''}}"
                                   placeholder="@lang('site::address.placeholder.sort_order')"
                                   value="{{ old('address.sort_order', $address->sort_order) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.sort_order') }}</span>
                            <span class="mb-4 form-text text-success">
                                @lang('site::address.help.sort_order')
                            </span>
                        </div>

                    </div>


                    <div class="form-row @if($address->addressable_type == 'users') required @endif">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::address.name')</label>
                            <input type="text"
                                   name="address[name]"
                                   id="name"
                                   @if($address->addressable_type == 'users')
                                   required
                                   @endif
                                   class="form-control{{ $errors->has('address.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.name')"
                                   value="{{ old('address.name',$address->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.name') }}</span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label"
                               for="type_id">@lang('site::address.type_id')</label>
                        <select class="form-control{{  $errors->has('address.type_id') ? ' is-invalid' : '' }}"
                                required
                                name="address[type_id]"
                                id="type_id">
                            @if($address_types->count() != 1)
                                <option value="">@lang('site::messages.select_from_list')</option>
                            @endif
                            @foreach($address_types as $address_type)
                                <option @if(old('address.type_id', $address->type_id) == $address_type->id) selected
                                        @endif
                                        value="{{ $address_type->id }}">{{ $address_type->name }}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('address.type_id') }}</span>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3">

                            <label class="control-label" for="country_id">@lang('site::address.country_id')</label>
                            <select class="country-select form-control{{  $errors->has('address.country_id') ? ' is-invalid' : '' }}"
                                    name="address[country_id]"
                                    required
                                    data-regions="#region_id"
                                    data-empty="@lang('site::messages.select_from_list')"
                                    id="country_id">
                                @if($countries->count() != 1)
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                @endif
                                @foreach($countries as $country)
                                    <option
                                            @if(old('address.country_id',$address->country_id) == $country->id) selected
                                            @endif
                                            value="{{ $country->id }}">{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('address.country_id') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3 required">

                            <label class="control-label" for="region_id">@lang('site::address.region_id')</label>
                            <select class="form-control{{  $errors->has('address.region_id') ? ' is-invalid' : '' }}"
                                    name="address[region_id]"
                                    required
                                    id="region_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($regions as $region)
                                    <option
                                            @if(old('address.region_id',$address->region_id) == $region->id) selected
                                            @endif
                                            value="{{ $region->id }}">{{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('address.region_id') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="locality">@lang('site::address.locality')</label>
                            <input type="text"
                                   name="address[locality]"
                                   id="locality"
                                   required
                                   class="form-control{{ $errors->has('address.locality') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.locality')"
                                   value="{{ old('address.locality',$address->locality) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.locality') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="street">@lang('site::address.street')</label>
                            <input type="text"
                                   name="address[street]"
                                   id="street"
                                   class="form-control{{ $errors->has('address.street') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.street')"
                                   value="{{ old('address.street',$address->street) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.street') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label" for="building">@lang('site::address.building')</label>
                                    <input type="text"
                                           name="address[building]"
                                           id="building"
                                           class="form-control{{ $errors->has('address.building') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.building')"
                                           value="{{ old('address.building',$address->building) }}">
                                    <span class="invalid-feedback">{{ $errors->first('address.building') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="apartment">@lang('site::address.apartment')</label>
                                    <input type="text"
                                           name="address[apartment]"
                                           id="apartment"
                                           class="form-control{{ $errors->has('address.apartment') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::address.placeholder.apartment')"
                                           value="{{ old('address.apartment',$address->apartment) }}">
                                    <span class="invalid-feedback">{{ $errors->first('address.apartment') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="email">@lang('site::address.email')</label>
                            <input type="email"
                                   name="address[email]"
                                   id="address[email]"
                                   class="form-control{{ $errors->has('address.email') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.email')"
                                   value="{{ old('address.email',$address->email) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.email') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="web">@lang('site::address.web')</label>
                            <input type="text"
                                   name="address[web]"
                                   id="address[web]"
                                   class="form-control{{ $errors->has('address.web') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::address.placeholder.web')"
                                   value="{{ old('address.web',$address->web) }}">
                            <span class="invalid-feedback">{{ $errors->first('address.web') }}</span>
                        </div>
                    </div>


                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="address-form" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.addresses.index') }}"
                       class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection
