@extends('layouts.app')

@section('title')@lang('site::event.events')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::messages.leave'). ' '.__('site::member.member'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('event_types.show', $event_type), 'name' =>$event_type->name],
            ['name' => __('site::messages.leave'). ' '.__('site::member.member')]
        ]
    ])

@endsection

@section('content')
    <div class="container">

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body" id="summernote">

                <form id="form-content" method="POST" action="{{ route('members.store') }}">
                    @csrf

                    <input type="hidden" name="member[type_id]" value="{{$event_type->id}}"/>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3 required">

                                    <label class="control-label"
                                           for="region_id">@lang('site::member.region_id')</label>
                                    <select required
                                            class="form-control{{  $errors->has('event_id') ? ' is-invalid' : '' }}"
                                            name="member[region_id]"
                                            id="region_id">
                                        <option value="">@lang('site::messages.select_from_list')</option>
                                        @foreach($regions as $region)
                                            <option
                                                    @if(old('member.region_id') == $region->id)
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
                                <div class="col mb-3">
                                    <label class="control-label" for="city">@lang('site::member.city')</label>
                                    <input required
                                           type="text"
                                           name="member[city]"
                                           id="city"
                                           class="form-control{{ $errors->has('member.city') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.city')"
                                           value="{{ old('member.city') }}">
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
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
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
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="email">@lang('site::member.email')</label>
                                    <input type="email"
                                           name="member[email]"
                                           id="email"
                                           required
                                           maxlength="50"
                                           class="form-control{{ $errors->has('member.email') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::member.placeholder.email')"
                                           value="{{ old('member.email') }}">
                                    <span class="invalid-feedback">{{ $errors->first('member.email') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
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
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-row required">
                                        <div class="col mb-3 required">
                                            <label class="control-label"
                                                   for="country_id">@lang('site::member.country_id')</label>
                                            <select required
                                                    name="member[country_id]"
                                                    id="country_id"
                                                    class="form-control{{  $errors->has('member.country_id') ? ' is-invalid' : '' }}">
                                                @if($countries->count() != 1)
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
                                <div class="col-md-8">
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="count">@lang('site::member.count')</label>
                                    <input type="number"
                                           name="member[count]"
                                           id="count"
                                           maxlength="2"
                                           required
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
                                <div class="col mb-3">
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


                    <h4 class=" mt-3">@lang('site::participant.help.list_h')</h4>
                    <span class="text-success">@lang('site::member.help.participants')</span>

                    <fieldset id="participants-list">
                        @if( is_array(old('participant')) )
                            @foreach(old('participant') as $random => $participant)
                                @include('site::participant.create', compact('random'))
                            @endforeach
                        @endif
                    </fieldset>

                    <div class="form-row mt-3">
                        <div class="col text-left">

                            <a href="javascript:void(0);" class="btn btn-ferroli mb-1 participant-add"
                               data-action="{{route('participants.create')}}">
                                <i class="fa fa-plus"></i>
                                <span>@lang('site::messages.add') @lang('site::participant.participant')</span>
                            </a>
                        </div>
                    </div>
                </form>

                <hr/>
                <div class="form-row">
                    <div class="col text-right">

                        <button form="form-content" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('event_types.show', $event_type) }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection