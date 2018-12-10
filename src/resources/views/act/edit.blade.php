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
                <a href="{{ route('acts.index') }}">@lang('site::act.acts')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('acts.show', $act) }}">№ {{ $act->id }}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::act.act')</h1>

        @alert()@endalert

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="act-edit-form" method="POST" action="{{ route('acts.update', $act) }}">

                    @csrf

                    @method('PUT')

                    <div class="form-row">
                        <div class="col mb-3">
                            <label for="number">@lang('site::act.number')</label>
                            <input type="text"
                                   name="act[number]"
                                   id="number"
                                   class="form-control{{ $errors->has('act.number') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::act.placeholder.number')"
                                   value="{{ old('act.number', $act->number) }}">
                            @if ($errors->has('act.number'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('act.number') }}</strong>
                                </span>
                            @endif
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
            <a href="{{ route('acts.show', $act) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection