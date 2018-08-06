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
                <a href="{{ route('admin.contragents.index') }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.contragents.show', $contragent) }}">{{ $contragent->name }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{ $contragent->name }}</h1>

        @alert()@endalert()

        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">

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
                                                <div class="form-check">
                                                    <input class="form-check-input
                                                    {{$errors->has('contragent.type_id') ? ' is-invalid' : ''}}"
                                                           type="radio"
                                                           required
                                                           name="contragent[type_id]"
                                                           @if(old('contragent.type_id') == $type->id || $contragent->type_id == $type->id) checked
                                                           @endif
                                                           id="contragent_type_id_{{ $type->id }}"
                                                           value="{{ $type->id }}">
                                                    <label class="form-check-label"
                                                           for="contragent_type_id_{{ $type->id }}">
                                                        {{ $type->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contragent.type_id') }}</strong>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="contragent_nds">@lang('site::contragent.nds')</label>

                                            <div class="form-check">
                                                <input class="form-check-input
                                                    {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="contragent[nds]"
                                                       required
                                                       @if(old('contragent.nds') === 1 || $contragent->nds === 1) checked
                                                       @endif
                                                       id="contragent_nds_1"
                                                       value="1">
                                                <label class="form-check-label"
                                                       for="contragent_nds_1">@lang('site::messages.yes')</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input
                                                    {{$errors->has('contragent.nds') ? ' is-invalid' : ''}}"
                                                       type="radio"
                                                       name="contragent[nds]"
                                                       required
                                                       @if(old('contragent.nds') === 0 || $contragent->nds === 0) checked
                                                       @endif
                                                       id="contragent_nds_0"
                                                       value="0">
                                                <label class="form-check-label"
                                                       for="contragent_nds_0">@lang('site::messages.no')</label>
                                            </div>

                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('contragent.nds') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4 mt-2" id="company_info">@lang('site::contragent.header.legal')</h4>
                                    <fieldset disabled>
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
                                                       class="form-control{{ $errors->has('contragent.inn') ? ' is-invalid' : '' }}"
                                                       placeholder="@lang('site::contragent.placeholder.inn')"
                                                       value="{{ old('contragent.inn', $contragent->inn) }}">
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('contragent.inn') }}</strong>
                                            </span>
                                            </div>
                                        </div>
                                    </fieldset>

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

                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label class="control-label"
                                                   for="contragent_ks">@lang('site::contragent.ks')</label>
                                            <input type="number"
                                                   name="contragent[ks]"
                                                   id="contragent_ks"
                                                   maxlength="20"
                                                   pattern="\d{20}"
                                                   required
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


                            <div class="form-row">
                                <div class="col text-right">
                                    <button name="_stay" value="1" type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.save_stay')</span>
                                    </button>
                                    <button name="_stay" value="0" type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.save')</span>
                                    </button>
                                    <a href="{{ route('admin.contragents.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-close"></i>
                                        <span>@lang('site::messages.cancel')</span>
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection