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
                <a href="{{ route('admin.file_groups.index') }}">@lang('site::file_group.file_groups')</a>
            </li>
            <li class="breadcrumb-item active">{{ $file_group->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $file_group->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.file_groups.edit', $file_group) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::file_group.file_group')</span>
            </a>
            <a href="{{ route('admin.file_groups.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file_group.name')</dt>
                    <dd class="col-sm-8">{!! $file_group->name !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file_type.file_types')</dt>
                    <dd class="col-sm-8">
                        <ul class="list-group" data-target="{{route('admin.file_types.sort')}}" id="sort-list">
                            @foreach($file_group->types()->orderBy('sort_order')->get() as $type)
                                <li class="sort-item list-group-item p-1" data-id="{{$type->id}}">
                                    <i class="fa fa-arrows"></i>
                                    <a href="{{route('admin.file_types.show', $type)}}">{{ $type->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
