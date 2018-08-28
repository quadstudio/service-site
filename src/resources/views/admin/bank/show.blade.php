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
                <a href="{{ route('admin.banks.index') }}">@lang('site::bank.banks')</a>
            </li>
            <li class="breadcrumb-item active">{{ $bank->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $bank->name }}</h1>
        <div class="justify-content-start border p-3 mb-2">

            <a href="{{ route('admin.banks.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::bank.name')</dt>
                    <dd class="col-sm-8">{{ $bank->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::bank.id')</dt>
                    <dd class="col-sm-8">{{ $bank->id }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::bank.ks')</dt>
                    <dd class="col-sm-8">{{ $bank->ks }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::bank.address')</dt>
                    <dd class="col-sm-8">{{ $bank->address }}</dd>

                    {{--<dt class="col-sm-4 text-left text-sm-right">@lang('site::bank.active')</dt>--}}
                    {{--<dd class="col-sm-8"> @bool(['bool' => $bank->active])@endbool</dd>--}}

                </dl>
            </div>
        </div>
    </div>
@endsection
