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
                <a href="{{ route('admin.pages.index') }}">@lang('site::page.pages')</a>
            </li>
            <li class="breadcrumb-item active">{{ $page->h1 }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $page->h1 }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.pages.edit', $page) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::page.page')</span>
            </a>

            <a href="{{ route('admin.pages.index') }}" class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            <button type="submit" form="page-delete-form-{{$page->id}}"
                    class="ml-5 btn btn-danger d-block d-sm-inline" title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i> <span class="d-none d-sm-inline-block">@lang('site::messages.delete')</span>
            </button>
            <form id="page-delete-form-{{$page->id}}"
                  action="{{route('admin.pages.destroy', $page)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::page.h1')</dt>
                    <dd class="col-sm-8">{{ $page->h1 }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::page.title')</dt>
                    <dd class="col-sm-8">{{ $page->title }}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::page.description')</dt>
                    <dd class="col-sm-8">{!! $page->description !!}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::page.route')</dt>
                    <dd class="col-sm-8">{{ $page->route }}</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
