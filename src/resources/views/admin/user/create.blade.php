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
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add') @lang('site::user.create.dealer')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-plus"></i>
            @lang('site::messages.add') @lang('site::user.create.dealer')
        </h1>

        @alert()@endalert

        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <form id="register-form" method="POST" action="{{ route('admin.users.store') }}">
                            @csrf

                            <input type="hidden" name="verified" value="0">
                            <input type="hidden" name="dealer" value="1">
                            <input type="hidden" name="sc[type_id]" value="2">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label" for="name">@lang('site::user.name')</label>
                                            <input type="text"
                                                   name="name"
                                                   id="name"
                                                   required
                                                   class="form-control form-control-lg
                                    {{ $errors->has('name')
                                    ? ' is-invalid'
                                    : (old('name') ? ' is-valid' : '') }}"
                                                   placeholder="@lang('site::user.placeholder.name')"
                                                   value="{{ old('name') }}">
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                            <small id="nameHelp" class="form-text text-success">
                                                @lang('site::user.help.name')
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label" for="type_id">@lang('site::user.type_id')</label>
                                            @foreach($types as $key => $type)
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input
                                            {{$errors->has('type_id') ? ' is-invalid' : ''}}"
                                                           type="radio"
                                                           required
                                                           name="type_id"
                                                           @if(old('type_id') == $type->id) checked @endif
                                                           id="type_id_{{ $type->id }}"
                                                           value="{{ $type->id }}">
                                                    <label class="custom-control-label"
                                                           for="type_id_{{ $type->id }}">{{ $type->name }}</label>
                                                    @if($key == $types->count()-1)
                                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('user.type_id') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-6">

                                    <h4>@lang('site::register.sc_phone')</h4>
                                    <div class="form-row required">
                                        <div class="col mb-3">

                                            <label class="control-label"
                                                   for="phone_sc_country_id">@lang('site::phone.country_id')</label>
                                            <select class="form-control{{  $errors->has('phone.sc.country_id') ? ' is-invalid' : '' }}"
                                                    name="phone[sc][country_id]"
                                                    required
                                                    id="phone_sc_country_id">
                                                <option value="">@lang('site::messages.select_from_list')</option>
                                                @foreach($countries as $country)
                                                    <option
                                                            @if(old('phone.sc.country_id') == $country->id) selected
                                                            @endif
                                                            value="{{ $country->id }}">{{ $country->name }}
                                                        ({{ $country->phone }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('phone.sc.country_id') }}</strong>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-row required">
                                                <div class="col">
                                                    <label class="control-label"
                                                           for="phone_sc_number">@lang('site::phone.number')</label>
                                                    <input type="tel"
                                                           required
                                                           name="phone[sc][number]"
                                                           id="phone_sc_number"
                                                           title="@lang('site::phone.placeholder.number')"
                                                           pattern="^\d{10}$"
                                                           maxlength="10"
                                                           class="form-control{{ $errors->has('phone.sc.number') ? ' is-invalid' : '' }}"
                                                           placeholder="@lang('site::phone.placeholder.number')"
                                                           value="{{ old('phone.sc.number') }}">
                                                    <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('phone.sc.number') }}</strong>
                                                        </span>
                                                    <small id="sc_phone_numberHelp"
                                                           class="mb-4 form-text text-success">
                                                        @lang('site::phone.help.number')
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="col mb-3">
                                                    <label class="control-label"
                                                           for="phone_sc_extra">@lang('site::phone.extra')</label>
                                                    <input type="text"
                                                           name="phone[sc][extra]"
                                                           id="phone_sc_extra"
                                                           class="form-control{{ $errors->has('phone.sc.extra') ? ' is-invalid' : '' }}"
                                                           placeholder="@lang('site::phone.placeholder.extra')"
                                                           value="{{ old('phone.sc.extra') }}">
                                                    <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('phone.sc.extra') }}</strong>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    {{-- АДРЕС АСЦ --}}

                                    <h4>@lang('site::register.sc_address')</h4>

                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <input type="hidden" name="address[sc][type_id]" value="2">
                                            <label class="control-label"
                                                   for="address_sc_country_id">@lang('site::address.country_id')</label>
                                            <select class="country-select form-control{{  $errors->has('address.sc.country_id') ? ' is-invalid' : '' }}"
                                                    name="address[sc][country_id]"
                                                    required
                                                    data-regions="#address_sc_region_id"
                                                    data-empty="@lang('site::messages.select_from_list')"
                                                    id="address_sc_country_id">
                                                <option value="">@lang('site::messages.select_from_list')</option>
                                                @foreach($countries as $country)
                                                    <option
                                                            @if(old('address.sc.country_id') == $country->id) selected
                                                            @endif
                                                            value="{{ $country->id }}">{{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.sc.country_id') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-row required">
                                        <div class="col mb-3">

                                            <label class="control-label"
                                                   for="address_sc_region_id">@lang('site::address.region_id')</label>
                                            <select class="form-control{{  $errors->has('address.sc.region_id') ? ' is-invalid' : '' }}"
                                                    name="address[sc][region_id]"
                                                    required
                                                    id="address_sc_region_id">
                                                <option value="">@lang('site::address.help.select_country')</option>
                                                @foreach($address_sc_regions as $region)
                                                    <option
                                                            @if(old('address.sc.region_id') == $region->id) selected
                                                            @endif
                                                            value="{{ $region->id }}">{{ $region->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.sc.region_id') }}</strong>
                                            </span>
                                        </div>
                                    </div>


                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="address_sc_locality">@lang('site::address.locality')</label>
                                            <input type="text"
                                                   name="address[sc][locality]"
                                                   id="address_sc_locality"
                                                   required
                                                   class="form-control{{ $errors->has('address.sc.locality') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::address.placeholder.locality')"
                                                   value="{{ old('address.sc.locality') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('address.sc.locality') }}</strong>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label" for="email">@lang('site::user.email')</label>
                                            <input type="email"
                                                   name="email"
                                                   id="email"
                                                   required
                                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::user.placeholder.email')"
                                                   value="{{ old('email') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="web">@lang('site::user.web')</label>
                                            <input type="text"
                                                   name="web"
                                                   id="web"
                                                   class="form-control{{ $errors->has('web') ? ' is-invalid' : '' }}"
                                                   pattern="https?://.+" title="@lang('site::user.help.web')"
                                                   placeholder="@lang('site::user.placeholder.web')"
                                                   value="{{ old('web') }}">
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('web') }}</strong>
                                            </span>
                                            <small id="webHelp" class="form-text text-success">
                                                @lang('site::user.help.web')
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label d-block"
                                           for="active">@lang('site::user.active')</label>
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
                                    <label class="control-label d-block"
                                           for="display">@lang('site::user.display')</label>
                                    <div class="custom-control custom-radio  custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('display') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="display"
                                               required
                                               @if(old('display', 1) == 1) checked @endif
                                               id="display_1"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="display_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio  custom-control-inline">
                                        <input class="custom-control-input
                                                    {{$errors->has('display') ? ' is-invalid' : ''}}"
                                               type="radio"
                                               name="display"
                                               required
                                               @if(old('display', 1) == 0) checked @endif
                                               id="display_0"
                                               value="0">
                                        <label class="custom-control-label"
                                               for="display_0">@lang('site::messages.no')</label>
                                    </div>

                                </div>
                            </div>


                            {{--<div class="form-row required">--}}
                            {{--<div class="col mb-3">--}}
                            {{--<label class="control-label" for="password">@lang('site::user.password')</label>--}}
                            {{--<input type="password"--}}
                            {{--name="password"--}}
                            {{--required--}}
                            {{--id="password"--}}
                            {{--minlength="6"--}}
                            {{--maxlength="20"--}}
                            {{--class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"--}}
                            {{--placeholder="@lang('site::user.placeholder.password')"--}}
                            {{--value="{{ old('password') }}">--}}
                            {{--<span class="invalid-feedback">--}}
                            {{--<strong>{{ $errors->first('password') }}</strong>--}}
                            {{--</span>--}}

                            {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-row required">--}}
                            {{--<div class="col mb-3">--}}
                            {{--<label class="control-label"--}}
                            {{--for="password-confirmation">@lang('site::user.password_confirmation')</label>--}}
                            {{--<input id="password-confirmation"--}}
                            {{--type="password"--}}
                            {{--required--}}
                            {{--class="form-control"--}}
                            {{--placeholder="@lang('site::user.placeholder.password_confirmation')"--}}
                            {{--name="password_confirmation">--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-row">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-ferroli">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.save')</span>
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-close"></i>
                                        <span>@lang('site::messages.cancel')</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
