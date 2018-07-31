@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.organizations.index') }}">@lang('site::organization.organizations')</a>
            </li>
            <li class="breadcrumb-item active">{{ $organization->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $organization->name }}</h1>

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('admin.organizations.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm">
                            <tbody>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::organization.active')</b></td>
                                <td class="col-6 col-sm-9">
                                    @if($organization->active)
                                        <i data-toggle="tooltip" data-placement="top"
                                           title="@lang('site::equipment.active')"
                                           class="fa fa-check text-success"></i>
                                    @else
                                        <i data-toggle="tooltip" data-placement="top"
                                           title="@lang('site::equipment.active')"
                                           class="fa fa-close text-secondary"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::organization.name')</b></td>
                                <td class="col-6 col-sm-9">{{ $organization->name }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
