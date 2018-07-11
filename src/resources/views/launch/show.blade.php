@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('repair::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('launches.index') }}">@lang('repair::launch.launches')</a>
            </li>
            <li class="breadcrumb-item active">{{ $launch->name }}</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20">{{ $launch->name }}</h1>
        <hr/>

        @include('alert')

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('launches.edit', $launch) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('repair::messages.edit')</span>
                </a>
                <a href="{{ route('launches.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('repair::messages.back')</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <table class="table table-sm table-bordered">
                    <tbody>
                    <tr>
                        <td class="text-right"><b>@lang('repair::launch.name')</b></td>
                        <td>{{ $launch->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('repair::launch.country_id')</b></td>
                        <td><img style="width: 30px;" class="img-fluid border" src="{{ asset($launch->country->flag) }}" alt=""> {{ $launch->country->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><b>@lang('repair::launch.phone')</b></td>
                        <td>{{ $launch->country->phone }}{{ $launch->phone }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection