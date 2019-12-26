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
                <a href="{{ route('admin.news.index') }}">@lang('site::news.news')</a>
            </li>
            <li class="breadcrumb-item active">{{ $item->title }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $item->title }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.news.edit', $item) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::news.new')</span>
            </a>

            <button type="submit" form="newItem-delete-form-{{$item->id}}"
                    class="btn btn-danger d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i> <span class="d-none d-sm-inline-block">@lang('site::messages.delete')</span>
            </button>
            <a href="{{ route('admin.news.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            <form id="newItem-delete-form-{{$item->id}}"
                  action="{{route('admin.news.destroy', $item)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::news.title')</dt>
                    <dd class="col-sm-8">{{ $item->title }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::news.annotation')</dt>
                    <dd class="col-sm-8">{!! $item->annotation !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::news.description')</dt>
                    <dd class="col-sm-8">{!! $item->description !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::news.published')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $item->published == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::news.date')</dt>

                    <dd class="col-sm-8">{{$item->date->format('d.m.Y')}}</dd>
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::news.image_id')</dt>
                    <dd class="col-sm-8"><img src="{{$item->image()->exists() ? $item->image->src() : Storage::disk($item->image->storage)->url($item->image->path)}}" alt=""></dd>

                </dl>
            </div>
        </div>
    </div>
@endsection