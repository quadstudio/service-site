@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('engineers.index') }}">@lang('site::engineer.engineers')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('engineers.show', $engineer) }}">{{ $engineer->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::engineer.engineer')</h1>

        @alert()@endalert

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="engineer-edit-form" method="POST" action="{{ route('engineers.update', $engineer) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name">@lang('site::engineer.name')</label>
                            <input type="text" name="name" id="name" disabled
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::engineer.placeholder.name')"
                                   value="{{ old('name', $engineer->name) }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">

                            <label for="country_id">@lang('site::engineer.country_id')</label>
                            <select class="form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="country_id" id="country_id">
                                @foreach($countries as $country)
                                    <option @if($country->id == $engineer->country_id) selected
                                            @endif value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
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
                            <label for="contact">@lang('site::engineer.phone')</label>
                            <input type="tel" name="phone" id="phone"
                                   title="@lang('site::engineer.placeholder.phone')"
                                   pattern="^\d{9,10}$" maxlength="10"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::engineer.placeholder.phone')"
                                   value="{{ old('phone', $engineer->phone) }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                            <small id="phoneHelp" class="mb-4 form-text text-success">
                                @lang('site::engineer.help.phone')
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="address">@lang('site::engineer.address')</label>
                            <input type="text" name="address" id="address"
                                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::engineer.placeholder.address')"
                                   value="{{ old('address', $engineer->address) }}" disabled>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class=" border p-3 mb-2">

            <button form="engineer-edit-form" name="_stay" value="0" type="submit"
                    class="btn btn-ferroli  mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('engineers.show', $engineer) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection