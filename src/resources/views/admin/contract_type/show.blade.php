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
                <a href="{{ route('admin.contract-types.index') }}">@lang('site::contract_type.contract_types')</a>
            </li>
            <li class="breadcrumb-item active">{{ $contract_type->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $contract_type->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">

            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.contract-types.edit', $contract_type) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::contract_type.contract_type')</span>
            </a>
            @if($contract_type->file && $contract_type->file->exists())
                <a class="btn btn-success d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
                   href="{{route('files.show', $contract_type->file)}}">
                    <i class="fa fa-download"></i>
                    @lang('site::messages.download')
                </a>
            @endif
            <a href="{{ route('admin.contract-types.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract_type.active')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $contract_type->active])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract_type.name')</dt>
                    <dd class="col-sm-8">{{$contract_type->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contract_type.prefix')</dt>
                    <dd class="col-sm-8">{{$contract_type->prefix}}</dd>
                    @if($contract_type->file)
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.type_id')</dt>
                        <dd class="col-sm-8">{{$contract_type->file->type->name}}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.name')</dt>
                        <dd class="col-sm-8">{!! $contract_type->file->name !!}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.storage')
                            / @lang('site::file.path')</dt>
                        <dd class="col-sm-8">
                            {{Storage::disk($contract_type->file->storage)->getAdapter()->getPathPrefix().$contract_type->file->path}}
                            @if(!$contract_type->file->exists())
                                <span class="badge badge-danger text-big">@lang('site::file.error.not_found')</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.size')</dt>
                        <dd class="col-sm-8">{{formatFileSize($contract_type->file->size)}}
                            @if($contract_type->file->exists())
                                <span class="text-muted">(@lang('site::file.real_size'):
                                    {{formatFileSize(filesize(Storage::disk($contract_type->file->storage)->getAdapter()->getPathPrefix().$contract_type->file->path))}}
                                    )
                            </span>
                            @endif
                        </dd>
                    @else
                        <dd class="col-sm-8">
                            <span class="badge badge-danger text-big">@lang('site::file.error.not_found')</span>
                        </dd>
                    @endif
                </dl>

            </div>
        </div>
    </div>
@endsection
