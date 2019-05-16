@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('event_types.show', $event->type) }}">{{$event->type->name}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('events.show', $event) }}">{{$event->title}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.leave') @lang('site::member.member')</li>
        </ol>

        <h1 class="header-title mb-4">@lang('site::messages.leave') @lang('site::member.member')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body" id="summernote">

                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.event_id')</dt>
                    <dd class="col-sm-8 text-large">{{$event->title}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.region_id')</dt>
                    <dd class="col-sm-8">{{$event->region->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.city')</dt>
                    <dd class="col-sm-8">{{$event->city}}</dd>
                    @if($event->hasAddress())
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.address')</dt>
                        <dd class="col-sm-8">{{$event->address}}</dd>
                    @endif
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.date')</dt>
                    <dd class="col-sm-8">
                        @if($event->date_from == $event->date_to)
                            {{ $event->date_from->format('d.m.Y') }}
                        @else
                            @lang('site::event.date_from') {{ $event->date_from->format('d.m.Y') }}
                            @lang('site::event.date_to') {{ $event->date_to->format('d.m.Y') }}
                        @endif
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right"></dt>
                    <dd class="col-sm-8">
                        <div class="bg-lightest font-italic p-4 text-big">{{$event->annotation }}</div>
                    </dd>

                </dl>

                <form id="form-content" method="POST" action="{{ route('members.store') }}">
                    @csrf

                    <input type="hidden" name="member[event_id]" value="{{$event->id}}"/>
                    <input type="hidden" name="member[type_id]" value="{{$event->type_id}}"/>
                    <input type="hidden" name="member[region_id]" value="{{$event->region_id}}"/>
                    <input type="hidden" name="member[city]" value="{{$event->city}}"/>
                    <input type="hidden" name="member[{{config('site.check_field')}}]" value="1"/>

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
                                           value="{{ old('event.date_from', $event->date_from->format('d.m.Y')) }}">
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
                                           value="{{ old('member.date_to', $event->date_to->format('d.m.Y')) }}">
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
                        <a href="{{ route('events.show', $event) }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection