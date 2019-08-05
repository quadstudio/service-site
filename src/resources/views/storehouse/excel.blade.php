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
                <a href="{{ route('storehouses.index') }}">@lang('site::storehouse.storehouses')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('storehouses.show', $storehouse) }}">{{ $storehouse->name }}</a>
            </li>
            <li class="breadcrumb-item active">{{$header_title}}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $header_title }}</h1>
        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('storehouses.show', $storehouse) }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::storehouse.help.back')</span>
            </a>
        </div>
        <div class="card mt-2 mb-2">
            <div class="card-body">

            </div>
        </div>
    </div>
@endsection
