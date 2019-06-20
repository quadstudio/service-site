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
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.show', $contragent->user) }}">{{$contragent->user->name}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.contragents.index', ['filter[user]='.$contragent->user_id]) }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.contragents.show', $contragent) }}">{{ $contragent->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{ $contragent->name }}</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="contragent-form" method="POST"
                      action="{{ route('admin.contragents.update', $contragent) }}">

                    @csrf
                    @method('PUT')

                    {{-- КОНТРАГЕНТ --}}

                    <h4 class=" mt-3" id="sc_info">@lang('site::contragent.header.contragent')</h4>

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="contragent_name">@lang('site::contragent.name')</label>
                            <input type="text"
                                   name="contragent[name]"
                                   id="contragent_name" required
                                   class="form-control{{ $errors->has('contragent.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contragent.placeholder.name')"
                                   value="{{ old('contragent.name', $contragent->name) }}">
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.name') }}</strong>
                                    </span>
                            <small id="contragent_nameHelp" class="form-text text-success">
                                @lang('site::contragent.help.name')
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_type_id">@lang('site::contragent.type_id')</label>
                                    @foreach($types as $type)
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                   name="contragent[type_id]"
                                                   id="contragent_type_id_{{ $type->id }}"
                                                   @if(old('contragent.type_id', $contragent->type_id) == $type->id) checked
                                                   @endif
                                                   value="{{ $type->id }}"
                                                   class="custom-control-input {{$errors->has('contragent.type_id') ? ' is-invalid' : ''}}">
                                            <label class="custom-control-label"
                                                   for="contragent_type_id_{{ $type->id }}">{{ $type->name }}</label>
                                        </div>
                                    @endforeach
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.type_id') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_nds">@lang('site::contragent.nds')</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio"
                                               id="contragent_nds_1"
                                               name="contragent[nds]"
                                               required
                                               @if(old('contragent.nds', $contragent->nds) == 1) checked @endif
                                               value="1"
                                               class="custom-control-input {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}">
                                        <label class="custom-control-label"
                                               for="contragent_nds_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio"
                                               id="contragent_nds_0"
                                               name="contragent[nds]"
                                               required
                                               @if(old('contragent.nds', $contragent->nds) == 0) checked @endif
                                               value="0"
                                               class="custom-control-input {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}">
                                        <label class="custom-control-label"
                                               for="contragent_nds_0">@lang('site::messages.no')</label>
                                    </div>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.nds') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_nds_act">@lang('site::contragent.nds_act')</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio"
                                               id="contragent_nds_act_1"
                                               name="contragent[nds_act]"
                                               required
                                               @if(old('contragent.nds_act', $contragent->nds_act) == 1) checked @endif
                                               value="1"
                                               class="custom-control-input {{$errors->has('contragent.nds_act') ? ' is-invalid' : ''}}">
                                        <label class="custom-control-label"
                                               for="contragent_nds_act_1">@lang('site::messages.yes')</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio"
                                               id="contragent_nds_act_0"
                                               name="contragent[nds_act]"
                                               required
                                               @if(old('contragent.nds_act', $contragent->nds_act) == 0) checked @endif
                                               value="0"
                                               class="custom-control-input {{$errors->has('contragent.nds_act') ? ' is-invalid' : ''}}">
                                        <label class="custom-control-label"
                                               for="contragent_nds_act_0">@lang('site::messages.no')</label>
                                    </div>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.nds_act') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4 mt-2" id="company_info">@lang('site::contragent.header.legal')</h4>
                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_inn">@lang('site::contragent.inn')</label>
                                    <input type="number"
                                           name="contragent[inn]"
                                           id="contragent_inn"
                                           maxlength="12"
                                           required
                                           pattern="\d{10}|\d{12}"
                                           class="form-control{{$errors->has('contragent.inn') ? ' is-invalid' : ''}}"
                                           placeholder="@lang('site::contragent.placeholder.inn')"
                                           value="{{ old('contragent.inn', $contragent->inn) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.inn') }}</strong>
                                    </span>
                                </div>

                            </div>


                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_ogrn">@lang('site::contragent.ogrn')</label>
                                    <input type="number"
                                           name="contragent[ogrn]"
                                           id="contragent_ogrn"
                                           maxlength="15"
                                           required
                                           pattern="\d{13}|\d{15}"
                                           class="form-control{{ $errors->has('contragent.ogrn') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.ogrn')"
                                           value="{{ old('contragent.ogrn', $contragent->ogrn) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.ogrn') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_okpo">@lang('site::contragent.okpo')</label>
                                    <input type="number"
                                           name="contragent[okpo]"
                                           id="contragent_okpo"
                                           maxlength="10"
                                           required
                                           pattern="\d{8}|\d{10}"
                                           class="form-control{{ $errors->has('contragent.okpo') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.okpo')"
                                           value="{{ old('contragent.okpo', $contragent->okpo) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.okpo') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_kpp">@lang('site::contragent.kpp')</label>
                                    <input type="number"
                                           name="contragent[kpp]"
                                           id="contragent_kpp"
                                           maxlength="9" pattern=".{0}|\d{9}"
                                           class="form-control{{ $errors->has('contragent.kpp') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.kpp')"
                                           value="{{ old('contragent.kpp', $contragent->kpp) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.kpp') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4 mt-2"
                                id="company_info">@lang('site::contragent.header.payment')</h4>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_rs">@lang('site::contragent.rs')</label>
                                    <input type="number"
                                           name="contragent[rs]"
                                           required
                                           id="contragent_rs" maxlength="20"
                                           pattern="\d{20}"
                                           class="form-control{{ $errors->has('contragent.rs') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.rs')"
                                           value="{{ old('contragent.rs', $contragent->rs) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.rs') }}</strong>
                                    </span>
                                </div>
                            </div>


                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_bik">@lang('site::contragent.bik')</label>
                                    <input type="number"
                                           name="contragent[bik]"
                                           id="contragent_bik"
                                           required
                                           maxlength="11" pattern="\d{9}|\d{11}"
                                           class="form-control{{ $errors->has('contragent.bik') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.bik')"
                                           value="{{ old('contragent.bik', $contragent->bik) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.bik') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_bank">@lang('site::contragent.bank')</label>
                                    <input type="text"
                                           name="contragent[bank]"
                                           id="contragent_bank"
                                           required
                                           maxlength="255"
                                           class="form-control{{ $errors->has('contragent.bank') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.bank')"
                                           value="{{ old('contragent.bank', $contragent->bank) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.bank') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-row required">
                                <div class="col mb-3">
                                    <label class="control-label"
                                           for="contragent_ks">@lang('site::contragent.ks')</label>
                                    <input type="number"
                                           name="contragent[ks]"
                                           id="contragent_ks"
                                           maxlength="20"
                                           required
                                           pattern="\d{20}"
                                           class="form-control{{ $errors->has('contragent.ks') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('site::contragent.placeholder.ks')"
                                           value="{{ old('contragent.ks', $contragent->ks) }}">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.ks') }}</strong>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label"
                               for="contragent_organization_id">
                            @lang('site::account.organization_id')
                        </label>
                        <select class="form-control{{  $errors->has('contragent.organization_id') ? ' is-invalid' : '' }}"
                                required
                                name="contragent[organization_id]"
                                id="contragent_organization_id">
                            <option value="">@lang('site::messages.select_from_list')</option>
                            @if($organizations->isNotEmpty())
                                @foreach($organizations as $organization)
                                    <option
                                            @if(old('contragent.organization_id', $contragent->organization_id) == $organization->id) selected
                                            @endif
                                            value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            @else
                                <option disabled value=""></option>
                            @endif
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('contragent.organization_id') }}</span>

                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label"
                                   for="contragent_contract">@lang('site::contragent.contract')</label>
                            <input type="text"
                                   name="contragent[contract]"
                                   id="contragent_contract"
                                   maxlength="50"
                                   class="form-control{{ $errors->has('contragent.contract') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contragent.placeholder.contract')"
                                   value="{{ old('contragent.contract', $contragent->contract) }}">
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('contragent.contract') }}</strong>
                            </span>
                        </div>
                    </div>

                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="contragent-form" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.contragents.show', $contragent) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection