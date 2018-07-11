@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::catalog.catalogs')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::catalog.catalogs')</h1>
    </div>
@endsection
