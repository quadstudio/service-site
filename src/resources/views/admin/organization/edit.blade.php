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
                <a href="{{ route('admin.organizations.index') }}">@lang('site::organization.organizations')</a>
            </li>
            <li class="breadcrumb-item active">{{$organization->name}}</li>
        </ol>
        <h1 class="header-title mb-4">{{$organization->name}}</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.organizations.update', $organization) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-row required">
                        <div class="col">

                            <label class="control-label"
                                   for="account_id">@lang('site::organization.account_id') / @lang('site::account.bank_id')</label>
                            <select class="form-control{{  $errors->has('account_id') ? ' is-invalid' : '' }}"
                                    required
                                    name="account_id"
                                    id="account_id">
                                <option value="">@lang('site::messages.select_from_list')</option>
                                @foreach($accounts as $account)
                                    <option
                                            @if(old('account_id', $organization->account_id) == $account->id) selected
                                            @endif
                                            value="{{ $account->id }}">{{ $account->id }}
                                        ({{ $account->bank->name }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('account_id') }}</strong>
                            </span>
                        </div>
                    </div>
                </form>

                <hr/>
                <div class=" mb-2 text-right">
                    <button form="form-content" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.organizations.show', $organization) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection