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
                <a href="{{ route('admin.contract-types.index') }}">@lang('site::contract_type.contract_types')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::contract_type.contract_type')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">
                <form id="form" method="POST" action="{{ route('admin.contract-types.store') }}">
                    @csrf

                    <div class="form-row">
                        <div class="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       @if(old('contract_type.active')) checked @endif
                                       class="custom-control-input{{  $errors->has('contract_type.active') ? ' is-invalid' : '' }}"
                                       id="active"
                                       name="contract_type[active]">
                                <label class="custom-control-label"
                                       for="active">@lang('site::contract_type.active')</label>
                                <span class="invalid-feedback">{{ $errors->first('contract_type.active') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row required mt-3">
                        <div class="col">
                            <label class="control-label" for="name">@lang('site::contract_type.name')</label>
                            <input type="text"
                                   name="contract_type[name]"
                                   id="name"
                                   required
                                   class="form-control{{ $errors->has('contract_type.name') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contract_type.placeholder.name')"
                                   value="{{ old('contract_type.name') }}">
                            <span class="invalid-feedback">{{ $errors->first('contract_type.name') }}</span>
                        </div>
                    </div>

                    <div class="form-row required mt-3">
                        <div class="col">
                            <label class="control-label" for="prefix">@lang('site::contract_type.prefix')</label>
                            <input type="text"
                                   name="contract_type[prefix]"
                                   id="prefix"
                                   required
                                   class="form-control{{ $errors->has('contract_type.prefix') ? ' is-invalid' : '' }}"
                                   placeholder="@lang('site::contract_type.placeholder.prefix')"
                                   value="{{ old('contract_type.prefix') }}">
                            <span class="invalid-feedback">{{ $errors->first('contract_type.prefix') }}</span>
                        </div>
                    </div>
                </form>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-row mt-2">
                            <div class="col">
                                <label class="control-label" class="control-label"
                                       for="file_id">@lang('site::contract_type.file_id')</label>

                                <form method="POST" enctype="multipart/form-data"
                                      action="{{route('admin.files.store')}}">
                                    @csrf
                                    <input type="hidden"
                                           name="type_id"
                                           value="17"/>
                                    <input type="hidden"
                                           name="storage"
                                           value="templates"/>
                                    <input class="d-inline-block form-control-file{{ $errors->has('file_id') ? ' is-invalid' : '' }}"
                                           type="file"
                                           accept="{{config('site.templates.accept')}}"
                                           name="path"/>

                                    <input type="button" class="btn btn-ferroli file-upload-button"
                                           value="@lang('site::messages.load')"/>
                                    <span class="invalid-feedback">{{ $errors->first('file_id') }}</span>
                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="files" class="row bg-white">
                            @include('site::admin.file.edit')
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-row">
                    <div class="col text-right">
                        <button form="form" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.contract-types.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection