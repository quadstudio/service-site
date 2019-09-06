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
                <a href="{{ route('admin.storehouses.index') }}">@lang('site::storehouse.storehouses')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.create') @lang('site::storehouse.storehouse')</h1>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('site::messages.has_error')</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center mb-5">
            <div class="col">
                <form id="form"
                      method="POST"
                      action="{{ route('admin.storehouses.store') }}">
                    @csrf
                    <input type="hidden" name="storehouse.enabled" value="1">

                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <div class="form-row mt-2 required">
                                <label class="control-label" for="name">@lang('site::storehouse.name')</label>
                                <input required
                                       type="text"
                                       id="name"
                                       name="storehouse[name]"
                                       class="form-control{{ $errors->has('storehouse.name') ? ' is-invalid' : '' }}"
                                       value="{{ old('storehouse.name') }}"
                                       placeholder="@lang('site::storehouse.placeholder.name')">
                                <span class="invalid-feedback">{{ $errors->first('storehouse.name') }}</span>
                            </div>

                            @if($addresses)
                                <h4>@lang('site::storehouse.help.addresses')</h4>
                                <div class="form-row">
                                    <div class="col">
                                        @foreach($addresses as $address)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       @if(is_array(old('addresses')) && in_array($address->id, old('addresses')))
                                                       checked
                                                       @endif
                                                       name="addresses[]"
                                                       value="{{$address->id}}"
                                                       class="custom-control-input"
                                                       id="address-{{$address->id}}">
                                                <label class="custom-control-label"
                                                       for="address-{{$address->id}}">
                                                    {{$address->name}} / {{$address->full}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <div class="col text-right">
                                    <button form="form" type="submit"
                                            class="btn btn-ferroli mb-1">
                                        <i class="fa fa-check"></i>
                                        <span>@lang('site::messages.save')</span>
                                    </button>
                                    <a href="{{ route('admin.storehouses.index') }}" class="btn btn-secondary mb-1">
                                        <i class="fa fa-close"></i>
                                        <span>@lang('site::messages.cancel')</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection