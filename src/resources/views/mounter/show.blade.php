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
                <a href="{{ route('mounters.index') }}">@lang('site::mounter.mounters')</a>
            </li>
            <li class="breadcrumb-item active">№ {{ $mounter->id }}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::mounter.header.mounter') № {{ $mounter->id }}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('mounters.edit', $mounter) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::mounter.mounter')</span>
            </a>
            <a href="{{ route('mounters.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-body">

                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.created_at')</dt>
                    <dd class="col-sm-8">{{ $mounter->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.status_id')</dt>
                    <dd class="col-sm-8">
                        <span class="badge text-normal badge-{{$mounter->status->color}}">
                            <i class="fa fa-{{$mounter->status->icon}}"></i>
                            {{ $mounter->status->name }}
                        </span>
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.user_address_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('addresses.show', $mounter->userAddress)}}">
                            {{$mounter->userAddress->name}}
                        </a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.address')</dt>
                    <dd class="col-sm-8">{{ $mounter->address }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.model')</dt>
                    <dd class="col-sm-8">{{ $mounter->model }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.client')</dt>
                    <dd class="col-sm-8">{{ $mounter->client }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.phone')</dt>
                    <dd class="col-sm-8">{{ $mounter->country->phone }} {{ $mounter->phone }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.mounter_at')</dt>
                    <dd class="col-sm-8">{{ $mounter->mounter_at->format('d.m.Y') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::mounter.comment')</dt>
                    <dd class="col-sm-8">{!! $mounter->comment !!}</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
