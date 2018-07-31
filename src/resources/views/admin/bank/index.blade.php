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
            <li class="breadcrumb-item active">@lang('site::bank.banks')</li>
        </ol>
        <h1 class="header-titlemb-4"><i class="fa fa-@lang('site::bank.icon')"></i> @lang('site::bank.banks')</h1>

    </div>
@endsection
