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
                <a href="{{ route('contacts.index') }}">@lang('site::contact.contacts')</a>
            </li>
            <li class="breadcrumb-item">
                {{$contact->name}}
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{ $contact->name }}</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="address-form" method="POST"
                      action="{{ route('contacts.update', $contact) }}">

                    @csrf
                    @method('PUT')

                    <div class="form-row required">
                        <div class="col mb-3">
                            <label class="control-label" for="name">@lang('site::contact.name')</label>
                            <input type="text"
                                   name="contact[name]"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('contact.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contact.placeholder.name')"
                                   value="{{ old('contact.name',$contact->name) }}">
                            <span class="invalid-feedback">{{ $errors->first('contact.name') }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col mb-3">
                            <label class="control-label" for="position">@lang('site::contact.position')</label>
                            <input type="text"
                                   name="contact[position]"
                                   id="position"
                                   class="form-control{{ $errors->has('contact.position') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contact.placeholder.position')"
                                   value="{{ old('contact.position',$contact->position) }}">
                            <span class="invalid-feedback">{{ $errors->first('contact.position') }}</span>
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
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection