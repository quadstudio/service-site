@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('engineers.index') }}">@lang('site::engineer.engineers')</a>
            </li>
            <li class="breadcrumb-item active">{{ $engineer->name }}</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">{{ $engineer->name }}</h1>
        <hr/>

        @include('alert')

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('engineers.edit', $engineer) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit')</span>
                </a>
                <a href="{{ route('engineers.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <table class="table table-sm table-bordered">
                    <tbody>
                    <tr>
                        <td class="text-right"><b>@lang('site::engineer.name')</b></td>
                        <td>{{ $engineer->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('site::engineer.country_id')</b></td>
                        <td><img style="width: 30px;" class="img-fluid border" src="{{ asset($engineer->country->flag) }}" alt=""> {{ $engineer->country->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('site::engineer.phone')</b></td>
                        <td>{{ $engineer->country->phone }}{{ $engineer->phone }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection