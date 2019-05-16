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
                <a href="{{ route('admin.members.index') }}">@lang('site::member.members')</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('admin.members.show', $member) }}">{{$member->name}}</a>
            </li>

            <li class="breadcrumb-item active">@lang('site::participant.participants')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::participant.icon')"></i> @lang('site::participant.participants')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.participants.store', $member) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label" for="name">@lang('site::participant.name')</label>
                                    <input type="text"
                                           name="participant[name]"
                                           id="name"
                                           required
                                           maxlength="100"
                                           class="form-control{{ $errors->has('participant.name') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::participant.placeholder.name')"
                                           value="{{ old('participant.name') }}">
                                    <span class="invalid-feedback">{{ $errors->first('participant.name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="headposition">@lang('site::participant.headposition')</label>
                                    <input type="text"
                                           name="participant[headposition]"
                                           id="headposition"
                                           required
                                           maxlength="100"
                                           class="form-control{{ $errors->has('participant.headposition') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::participant.placeholder.headposition')"
                                           value="{{ old('participant.headposition') }}">
                                    <span class="invalid-feedback">{{ $errors->first('participant.headposition') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label" for="email">@lang('site::participant.email')</label>
                                    <input type="email"
                                           name="participant[email]"
                                           id="email"
                                           maxlength="50"
                                           class="form-control{{ $errors->has('participant.email') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::participant.placeholder.email')"
                                           value="{{ old('participant.email') }}">
                                    <span class="invalid-feedback">{{ $errors->first('participant.email') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3 ">
                                    <label class="control-label" for="country_id">@lang('site::member.country_id')</label>
                                    <select required
                                            name="participant[country_id]"
                                            id="country_id"
                                            class="form-control{{  $errors->has('participant.country_id') ? ' is-invalid' : '' }}">
                                        @if($countries->count() == 0 || $countries->count() > 1)
                                            <option value="">@lang('site::messages.select_from_list')</option>
                                        @endif
                                        @foreach($countries as $country)
                                            <option @if(old('participant.country_id') == $country->id)
                                                    selected
                                                    @endif
                                                    value="{{ $country->id }}">
                                                {{ $country->name }}
                                                {{ $country->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">{{ $errors->first('participant.country_id') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row ">
                                <div class="col">
                                    <label class="control-label"
                                           for="phone">@lang('site::participant.phone')</label>
                                    <input type="tel"
                                           name="participant[phone]"
                                           id="phone"
                                           oninput="mask_phones()"
                                           pattern="{{config('site.phone.pattern')}}"
                                           maxlength="{{config('site.phone.maxlength')}}"
                                           title="{{config('site.phone.format')}}"
                                           data-mask="{{config('site.phone.mask')}}"
                                           class="phone-mask form-control{{ $errors->has('participant.phone') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::participant.placeholder.phone')"
                                           value="{{ old('participant.phone') }}">
                                    <span class="invalid-feedback">{{ $errors->first('participant.phone') }}</span>
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
                            <span>@lang('site::messages.save_add')</span>
                        </button>
                        <button name="_create" form="form-content" value="0" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>

                        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>

                    </div>

                </div>

                <hr/>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>@lang('site::participant.name')</th>
                        <th>@lang('site::participant.headposition')</th>
                        <th>@lang('site::participant.phone')</th>
                        <th>@lang('site::participant.email')</th>
                        <th>@lang('site::messages.delete')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($member->participants as $participant)
                        <tr id="participant-{{$participant->id}}">
                            <td>{{$participant->name}}</td>
                            <td>{{$participant->headposition}}</td>
                            <td>
                                {{$participant->phoneNumber}}
                            </td>
                            <td>{{$participant->email}}</td>
                            <td>
                                <button
                                class=" btn btn-sm btn-danger btn-row-delete"
                                        data-form="#participant-delete-form-{{$participant->id}}"
                                        data-btn-delete="@lang('site::messages.delete')"
                                        data-btn-cancel="@lang('site::messages.cancel')"
                                        data-label="@lang('site::messages.delete_confirm')"
                                        data-message="@lang('site::messages.delete_sure') @lang('site::participant.participant')? "
                                        data-toggle="modal" data-target="#form-modal"
                                        href="javascript:void(0);" title="@lang('site::messages.delete')">
                                    @lang('site::messages.delete')
                                </button>
                                <form id="participant-delete-form-{{$participant->id}}"
                                      action="{{route('admin.participants.destroy', $participant)}}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection