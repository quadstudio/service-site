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
                <a href="{{ route('contracts.index') }}">@lang('site::contract.contracts')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('contracts.show', $contract) }}">{{$contract->number}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::contract.contract')  {{ $contract->number }}</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="address-form" method="POST"
                      action="{{ route('contracts.update', $contract) }}">

                    @csrf
                    @method('PUT')
                    <input type="hidden" name="contract[automatic]" value="{{(int)$contract->automatic}}"/>
                    <div class="form-row mt-3 required">
                        <div class="col">
                            <label class="control-label" for="name">@lang('site::contract.number')</label>
                            <input required
                                   type="text"
                                   name="contract[number]"
                                   id="number"
                                   class="form-control{{ $errors->has('contract.number') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contract.placeholder.number')"
                                   value="{{ old('contract.number', $contract->number) }}">
                            <span class="invalid-feedback">{{ $errors->first('contract.number') }}</span>
                        </div>
                    </div>
                    <div class="form-group required ">
                        <label class="control-label"
                               for="date">@lang('site::contract.date')</label>
                        <div class="input-group date datetimepicker" id="datetimepicker_date"
                             data-target-input="nearest">
                            <input type="text"
                                   name="contract[date]"
                                   id="date"
                                   maxlength="10"
                                   required
                                   placeholder="@lang('site::contract.placeholder.date')"
                                   data-target="#datetimepicker_date"
                                   data-toggle="datetimepicker"
                                   class="datetimepicker-input form-control{{ $errors->has('contract.date') ? ' is-invalid' : '' }}"
                                   value="{{ old('contract.date', $contract->date->format('d.m.Y')) }}">
                            <div class="input-group-append"
                                 data-target="#datetimepicker_date"
                                 data-toggle="datetimepicker">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <span class="invalid-feedback">{{ $errors->first('contract.date') }}</span>
                    </div>

                    <div class="form-group required">
                        <label class="control-label"
                               for="contract_type_id">@lang('site::contract.type_id')</label>
                        <select required
                                class="form-control{{  $errors->has('contract.type_id') ? ' is-invalid' : '' }}"
                                name="contract[type_id]"
                                id="contract_type_id">
                            <option value="{{ $contract_type->id }}">{{ $contract_type->name }}</option>
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('contract.type_id') }}</span>
                    </div>

                    <div class="form-row required">
                        <div class="col">

                            <label class="control-label"
                                   for="contragent_id">@lang('site::contract.contragent_id')</label>
                            <select class="form-control{{  $errors->has('contract.contragent_id') ? ' is-invalid' : '' }}"
                                    name="contract[contragent_id]"
                                    required
                                    id="contragent_id">
                                @if($contragents->count() == 0 || $contragents->count() > 1)
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                @endif
                                @foreach($contragents as $contragent)
                                    <option
                                            @if(old('contract.contragent_id') == $contragent->id) selected
                                            @endif
                                            value="{{ $contragent->id }}">{{ $contragent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('contract.contragent_id') }}</span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="territory">@lang('site::contract.territory')</label>
                            <input required
                                   type="text"
                                   name="contract[territory]"
                                   id="territory"
                                   maxlength="255"
                                   class="form-control{{ $errors->has('contract.territory') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contract.placeholder.territory')"
                                   value="{{ old('contract.territory', $contract->territory) }}">
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contract.territory') }}</strong>
                                    </span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="signer">@lang('site::contract.signer')</label>
                            <input required
                                   type="text"
                                   name="contract[signer]"
                                   id="signer"
                                   maxlength="255"
                                   class="form-control{{ $errors->has('contract.signer') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contract.placeholder.signer')"
                                   value="{{ old('contract.signer', $contract->signer) }}">
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contract.signer') }}</strong>
                                    </span>
                        </div>
                    </div>

                    <div class="form-row required">
                        <div class="col">
                            <label class="control-label" for="phone">@lang('site::contract.phone')</label>
                            <input required
                                   type="text"
                                   name="contract[phone]"
                                   id="phone"
                                   maxlength="50"
                                   class="form-control{{ $errors->has('contract.phone') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contract.placeholder.phone')"
                                   value="{{ old('contract.phone', $contract->phone) }}">
                            <span class="invalid-feedback">{{ $errors->first('contract.phone') }}</span>
                        </div>
                    </div>

                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="address-form" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('contracts.show', $contract) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection