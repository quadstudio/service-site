@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('repair::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('launches.index') }}">@lang('repair::launch.launches')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('launches.show', $launch) }}">{{ $launch->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('repair::messages.edit')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">@lang('repair::messages.edit') @lang('repair::launch.launch')</h1>
        <hr/>

        @include('alert')

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">

                <form method="POST" action="{{ route('launches.update', $launch) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name">@lang('repair::launch.name')</label>
                            <input type="text" name="name" id="name" disabled
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('repair::launch.placeholder.name')"
                                   value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">

                            <label for="country_id">@lang('repair::launch.country_id')</label>
                            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="country_id" id="country_id">
                                @foreach($countries as $country)
                                    <option @if($country->id == $launch->country_id) selected @endif value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="contact">@lang('repair::launch.phone')</label>
                            <input type="tel" name="phone" id="phone"
                                   title="@lang('repair::launch.placeholder.phone')"
                                   pattern="^\d{10}$" maxlength="10"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('repair::launch.placeholder.phone')"
                                   value="{{ old('phone', $launch->phone) }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                            <small id="phoneHelp" class="mb-4 form-text text-success">
                                @lang('repair::launch.help.phone')
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="address">@lang('repair::launch.address')</label>
                            <input type="text" name="address" id="address"
                                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('repair::launch.placeholder.address')"
                                   value="{{ old('address', $launch->address) }}" disabled>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col text-right">
                            <button name="_stay" value="1" type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i>
                                <span>@lang('repair::messages.save_stay')</span>
                            </button>
                            <button name="_stay" value="0" type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i>
                                <span>@lang('repair::messages.save')</span>
                            </button>
                            <a href="{{ route('launches.index') }}" class="btn btn-secondary">
                                <i class="fa fa-close"></i>
                                <span>@lang('repair::messages.cancel')</span>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection