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
                <a href="{{ route('admin.engineers.index') }}">@lang('site::engineer.engineers')</a>
            </li>
            <li class="breadcrumb-item">{{ $engineer->name }}</li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::engineer.engineer')</h1>

        @alert()@endalert

        <div class="card mt-2 mb-4">
            <div class="card-body">
                <form id="engineer-edit-form" method="POST" action="{{ route('admin.engineers.update', $engineer) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::engineer.name')</label>
                            <input required
                                   type="text"
                                   name="engineer[name]"
                                   id="name"
                                   class="form-control{{ $errors->has('engineer.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::engineer.placeholder.name')"
                                   value="{{ old('engineer.name', optional($engineer)->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('engineer.name') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-row required">
                                <div class="col mb-3 required">
                                    <label class="control-label" for="country_id">@lang('site::engineer.country_id')</label>
                                    <select required
                                            name="engineer[country_id]"
                                            id="country_id"
                                            class="form-control{{  $errors->has('engineer.country_id') ? ' is-invalid' : '' }}">
                                        @if($countries->count() == 0 || $countries->count() > 1)
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                        @endif
                                        @foreach($countries as $country)
                                            <option @if(old('engineer.country_id', optional($engineer)->country_id) == $country->id)
                                                    selected
                                                    @endif
                                                    value="{{ $country->id }}">
                                                {{ $country->name }}
                                                {{ $country->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('engineer.country_id') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="contact">@lang('site::engineer.phone')</label>
                                    <input required
                                           type="tel"
                                           name="engineer[phone]"
                                           id="phone"
                                           oninput="mask_phones()"
                                           pattern="{{config('site.phone.pattern')}}"
                                           maxlength="{{config('site.phone.maxlength')}}"
                                           title="{{config('site.phone.format')}}"
                                           data-mask="{{config('site.phone.mask')}}"
                                           class="phone-mask form-control{{ $errors->has('engineer.phone') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::engineer.placeholder.phone')"
                                           value="{{ old('engineer.phone', optional($engineer)->phone) }}">
                                    <span class="invalid-feedback">{{ $errors->first('engineer.phone') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="address">@lang('site::engineer.address')</label>
                            <input type="text"
                                   name="engineer[address]"
                                   id="address"
                                   class="form-control{{ $errors->has('engineer.address') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::engineer.placeholder.address')"
                                   value="{{ old('engineer.address', optional($engineer)->address) }}">
                            <span class="invalid-feedback">{{ $errors->first('engineer.address') }}</span>
                        </div>
                    </div>

                    @if($certificate_types->isNotEmpty())
                        <h4><i class="fa fa-@lang('site::certificate.icon')"></i> @lang('site::certificate.certificates')</h4>
                        <div class="row">
                            @foreach($certificate_types as $certificate_type)
                                <div class="col-sm-{{12/$certificate_types->count()}}">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class="control-label"
                                                   for="certificate_{{$certificate_type->id}}">{{$certificate_type->name}}</label>
                                            <input type="text"
                                                   name="certificate[{{$certificate_type->id}}]"
                                                   id="certificate_{{$certificate_type->id}}"
                                                   maxlength="{{config('site.certificate_length', 20)}}"
                                                   placeholder="@lang('site::certificate.placeholder.id')"
                                                   class="form-control{{ $errors->has('certificate.'.$certificate_type->id) ? ' is-invalid' : '' }}"
                                                   value="{{ old('certificate.'.$certificate_type->id, optional($engineer->certificates()->where('type_id', $certificate_type->id)->first())->id) }}">
                                            <span class="invalid-feedback">{{ $errors->first('certificate.'.$certificate_type->id) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </form>
                <div class="form-row border-top pt-3">
                    <div class="col text-right">
                        <button form="engineer-edit-form" type="submit"
                                class="btn btn-ferroli  mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.engineers.index', ['filter[user]='.$engineer->user_id]) }}" class="d-block d-sm-inline btn btn-secondary">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection