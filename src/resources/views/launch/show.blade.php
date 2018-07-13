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

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('launches.edit', $launch) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit')</span>
                </a>
                <a href="{{ route('launches.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <tbody>
                    <tr>
                        <td class="text-right"><b>@lang('site::launch.name')</b></td>
                        <td>{{ $launch->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('site::launch.country_id')</b></td>
                        <td><img style="width: 30px;" class="img-fluid border" src="{{ asset($launch->country->flag) }}" alt=""> {{ $launch->country->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('site::launch.phone')</b></td>
                        <td>{{ $launch->country->phone }}{{ $launch->phone }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection