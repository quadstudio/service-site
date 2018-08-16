@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('launches.index') }}">@lang('site::launch.launches')</a>
            </li>
            <li class="breadcrumb-item active">{{ $launch->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $launch->name }}</h1>


        @alert()@endalert

        <div class=" border p-3 mb-2">
            <a href="{{ route('launches.edit', $launch) }}" class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::launch.launch')</span>
            </a>
            <a href="{{ route('launches.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::launch.name')</dt>
                    <dd class="col-sm-8">{{ $launch->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::launch.country_id')</dt>
                    <dd class="col-sm-8"><img style="width: 30px;" class="img-fluid border" src="{{ asset($launch->country->flag) }}" alt=""> {{ $launch->country->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::launch.phone')</dt>
                    <dd class="col-sm-8">{{ $launch->country->phone }}{{ $launch->phone }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::launch.document_name')</dt>
                    <dd class="col-sm-8">{{ $launch->document_name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::launch.document_number')</dt>
                    <dd class="col-sm-8">{{ $launch->document_number }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::launch.document_who')</dt>
                    <dd class="col-sm-8">{{ $launch->document_who }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::launch.document_date')</dt>
                    <dd class="col-sm-8">{{ $launch->document_date() }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection