@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('mountings.index') }}">@lang('site::mounting.mountings')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.create') @lang('site::mounting.mounting')</h1>

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
                      enctype="multipart/form-data"
                      action="{{ route('mountings.store') }}">
                    @csrf
                    {{-- КЛИЕНТ --}}
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::mounting.header.client')</h5>

                            <div class="form-group mt-2 required">
                                <label class="control-label" for="client">@lang('site::mounting.client')</label>
                                <input required
                                       type="text"
                                       id="client"
                                       name="mounting[client]"
                                       class="form-control{{ $errors->has('mounting.client') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounting.client') }}"
                                       placeholder="@lang('site::mounting.placeholder.client')">
                                <span class="invalid-feedback">{{ $errors->first('mounting.client') }}</span>
                            </div>

                            <div class="form-group required">
                                <label class="control-label"
                                       for="country_id">@lang('site::mounting.country_id')</label>
                                <select class="form-control{{  $errors->has('mounting.country_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="mounting[country_id]"
                                        id="country_id">
                                    @if($countries->count() == 0 || $countries->count() > 1)
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($countries as $country)
                                        <option
                                                @if(old('mounting.country_id') == $country->id) selected
                                                @endif
                                                value="{{ $country->id }}">{{ $country->name }} {{ $country->phone }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounting.country_id') }}</span>
                            </div>

                            <div class="form-group required">
                                <label class="control-label" for="address">@lang('site::mounting.address')</label>
                                <input required
                                       type="text"
                                       id="address"
                                       name="mounting[address]"
                                       class="form-control{{ $errors->has('mounting.address') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounting.address') }}"
                                       placeholder="@lang('site::mounting.placeholder.address')">
                                <span class="invalid-feedback">{{ $errors->first('mounting.address') }}</span>
                            </div>

                            <div class="form-group required">
                                <label class="control-label"
                                       for="phone_primary">@lang('site::mounting.phone_primary')</label>
                                <input required
                                       type="tel"
                                       oninput="mask_phones()"
                                       id="phone_primary"
                                       name="mounting[phone_primary]"
                                       class="phone-mask form-control{{ $errors->has('mounting.phone_primary') ? ' is-invalid' : '' }}"
                                       pattern="{{config('site.phone.pattern')}}"
                                       maxlength="{{config('site.phone.maxlength')}}"
                                       title="{{config('site.phone.format')}}"
                                       data-mask="{{config('site.phone.mask')}}"
                                       value="{{ old('mounting.phone_primary') }}"
                                       placeholder="@lang('site::mounting.placeholder.phone_primary')">
                                <span class="invalid-feedback">{{ $errors->first('mounting.phone_primary') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="control-label"
                                       for="phone_secondary">@lang('site::mounting.phone_secondary')</label>
                                <input type="tel"
                                       oninput="mask_phones()"
                                       id="phone_secondary"
                                       name="mounting[phone_secondary]"
                                       class="phone-mask form-control{{ $errors->has('mounting.phone_secondary') ? ' is-invalid' : '' }}"
                                       pattern="{{config('site.phone.pattern')}}"
                                       maxlength="{{config('site.phone.maxlength')}}"
                                       title="{{config('site.phone.format')}}"
                                       data-mask="{{config('site.phone.mask')}}"
                                       value="{{ old('mounting.phone_secondary') }}"
                                       placeholder="@lang('site::mounting.placeholder.phone_secondary')">
                                <span class="invalid-feedback">{{ $errors->first('mounting.phone_secondary') }}</span>
                            </div>
                        </div>
                    </div>

                    {{--ОРГАНИЗАЦИИ --}}

                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::mounting.header.org')</h5>
                            <div class="form-group required" id="form-group-trade_id">
                                <label class="control-label" for="trade_id">@lang('site::mounting.trade_id')</label>
                                <select required
                                        data-form-action="{{ route('trades.create') }}"
                                        data-btn-ok="@lang('site::messages.save')"
                                        data-btn-cancel="@lang('site::messages.cancel')"
                                        data-options="#trade_id_options"
                                        data-label="@lang('site::messages.add') @lang('site::trade.trade')"
                                        class="dynamic-modal-form form-control{{  $errors->has('mounting.trade_id') ? ' is-invalid' : '' }}"
                                        name="mounting[trade_id]"
                                        id="trade_id">
                                    @include('site::trade.options', ['trade_id' => old('mounting.trade_id', isset($trade_id) ? $trade_id : null)])
                                </select>
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible mt-1">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            ×
                                        </button>
                                        <p class="mb-0">
                                            <i class="icon mr-2 fa fa-check"></i>
                                            {!! session('success') !!}
                                        </p>
                                    </div>
                                @endif
                                <span class="invalid-feedback">{{ $errors->first('mounting.trade_id') }}</span>
                            </div>
                            <div class="form-group required">
                                <label class="control-label"
                                       for="date_trade">@lang('site::mounting.date_trade')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_date_trade"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="mounting[date_trade]"
                                           id="date_trade"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::mounting.placeholder.date_trade')"
                                           data-target="#datetimepicker_date_trade"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('mounting.date_trade') ? ' is-invalid' : '' }}"
                                           value="{{ old('mounting.date_trade') }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_date_trade"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('mounting.date_trade') }}</span>
                            </div>
                        </div>
                    </div>

                    {{--ВЫЕЗД НА ОБСЛУЖИВАНИЕ --}}

                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::mounting.header.call')</h5>
                            <div class="form-group required" id="form-group-engineer_id">
                                <label class="control-label"
                                       for="engineer_id">@lang('site::mounting.engineer_id')</label>
                                <select required
                                        data-form-action="{{ route('engineers.create', ['certificate_type_id' => 1]) }}"
                                        data-btn-ok="@lang('site::messages.save')"
                                        data-btn-cancel="@lang('site::messages.cancel')"
                                        data-options="#engineer_id_options"
                                        data-label="@lang('site::messages.add') @lang('site::engineer.engineer')"
                                        class="dynamic-modal-form form-control{{  $errors->has('mounting.engineer_id') ? ' is-invalid' : '' }}"
                                        name="mounting[engineer_id]"
                                        id="engineer_id">
                                    @include('site::engineer.options', ['certificate_type_id' => 2, 'engineer_id' => old('mounting.engineer_id', isset($engineer_id) ? $engineer_id : null)])
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounting.engineer_id') }}</span>
                            </div>
                            <div class="form-group required">
                                <label class="control-label"
                                       for="date_mounting">@lang('site::mounting.date_mounting')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_date_mounting"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="mounting[date_mounting]"
                                           id="date_mounting"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::mounting.placeholder.date_mounting')"
                                           data-target="#datetimepicker_date_mounting"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('mounting.date_mounting') ? ' is-invalid' : '' }}"
                                           value="{{ old('mounting.date_mounting') }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_date_mounting"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('mounting.date_mounting') }}</span>
                            </div>
                        </div>
                    </div>

                    {{--ОПЛАТА --}}

                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::mounting.header.payment')</h5>
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group required">
                                        <label class="control-label" for="product_id">
                                            @lang('site::mounting.product_id')
                                        </label>
                                        <select required
                                                id="product_id"
                                                name="mounting[product_id]"
                                                style="width:100%"
                                                class="form-control">
                                            <option></option>
                                            @foreach($products as $product)
                                                <option @if(old('mounting.product_id') == $product->id)
                                                        selected
                                                        @endif
                                                        data-sku="{{$product->sku}}"
                                                        data-bonus="{{$product->mounting_bonus ? $product->mounting_bonus->value : 0}}"
                                                        data-social-bonus="{{$product->mounting_bonus ? $product->mounting_bonus->social : 0}}"
                                                        value="{{$product->id}}">
                                                    {{$product->name}} / {{$product->sku}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small id="product_idHelp" class="d-block form-text text-success">
                                            @lang('site::mounting.placeholder.product_id')
                                        </small>
                                        <span class="invalid-feedback">{{ $errors->first('mounting.product_id') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"
                                               for="serial_id">@lang('site::mounting.serial_id')</label>
                                        <input type="text"
                                               name="mounting[serial_id]"
                                               id="serial_id"
                                               class="form-control{{ $errors->has('mounting.serial_id') ? ' is-invalid' : '' }}"
                                               placeholder="@lang('site::mounting.placeholder.serial_id')"
                                               maxlength="20"
                                               value="{{ old('mounting.serial_id') }}">
                                        <span class="invalid-feedback">{{ $errors->first('mounting.serial_id') }}</span>

                                    </div>

                                    <div class="form-group required">
                                        <label class="control-label"
                                               for="contragent_id">@lang('site::mounting.contragent_id')</label>
                                        <div class="input-group">
                                            <select required
                                                    class="form-control{{  $errors->has('mounting.contragent_id') ? ' is-invalid' : '' }}"
                                                    name="mounting[contragent_id]"
                                                    id="contragent_id">
                                                @if($contragents->count() == 0 || $contragents->count() > 1)
                                                    <option value="">@lang('site::messages.select_from_list')</option>
                                                @endif
                                                @foreach($contragents as $contragent)
                                                    <option
                                                            @if(old('mounting.contragent_id') == $contragent->id) selected
                                                            @endif
                                                            value="{{ $contragent->id }}">
                                                        {{ $contragent->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fa fa-@lang('site::contragent.icon')"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">{{ $errors->first('mounting.contragent_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="mounting-product">
                                    {{--<input type="hidden" name="mounting[product_id]"--}}
                                    {{--value="{{old('mounting.product_id', $product['id'])}}"/>--}}
                                    <dl class="row">

                                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.name')</dt>
                                        <dd class="col-sm-8" id="product-name">{{$selected_product->name}}</dd>
                                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.sku')</dt>
                                        <dd class="col-sm-8" id="product-sku">{{$selected_product->sku}}</dd>
                                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.bonus')</dt>
                                        <dd class="col-sm-8"
                                            id="product-bonus">{{$selected_product->mounting_bonus ? $selected_product->mounting_bonus->value : (!is_null(old('mounting.product_id')) ? trans('site::mounting.error.product_id') : '')}}</dd>
                                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounting.social_bonus')</dt>
                                        <dd class="col-sm-8" id="product-social-bonus">
                                            {{$selected_product->mounting_bonus ? $selected_product->mounting_bonus->social : (!is_null(old('mounting.product_id')) ? trans('site::mounting.error.product_id') : '')}}
                                        </dd>
                                    </dl>
                                </div>
                            </div>


                        </div>
                    </div>

                    {{--ДОПОЛНИТЕЛЬНО --}}

                    <div class="card my-2">
                        <div class="card-body">
                            <h5 class="card-title">@lang('site::mounting.header.extra')</h5>

                            <div class="form-group required">
                                <label class="control-label"
                                       for="mounting_source_id">@lang('site::mounting.source_id')</label>
                                <select class="form-control{{  $errors->has('mounting.source_id') ? ' is-invalid' : '' }}"
                                        {{--required--}}
                                        name="mounting[source_id]"
                                        id="mounting_source_id">
                                    @if($mounting_sources->count() == 0 || $mounting_sources->count() > 1)
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                    @endif
                                    @foreach($mounting_sources as $mounting_source)
                                        <option
                                                @if(old('mounting.source_id') == $mounting_source->id) selected
                                                @endif
                                                value="{{ $mounting_source->id }}">
                                            {{ $mounting_source->name }} {{ $mounting_source->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounting.source_id') }}</span>
                            </div>

                            <div class="form-group mt-2 @if(old('mounting.source_id') == 4) d-block @else d-none @endif">
                                <label class="control-label"
                                       for="mounting_source_other">@lang('site::mounting.source_other')</label>
                                <input type="text"
                                       id="mounting_source_other"
                                       name="mounting[source_other]"
                                       class="form-control{{ $errors->has('mounting.source_other') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounting.source_other') }}"
                                       placeholder="@lang('site::mounting.placeholder.source_other')">
                                <span class="invalid-feedback">{{ $errors->first('mounting.source_other') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label"
                                       for="social_url">@lang('site::mounting.social_url')</label>
                                <input type="text"
                                       id="social_url"
                                       name="mounting[social_url]"
                                       class="form-control{{ $errors->has('mounting.social_url') ? ' is-invalid' : '' }}"
                                       value="{{ old('mounting.social_url') }}"
                                       placeholder="@lang('site::mounting.placeholder.social_url')">
                                <span class="invalid-feedback">{{ $errors->first('mounting.social_url') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="comment">@lang('site::mounting.comment')</label>
                                <textarea
                                        class="form-control{{ $errors->has('mounting.comment') ? ' is-invalid' : '' }}"
                                        placeholder="@lang('site::mounting.placeholder.comment')"
                                        name="mounting[comment]"
                                        id="comment">{{ old('mounting.comment') }}</textarea>
                                <span class="invalid-feedback">{{ $errors->first('mounting.comment') }}</span>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <h5 class="card-title">@lang('site::file.files')</h5>
                        <h6 class="card-subtitle mb-2 text-muted">@lang('site::file.maxsize5mb')</h6>
                        @include('site::file.create.type')
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <div class="form-row required">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input required
                                           form="form"
                                           type="checkbox"
                                           name="accept"
                                           @if(old('accept') == 1) checked @endif
                                           value="1"
                                           class="custom-control-input{{ $errors->has('accept') ? ' is-invalid' : '' }}"
                                           id="accept">
                                    <label class="custom-control-label" for="accept">
                                        <span style="color:red;margin-right: 2px;">*</span>
                                        @lang('site::mounting.accept')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col text-right">
                                <button form="form"
                                        type="submit"
                                        class="btn btn-ferroli mb-1">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('mountings.index') }}" class="btn btn-secondary mb-1">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    try {
        window.addEventListener('load', function () {

            let product_id = $('#product_id');

            product_id.select2({
                theme: "bootstrap4",
                placeholder: '@lang('site::messages.select_from_list')',
                selectOnClose: true,
                minimumInputLength: 3,
            });

            product_id.on('select2:select', function (e) {
                let data = e.params.data;
                //console.log(data);
                $('#product-name').html(data.text);
                $('#product-sku').html(data.element.getAttribute('data-sku'));
                let bonus = data.element.getAttribute('data-bonus'),
                    social = data.element.getAttribute('data-social-bonus');
                $('#product-bonus').html(bonus === '0' ? '@lang('site::mounting.error.product_id')' : bonus);
                $('#product-social-bonus').html(social === '0' ? '@lang('site::mounting.error.product_id')' : social);
            });
        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush
