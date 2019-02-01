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

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label d-block"
                                   for="user_verified">@lang('site::member.verified')</label>
                            <div class="custom-control custom-radio  custom-control-inline">
                                <input class="custom-control-input
                                                    {{$errors->has('verified') ? ' is-invalid' : ''}}"
                                       type="radio"
                                       name="verified"
                                       required
                                       @if(old('verified', 0) == 1) checked @endif
                                       id="verified_1"
                                       value="1">
                                <label class="custom-control-label"
                                       for="verified_1">@lang('site::messages.yes')</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input
                                                    {{$errors->has('verified') ? ' is-invalid' : ''}}"
                                       type="radio"
                                       name="verified"
                                       required
                                       @if(old('verified', 0) == 0) checked @endif
                                       id="verified_0"
                                       value="0">
                                <label class="custom-control-label"
                                       for="verified_0">@lang('site::messages.no')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">

                            <label class="control-label" for="status_id">@lang('site::member.status_id')</label>
                            <select class="form-control{{  $errors->has('event_id') ? ' is-invalid' : '' }}"
                                    name="status_id"
                                    id="status_id">
                                @foreach($statuses as $status)
                                    <option
                                            @if(old('status_id', $event->status_id) == $status->id)
                                            selected
                                            @endif
                                            value="{{ $status->id }}">{{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('status_id') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">

                            <label class="control-label" for="event_id">@lang('site::member.event_id')</label>
                            <select class="form-control{{  $errors->has('event_id') ? ' is-invalid' : '' }}"
                                    name="event_id"
                                    id="event_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($events as $e)
                                    <option
                                            @if(old('event_id', $event->id) == $e->id)
                                            selected
                                            @endif
                                            value="{{ $e->id }}">
                                        {{ $e->date_from() }} / {{ $e->type->name }} / {{ $e->title }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('event_id') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col mb-3 required">

                            <label class="control-label" for="type_id">@lang('site::member.type_id')</label>
                            <select class="form-control{{  $errors->has('type_id') ? ' is-invalid' : '' }}"
                                    name="type_id"
                                    required
                                    id="type_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($types as $type)
                                    <option
                                            @if(old('type_id', $event->type_id) == $type->id)
                                            selected
                                            @endif
                                            value="{{ $type->id }}">{{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3 required">

                                    <label class="control-label" for="region_id">@lang('site::member.region_id')</label>
                                    <select class="form-control{{  $errors->has('event_id') ? ' is-invalid' : '' }}"
                                            name="region_id"
                                            required
                                            id="region_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($regions as $region)
                                            <option
                                                    @if(old('region_id', $event->region_id) == $region->id)
                                                    selected
                                                    @endif
                                                    value="{{ $region->id }}">{{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('region_id') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="city">@lang('site::member.city')</label>
                                    <input type="text" name="city"
                                           id="city"
                                           required
                                           class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.city')"
                                           value="{{ old('city', $event->city) }}">
                                    <span class="invalid-feedback">{{ $errors->first('city') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class=" mt-3">@lang('site::member.header.date_from_to')</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label class="control-label"
                                       for="date_from">@lang('site::member.date_from')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_date_from"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="date_from"
                                           id="date_from"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::member.placeholder.date_from')"
                                           data-target="#datetimepicker_date_from"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('date_from') ? ' is-invalid' : '' }}"
                                           value="{{ old('date_from') }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_date_from"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('date_from') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label class="control-label"
                                       for="date_to">@lang('site::member.date_to')</label>
                                <div class="input-group date datetimepicker" id="datetimepicker_date_to"
                                     data-target-input="nearest">
                                    <input type="text"
                                           name="date_to"
                                           id="date_to"
                                           maxlength="10"
                                           required
                                           placeholder="@lang('site::member.placeholder.date_to')"
                                           data-target="#datetimepicker_date_to"
                                           data-toggle="datetimepicker"
                                           class="datetimepicker-input form-control{{ $errors->has('date_to') ? ' is-invalid' : '' }}"
                                           value="{{ old('date_to') }}">
                                    <div class="input-group-append"
                                         data-target="#datetimepicker_date_to"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('date_to') }}</span>
                            </div>
                        </div>
                    </div>

                    <h4 class=" mt-3">@lang('site::member.header.name')</h4>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="name">@lang('site::member.name')</label>
                                    <input type="text" name="name"
                                           id="name"
                                           required
                                           maxlength="255"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.name')"
                                           value="{{ old('name') }}">
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="email">@lang('site::member.email')</label>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           required
                                           maxlength="50"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.email')"
                                           value="{{ old('email') }}">
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="contact">@lang('site::member.contact')</label>
                                    <input type="text" name="contact"
                                           id="contact"
                                           required
                                           maxlength="255"
                                           class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.contact')"
                                           value="{{ old('contact') }}">
                                    <span class="invalid-feedback">{{ $errors->first('contact') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col">
                                    <label class="control-label"
                                           for="phone">@lang('site::member.phone')</label>
                                    <input type="tel"
                                           required
                                           name="phone"
                                           id="phone"
                                           title="@lang('site::member.placeholder.phone')"
                                           maxlength="10"
                                           class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.phone')"
                                           value="{{ old('phone') }}">
                                    <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="count">@lang('site::member.count')</label>
                                    <input type="number"
                                           name="count"
                                           id="count"
                                           maxlength="2"
                                           required
                                           step="1"
                                           min="1"
                                           max="50"
                                           class="form-control{{ $errors->has('count') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.count')"
                                           value="{{ old('count') }}">
                                    <span class="invalid-feedback">{{ $errors->first('count') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label" for="address">@lang('site::member.address')</label>
                                    <input type="text"
                                           name="address"
                                           id="address"
                                           maxlength="255"
                                           class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.address')"
                                           value="{{ old('address') }}">
                                    <span class="invalid-feedback">{{ $errors->first('address') }}</span>
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