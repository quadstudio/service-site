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
                <a href="{{ route('admin.templates.index') }}">@lang('site::template.templates')</a>
            </li>
            <li class="breadcrumb-item active">{{ $template->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $template->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.templates.edit', $template) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::template.template')</span>
            </a>

            <a href="{{ route('admin.templates.index') }}" class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            <button type="submit" form="template-delete-form-{{$template->id}}"
                    class="ml-5 btn btn-danger d-block d-sm-inline" title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i> <span class="d-none d-sm-inline-block">@lang('site::messages.delete')</span>
            </button>
            <form id="template-delete-form-{{$template->id}}"
                  action="{{route('admin.templates.destroy', $template)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::template.type_id')</dt>
                    <dd class="col-sm-8">{{ $template->type->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::template.name')</dt>
                    <dd class="col-sm-8">{{ $template->name }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::template.title')</dt>
                    <dd class="col-sm-8">{{ $template->title }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::template.content')</dt>
                    <dd class="col-sm-8">{!! $template->content !!}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
