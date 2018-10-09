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
                <a href="{{ route('admin.launches.index') }}">@lang('site::launch.launches')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.launches.show', $launch) }}">{{ $launch->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::launch.launch')</h1>

        @alert()@endalert

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="launch-edit-form" method="POST" action="{{ route('admin.launches.update', $launch) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="name">@lang('site::launch.name')</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::launch.placeholder.name')"
                                   value="{{ old('name', $launch->name) }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">

                            <label for="country_id">@lang('site::launch.country_id')</label>
                            <select class="form-control{{  $errors->has('country_id') ? ' is-invalid' : '' }}"
                                    name="country_id" id="country_id">
                                @foreach($countries as $country)
                                    <option @if($country->id == $launch->country_id) selected
                                            @endif value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="contact">@lang('site::launch.phone')</label>
                            <input type="tel" name="phone" id="phone"
                                   title="@lang('site::launch.placeholder.phone')"
                                   pattern="^\d{10}$" maxlength="10"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::launch.placeholder.phone')"
                                   value="{{ old('phone', $launch->phone) }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                            <small id="phoneHelp" class="mb-4 form-text text-success">
                                @lang('site::launch.help.phone')
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="address">@lang('site::launch.address')</label>
                            <input type="text"
                                   name="address"
                                   id="address"
                                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::launch.placeholder.address')"
                                   value="{{ old('address', $launch->address) }}">
                            @if ($errors->has('address'))
                                <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="document_name">@lang('site::launch.document_name')</label>
                            <input type="text" name="document_name" id="document_name"
                                   class="form-control{{ $errors->has('document_name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::launch.placeholder.document_name')"
                                   value="{{ old('document_name', $launch->document_name) }}" required>
                            <span class="invalid-feedback">{{ $errors->first('document_name') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="document_number">@lang('site::launch.document_number')</label>
                            <input type="text" name="document_number" id="document_number"
                                   class="form-control{{ $errors->has('document_number') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::launch.placeholder.document_number')"
                                   value="{{ old('document_number', $launch->document_number) }}" required>
                            <span class="invalid-feedback">{{ $errors->first('document_number') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="document_who">@lang('site::launch.document_who')</label>
                            <input type="text" name="document_who" id="document_who"
                                   class="form-control{{ $errors->has('document_who') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::launch.placeholder.document_who')"
                                   value="{{ old('document_who', $launch->document_who) }}" required>
                            <span class="invalid-feedback">{{ $errors->first('document_who') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="document_date">@lang('site::launch.document_date')</label>
                            <input type="date" name="document_date" id="document_date"
                                   class="form-control{{ $errors->has('document_date') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::launch.placeholder.document_date')"
                                   value="{{ old('document_date', $launch->document_date) }}" required>
                            <span class="invalid-feedback">{{ $errors->first('document_date') }}</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class=" border p-3 mb-2">

            <button form="launch-edit-form" name="_stay" value="0" type="submit"
                    class="btn btn-ferroli  mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('admin.launches.show', $launch) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection