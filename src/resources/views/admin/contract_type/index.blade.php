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
            <li class="breadcrumb-item active">@lang('site::contract_type.contract_types')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::contract_type.icon')"></i> @lang('site::contract_type.contract_types')
        </h1>
        @alert()@endalert

        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.contract-types.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::contract_type.contract_type')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>@lang('site::contract_type.name')</th>
                        <th class="text-center">@lang('site::contract_type.file_id')</th>
                        <th class="text-center">@lang('site::messages.created_at')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contract_types as $contract_type)
                        <tr>
                            <td class="align-middle">
                                @bool(['bool' => $contract_type->active])@endbool
                                <a href="{{route('admin.contract-types.show', $contract_type)}}">{{$contract_type->name }}</a>
                            </td>
                            <td class="text-center">
                                @if($contract_type->file)
                                    @if(optional($contract_type->file)->exists())
                                        <a class="btn btn-success d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
                                           href="{{route('files.show', $contract_type->file)}}">
                                            <i class="fa fa-download"></i>
                                            @lang('site::messages.download')
                                        </a>
                                    @else
                                        {{$contract_type->file->name }}
                                        <span class="badge badge-danger text-big">@lang('site::file.error.not_found')</span>
                                    @endif
                                @else
                                    <span class="badge badge-danger text-big">@lang('site::file.error.not_found')</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{$contract_type->created_at->format('d.m.Y')}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
