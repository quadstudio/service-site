@extends('layouts.app')
@section('title')@lang('site::register.title')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::register.title'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::register.title')]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        @if ($errors->any())
            <h4 class="alert-heading">@lang('site::register.help.mail')</h4>
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('site::messages.has_error')</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row pt-5 pb-5">
            <div class="col">
                <form id="register-form" method="POST" action="{{ route('register_fl') }}">
                    @csrf
					<h4 class="my-4" id="sc_info">@lang('site::user.contact')</h4>
                    <div class="form-row required">
                        <div class="col">
						<input type="hidden" name="contact[type_id]" value="1">
						    <input type="text"
                                   name="name"
                                   id="name"
                                   required
                                   class="form-control form-control-lg
                                    {{ $errors->has('name')
                                    ? ' is-invalid'
                                    : (old('name') ? ' is-valid' : '') }}"
                                   placeholder="@lang('site::user.placeholder.name_fl')"
                                   value="{{ old('name') }}">
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-row">
                                <div class="col">
                                    <label class="control-label"
                                           for="contact_position">@lang('site::user.position_fl')</label>
                                    <input type="text" name="contact[position]" id="contact_position"
                                           class="form-control{{ $errors->has('contact.position') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::user.placeholder.position_fl')"
                                           value="{{ old('contact.position') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contact.position') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-row required">
                                <div class="col">

                                    <label class="control-label"
                                           for="phone_contact_country_id">@lang('site::phone.country_id')</label>
                                    <select class="form-control{{  $errors->has('phone.contact.country_id') ? ' is-invalid' : (old('phone.contact.country_id') ? ' is-valid' : '') }}"
                                            required
                                            name="phone[contact][country_id]"
                                            id="phone_contact_country_id">
                                        @foreach($countries as $country)
                                            <option
                                                    @if(old('phone.contact.country_id') == $country->id) selected
                                                    @endif
                                                    value="{{ $country->id }}">{{ $country->name }}
                                                ({{ $country->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone.contact.country_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="phone_contact_number">@lang('site::phone.number')</label>
                                    <input required
                                           type="tel"
                                           name="phone[contact][number]"
                                           id="phone_contact_number"
                                           oninput="mask_phones()"
                                           pattern="{{config('site.phone.pattern')}}"
                                           maxlength="{{config('site.phone.maxlength')}}"
                                           title="{{config('site.phone.format')}}"
                                           data-mask="{{config('site.phone.mask')}}"
                                           class="phone-mask form-control{{ $errors->has('phone.contact.number') ? ' is-invalid' : (old('phone.contact.number') ? ' is-valid' : '') }}"
                                           placeholder="@lang('site::phone.placeholder.number')"
                                           value="{{ old('phone.contact.number') }}">
                                    <span class="invalid-feedback">{{ $errors->first('phone.contact.number') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row">
                                <div class="col">
                                    <label class="control-label"
                                           for="phone_contact_extra">@lang('site::phone.extra')</label>
                                    <input type="text"
                                           name="phone[contact][extra]"
                                           id="phone_contact_extra"
                                           class="form-control{{ $errors->has('phone.contact.extra') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::phone.placeholder.extra')"
                                           value="{{ old('phone.contact.extra') }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone.contact.extra') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <h4 class="my-4">@lang('site::address.header.state')</h4>
                            <div class="form-row required">
                                    <div class="col">
                                        <input type="hidden"
                                               name="address[sc][type_id]"
                                               value="2">
                                        <label class="control-label"
                                               for="address_sc_country_id">@lang('site::address.country_id')</label>
                                        <select class="country-select form-control{{  $errors->has('address.sc.country_id') ? ' is-invalid' : '' }}"
                                                name="address[sc][country_id]"
                                                required
                                                data-regions="#address_sc_region_id"
                                                data-empty="@lang('site::messages.select_from_list')"
                                                id="address_sc_country_id">
                                            @foreach($countries as $country)
                                                <option
                                                        @if(old('address.sc.country_id') == $country->id) selected
                                                        @endif
                                                        value="{{ $country->id }}">{{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('address.sc.country_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-row required">
                                    <div class="col required">

                                        <label class="control-label"
                                               for="address_sc_region_id">@lang('site::address.region_id')</label>
                                        <select class="form-control{{  $errors->has('address.sc.region_id') ? ' is-invalid' : '' }}"
                                                name="address[sc][region_id]"
                                                required
                                                id="address_sc_region_id">
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                            @foreach($address_sc_regions as $region)
                                                <option
                                                        @if(old('address.sc.region_id') == $region->id) selected
                                                        @endif
                                                        value="{{ $region->id }}">{{ $region->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">{{ $errors->first('address.sc.region_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-row required">
                                    <div class="col">
                                        <label class="control-label"
                                               for="address_sc_locality">@lang('site::address.locality')</label>
                                        <input type="text"
                                               name="address[sc][locality]"
                                               id="address_sc_locality"
                                               required
                                               class="form-control{{ $errors->has('address.sc.locality') ? ' is-invalid' : '' }}"
                                               placeholder="@lang('site::address.placeholder.locality')"
                                               value="{{ old('address.sc.locality') }}">
                                        <span class="invalid-feedback">{{ $errors->first('address.sc.locality') }}</span>
                                    </div>
                                </div>
                            

                        </div>
						
						
						
                        <div class="col-md-6">

                            
                        </div>
                    </div>

                    <h4 class="my-4" id="company_info">@lang('site::user.header.info')</h4>

                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="email">@lang('site::user.email')</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   required
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::user.placeholder.email')"
                                   value="{{ old('email') }}">
                            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            <small id="emailHelp" class="form-text text-success">
                                @lang('site::user.help.email')
                            </small>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="password">@lang('site::user.password')</label>
                            <input type="password"
                                   name="password"
                                   required
                                   id="password"
                                   minlength="6"
                                   maxlength="20"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::user.placeholder.password')"
                                   value="{{ old('password') }}">
                            <span class="invalid-feedback">{{ $errors->first('password') }}</span>

                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label"
                                   for="password-confirmation">@lang('site::user.password_confirmation')</label>
                            <input id="password-confirmation"
                                   type="password"
                                   required
                                   class="form-control"
                                   placeholder="@lang('site::user.placeholder.password_confirmation')"
                                   name="password_confirmation">
                        </div>
                    </div>

                    <hr class="my-4"/>

                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label"
                                   for="captcha">@lang('site::register.captcha')</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text"
                                           name="captcha"
                                           required
                                           id="captcha"
                                           class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::register.placeholder.captcha')"
                                           value="">
                                    <span class="invalid-feedback">{{ $errors->first('captcha') }}</span>
                                </div>
                                <div class="col-md-9 captcha">
                                    <span>{!! captcha_img('flat') !!}</span>
                                    <button data-toggle="tooltip" data-placement="top"
                                            title="@lang('site::messages.refresh')" type="button"
                                            class="btn btn-outline-secondary" id="captcha-refresh">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="accept" required value="1" class="custom-control-input"
                                       id="accept">
                                <label class="custom-control-label" for="accept"><span
                                            style="color:red;margin-right: 2px;">*</span>@lang('site::register.accept')
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row text-center mt-5 mb-3">
                        <div class="col">
                            <button class="btn btn-ferroli" type="submit">@lang('site::user.sign_up')</button>
                        </div>
                    </div>
                </form>
                <div class="text-center">
                    <a class="d-block" href="{{route('login')}}">@lang('site::user.already')</a>
                </div>
                <div class="text-center mb-3">
                    <h5>@lang('site::register.help.mail')</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script defer>
    try {
        document.querySelector('#captcha-refresh').addEventListener('click', function () {
            fetch('/captcha/flat')
                .then(response => {
                    response.blob().then(blobResponse => {
                        const urlCreator = window.URL || window.webkitURL;
                        document.querySelector('.captcha span img').src = urlCreator.createObjectURL(blobResponse);
                    });
                });
        });
        
    } catch (e) {
        console.log(e);
    }
</script>
@endpush
