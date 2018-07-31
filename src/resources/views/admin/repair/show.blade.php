@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.repairs.index') }}">@lang('site::repair.repairs')</a>
            </li>
            <li class="breadcrumb-item active">{{ $repair->number }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $repair->number }}</h1>

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('admin.repairs.index') }}" class="btn btn-secondary">
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
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::repair.number')</b></td>
                                <td class="col-6 col-sm-9">{{ $repair->number }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
