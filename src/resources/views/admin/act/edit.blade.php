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
                <a href="{{ route('admin.acts.index') }}">@lang('site::act.acts')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.acts.show', $act) }}">№ {{ $act->id }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::act.act')</h1>

        @alert()@endalert

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="act-edit-form" method="POST" action="{{ route('admin.acts.update', $act) }}">

                    @csrf

                    @method('PUT')
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" @if(old('act.received', $act->received)) checked @endif
                        class="custom-control-input{{  $errors->has('act.received') ? ' is-invalid' : '' }}"
                               id="received"
                               value="1"
                               name="act[received]">
                        <label class="custom-control-label" for="received">@lang('site::act.received')</label>
                        <span class="invalid-feedback">{{ $errors->first('act.received') }}</span>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="number">@lang('site::act.number')</label>
                            <input type="text"
                                   name="act[number]"
                                   id="number"
                                   class="form-control{{ $errors->has('act.number') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::act.placeholder.number')"
                                   value="{{ old('act.number', $act->number) }}">

                            <span class="invalid-feedback">{{ $errors->first('act.number') }}</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class=" border p-3 mb-2">

            <button form="act-edit-form" name="_stay" value="0" type="submit"
                    class="btn btn-ferroli  mr-0 mr-sm-1 mb-1 mb-sm-0 d-block d-sm-inline">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('admin.acts.show', $act) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection