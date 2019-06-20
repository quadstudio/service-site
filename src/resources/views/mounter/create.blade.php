@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('mounter-requests') }}">@lang('site::mounter.mounters')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.create') @lang('site::mounter.mounter')</h1>

        @alert()@endalert()
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('site::messages.has_error')</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center mb-5">
            <div class="col">
                <form id="form"
                      method="POST"
                      action="{{ route('mounters.store', $address) }}">
                    @csrf
                    <div class="card mb-2">
                        <div class="card-body">

                            <h5 class="card-title">{{$address->name}}</h5>
                            <h6 class="card-subtitle mb-4 text-muted">@lang('site::address.is_mounter')</h6>

                            <div class="form-row required mb-2">
                                <label class="control-label"
                                       for="mounter_at">@lang('site::mounter.mounter_at')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_mounter_at"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="mounter[mounter_at]"
                                           id="mounter_at"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::mounter.placeholder.mounter_at')"
                                           data-target="#datetimepicker_mounter_at"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('mounter.mounter_at') ? ' is-invalid' : '' }}"
                                           value="{{ old('mounter.mounter_at') }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_mounter_at"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('mounter.mounter_at') }}</span>
                            </div>

                            <div class="form-row">
                                <label class="control-label"
                                       for="equipment_id">@lang('site::mounter.equipment_id')</label>
                                <select class="form-control{{  $errors->has('mounter.equipment_id') ? ' is-invalid' : '' }}"
                                        name="mounter[equipment_id]"
                                        id="equipment_id">
                                    @if($equipments->count() == 0 || $equipments->count() > 1)
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($equipments as $equipment)
                                        <option
                                                @if(old('mounter.equipment_id') == $equipment->id) selected
                                                @endif
                                                value="{{ $equipment->id }}">{{ $equipment->name }} {{ $equipment->phone }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounter.equipment_id') }}</span>
                            </div>

                            <div class="form-row">
                                <label class="control-label"
                                       for="product_id">@lang('site::mounter.product_id')</label>
                                <select class="form-control{{  $errors->has('mounter.product_id') ? ' is-invalid' : '' }}"
                                        name="mounter[product_id]"
                                        id="product_id">
                                    @if($products->count() == 0)
                                        <option value="">@lang('site::mounter.help.select_equipment')</option>
                                    @else
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($products as $product)
                                        <option
                                                @if(old('mounter.product_id') == $product->id) selected
                                                @endif
                                                value="{{ $product->id }}">{{ $product->name }} {{ $product->phone }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounter.product_id') }}</span>
                            </div>

                            <div class="form-row">
                                <label class="control-label" for="client">@lang('site::mounter.model')</label>
                                <input type="text"
                                       id="model"
                                       name="mounter[model]"
                                       class="form-control{{ $errors->has('mounter.model') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounter.model') }}"
                                       placeholder="@lang('site::mounter.placeholder.model')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.model') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label" for="address">@lang('site::mounter.address')</label>
                                <input required
                                       type="text"
                                       id="address"
                                       name="mounter[address]"
                                       class="form-control{{ $errors->has('mounter.address') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounter.address') }}"
                                       placeholder="@lang('site::mounter.placeholder.address')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.address') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label" for="client">@lang('site::mounter.client')</label>
                                <input required
                                       type="text"
                                       id="client"
                                       name="mounter[client]"
                                       class="form-control{{ $errors->has('mounter.client') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounter.client') }}"
                                       placeholder="@lang('site::mounter.placeholder.client')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.client') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label"
                                       for="country_id">@lang('site::mounter.country_id')</label>
                                <select class="form-control{{  $errors->has('mounter.country_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="mounter[country_id]"
                                        id="country_id">
                                    @if($countries->count() == 0 || $countries->count() > 1)
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($countries as $country)
                                        <option
                                                @if(old('mounter.country_id') == $country->id) selected
                                                @endif
                                                value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounter.country_id') }}</span>
                            </div>

                            <div class="form-row required">
                                <label class="control-label"
                                       for="phone">@lang('site::mounter.phone')</label>
                                <input required
                                       type="tel"
                                       oninput="mask_phones()"
                                       id="phone"
                                       name="mounter[phone]"
                                       class="phone-mask form-control{{ $errors->has('mounter.phone') ? ' is-invalid' : '' }}"
                                       pattern="{{config('site.phone.pattern')}}"
                                       maxlength="{{config('site.phone.maxlength')}}"
                                       title="{{config('site.phone.format')}}"
                                       data-mask="{{config('site.phone.mask')}}"
                                       value="{{ old('mounter.phone') }}"
                                       placeholder="@lang('site::mounter.placeholder.phone')">
                                <span class="invalid-feedback">{{ $errors->first('mounter.phone') }}</span>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="captcha">@lang('site::mounter.captcha')</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text"
                                                   form="form"
                                                   name="captcha"
                                                   required
                                                   id="captcha"
                                                   class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}"
                                                   placeholder="@lang('site::mounter.placeholder.captcha')"
                                                   value="">
                                            <span class="invalid-feedback">{{ $errors->first('captcha') }}</span>
                                        </div>
                                        <div class="col-md-9 captcha">
                                            <span>{!! captcha_img('flat') !!}</span>
                                            <button data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="@lang('site::messages.refresh')"
                                                    type="button"
                                                    class="btn btn-outline-secondary"
                                                    id="captcha-refresh">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col text-right">
                                    <button form="form" type="submit"
                                            class="btn btn-ferroli mb-1">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.save')</span>
                                    </button>
                                    <a href="{{ route('mounter-requests') }}" class="btn btn-secondary mb-1">
                                        <i class="fa fa-close"></i>
                                        <span>@lang('site::messages.cancel')</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    try {
        window.addEventListener('load', function () {
            document.getElementById('captcha-refresh').addEventListener('click', function () {
                fetch('/captcha/flat')
                    .then(response => {
                        response.blob().then(blobResponse => {
                            const urlCreator = window.URL || window.webkitURL;
                            document.querySelector('.captcha span img').src = urlCreator.createObjectURL(blobResponse);
                        });
                    });
            });

            document.getElementById('equipment_id').addEventListener('change', function () {

                let product_id = document.getElementById('product_id');
                product_id.disabled = true;
                product_id.innerHTML = '<option value="">{{trans('site::messages.data_load')}}</option>';

                function checkStatus(response) {
                    if (response.status >= 200 && response.status < 300) {
                        return response;
                    } else {
                        let error = new Error(response.statusText);
                        error.response = response;
                        throw error
                    }
                }

                function parseJSON(response) {
                    return response.json()
                }

                function renderProductsList(data) {
                    product_id.disabled = false;
                    if (data.data.length > 0) {
                        let list = '<option value="">{{trans('site::messages.select_from_list')}}</option>';
                        data.data.forEach(function (product, index) {
                            list += `<option value="${product.id}">${product.name}</option>`;
                        });
                        product_id.innerHTML = list;
                    } else{
                        product_id.innerHTML = '<option value="">{{trans('site::mounter.help.select_equipment')}}</option>';
                    }
                }

                fetch('/api/products/mounter?filter[equipment_id]=' + event.target.value)
                    .then(checkStatus)
                    .then(parseJSON)
                    .then(renderProductsList)
                    .catch(error => console.error(error));
            });
        });

    } catch (e) {
        console.log(e);
    }

</script>
@endpush