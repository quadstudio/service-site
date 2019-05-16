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
                <a href="{{ route('admin.events.index') }}">@lang('site::event.events')</a>
            </li>
            @if($event->exists)
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.events.show', $event) }}">{{$event->title}}</a>
                </li>
            @endif
            <li class="breadcrumb-item active">@lang('site::messages.add') @lang('site::member.member')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::member.member')</h1>
        @alert()@endalert
        <div class="card mb-5">
            <div class="card-body" id="summernote">
                <form id="form-content" method="POST" action="{{ route('admin.members.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('member.show_ferroli')) checked @endif
                                               class="custom-control-input{{  $errors->has('member.show_ferroli') ? ' is-invalid' : '' }}"
                                               id="show_ferroli"
                                               name="member[show_ferroli]">
                                        <label class="custom-control-label"
                                               for="show_ferroli">@lang('site::messages.show_ferroli')</label>
                                        <span class="invalid-feedback">{{ $errors->first('member.show_ferroli') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('member.show_lamborghini')) checked
                                               @endif
                                               class="custom-control-input{{  $errors->has('member.show_lamborghini') ? ' is-invalid' : '' }}"
                                               id="show_lamborghini"
                                               name="member[show_lamborghini]">
                                        <label class="custom-control-label"
                                               for="show_lamborghini">@lang('site::messages.show_lamborghini')</label>
                                        <span class="invalid-feedback">{{ $errors->first('member.show_lamborghini') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               @if(old('member.verified')) checked @endif
                                               class="custom-control-input{{  $errors->has('member.verified') ? ' is-invalid' : '' }}"
                                               id="verified"
                                               name="member[verified]">
                                        <label class="custom-control-label"
                                               for="verified">@lang('site::member.verified')</label>
                                        <span class="invalid-feedback">{{ $errors->first('member.verified') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label class="control-label" for="status_id">@lang('site::member.status_id')</label>
                            <select class="form-control{{  $errors->has('member.status_id') ? ' is-invalid' : '' }}"
                                    name="member[status_id]"
                                    id="status_id">
                                @foreach($member_statuses as $member_status)
                                    <option
                                            @if(old('member.status_id', $event->status_id) == $member_status->id)
                                            selected
                                            @endif
                                            value="{{ $member_status->id }}">{{ $member_status->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('member.status_id') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label class="control-label" for="event_id">@lang('site::member.event_id')</label>
                            <select class="form-control{{  $errors->has('member.event_id') ? ' is-invalid' : '' }}"
                                    name="member[event_id]"
                                    id="event_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($member_events as $member_event)
                                    <option
                                            @if(old('member.event_id', $event->id) == $member_event->id)
                                            selected
                                            @endif
                                            value="{{ $member_event->id }}">
                                        {{ $member_event->date_from->format('d.m.Y') }} /
                                        {{ $member_event->type->name }} /
                                        {{ $member_event->title }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('member.event_id') }}</span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col required">
                            <label class="control-label" for="type_id">@lang('site::member.type_id')</label>
                            <select class="form-control{{  $errors->has('member.type_id') ? ' is-invalid' : '' }}"
                                    name="member[type_id]"
                                    required
                                    id="type_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($member_types as $member_type)
                                    <option
                                            @if(old('member.type_id', $event->type_id) == $member_type->id)
                                            selected
                                            @endif
                                            value="{{ $member_type->id }}">{{ $member_type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('member.type_id') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col required">

                                    <label class="control-label" for="region_id">@lang('site::member.region_id')</label>
                                    <select required
                                            class="form-control{{  $errors->has('member.region_id') ? ' is-invalid' : '' }}"
                                            name="member[region_id]"
                                            id="region_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($regions as $region)
                                            <option
                                                    @if(old('member.region_id', $event->region_id) == $region->id)
                                                    selected
                                                    @endif
                                                    value="{{ $region->id }}">{{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('member.region_id') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="city">@lang('site::member.city')</label>
                                    <input required
                                           type="text"
                                           name="member[city]"
                                           id="city"
                                           class="form-control{{ $errors->has('member.city') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.city')"
                                           value="{{ old('member.city', $event->city) }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.city') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class=" mt-3">@lang('site::member.date')</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label class="control-label"
                                       for="date_from">@lang('site::messages.date_from')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_date_from"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="member[date_from]"
                                           id="date_from"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::member.placeholder.date_from')"
                                           data-target="#datetimepicker_date_from"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('member.date_from') ? ' is-invalid' : '' }}"
                                           value="{{ old('member.date_from') }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_date_from"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('member.date_from') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label class="control-label"
                                       for="date_to">@lang('site::messages.date_to')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_date_to"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="member[date_to]"
                                           id="date_to"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::member.placeholder.date_to')"
                                           data-target="#datetimepicker_date_to"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('member.date_to') ? ' is-invalid' : '' }}"
                                           value="{{ old('member.date_to') }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_date_to"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('member.date_to') }}</span>
                            </div>
                        </div>
                    </div>
                    <h4 class=" mt-3">@lang('site::member.header.name')</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="name">@lang('site::member.name')</label>
                                    <input required
                                           type="text"
                                           name="member[name]"
                                           id="name"
                                           maxlength="255"
                                           class="form-control{{ $errors->has('member.name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.name')"
                                           value="{{ old('member.name') }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="email">@lang('site::member.email')</label>
                                    <input required
                                           type="email"
                                           name="member[email]"
                                           id="email"
                                           maxlength="50"
                                           class="form-control{{ $errors->has('member.email') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.email')"
                                           value="{{ old('member.email') }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.email') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label" for="contact">@lang('site::member.contact')</label>
                                    <input required
                                           type="text"
                                           name="member[contact]"
                                           id="contact"
                                           maxlength="255"
                                           class="form-control{{ $errors->has('member.contact') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.contact')"
                                           value="{{ old('member.contact') }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.contact') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3 required">
                                    <label class="control-label" for="country_id">@lang('site::member.country_id')</label>
                                    <select required
                                            name="member[country_id]"
                                            id="country_id"
                                            class="form-control{{  $errors->has('member.country_id') ? ' is-invalid' : '' }}">
                                        @if($countries->count() == 0 || $countries->count() > 1)
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                        @endif
                                        @foreach($countries as $country)
                                            <option @if(old('member.country_id') == $country->id)
                                                    selected
                                                    @endif
                                                    value="{{ $country->id }}">
                                                {{ $country->name }}
                                                {{ $country->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('member.country_id') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="phone">@lang('site::member.phone')</label>
                                    <input required
                                           type="tel"
                                           name="member[phone]"
                                           id="phone"
                                           oninput="mask_phones()"
                                           pattern="{{config('site.phone.pattern')}}"
                                           maxlength="{{config('site.phone.maxlength')}}"
                                           title="{{config('site.phone.format')}}"
                                           data-mask="{{config('site.phone.mask')}}"
                                           class="phone-mask form-control{{ $errors->has('member.phone') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.phone')"
                                           value="{{ old('member.phone') }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.phone') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="count">@lang('site::member.count')</label>
                                    <input required
                                           type="number"
                                           name="member[count]"
                                           id="count"
                                           maxlength="2"
                                           step="1"
                                           min="1"
                                           max="50"
                                           class="form-control{{ $errors->has('member.count') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.count')"
                                           value="{{ old('member.count') }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.count') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col">
                                    <label class="control-label" for="address">@lang('site::member.address')</label>
                                    <input type="text"
                                           name="member[address]"
                                           id="address"
                                           maxlength="255"
                                           class="form-control{{ $errors->has('member.address') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.address')"
                                           value="{{ old('member.address') }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.address') }}</span>
                                    <small class="mb-4 form-text text-success">
                                        @lang('site::member.help.address')
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr/>
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="form-content" value="1" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::member.help.save')</span>
                        </button>
                        <button name="_create" form="form-content" value="0" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        @if($event->exists)
                            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-secondary mb-1">
                                <i class="fa fa-close"></i>
                                <span>@lang('site::messages.cancel')</span>
                            </a>
                        @else
                            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary mb-1">
                                <i class="fa fa-close"></i>
                                <span>@lang('site::messages.cancel')</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection