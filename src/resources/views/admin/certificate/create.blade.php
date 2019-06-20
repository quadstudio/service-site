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
                <a href="{{ route('admin.certificates.index') }}">@lang('site::certificate.certificates')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.load')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-download"></i>
            @lang('site::messages.load')
            @lang('site::certificate.certificates')
            {{$certificate_type->name}}
        </h1>
        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-secondary d-block d-sm-inline-block"
               href="{{ route('admin.certificates.index') }}"
               role="button">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" action="{{route('admin.certificates.store', $certificate_type)}}" method="post">
                    @csrf
                    <div class="form-row border p-3">
                        <div class="form-group mb-0">
                            <label for="path-{{$certificate_type->id}}">@lang('site::messages.xls_file')</label>
                            <input type="file"
                                   name="path"
                                   accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                   class="form-control-file{{  $errors->has('path') ? ' is-invalid' : '' }}"
                                   id="path-{{$certificate_type->id}}">
                            <span class="invalid-feedback">{!! $errors->first('path') !!}</span>
                            <button type="submit" class="btn btn-ferroli">
                                <i class="fa fa-download"></i>
                                <span>@lang('site::messages.load')</span>
                            </button>
                            <span id="pathHelp" class="d-block form-text text-success">
                                        @lang('site::messages.xls_load')<br />@lang('site::certificate.help')
                                    </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
