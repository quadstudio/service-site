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
                <a href="{{ route('admin.announcements.index') }}">@lang('site::announcement.announcements')</a>
            </li>
            <li class="breadcrumb-item active">{{ $announcement->title }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $announcement->title }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.announcements.edit', $announcement) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::announcement.announcement')</span>
            </a>
            <a class="btn btn-danger btn-row-delete"
               title="@lang('site::messages.delete')"
               href="javascript:void(0);"
               data-form="#announcement-delete-form-{{$announcement->id}}"
               data-btn-delete="@lang('site::messages.delete')"
               data-btn-cancel="@lang('site::messages.cancel')"
               data-label="@lang('site::messages.delete_confirm')"
               data-message="@lang('site::messages.delete_sure') {{ $announcement->name }}?"
               data-toggle="modal"
               data-target="#form-modal">
                <i class="fa fa-close"></i>
                <span class="d-none d-sm-inline-block">@lang('site::messages.delete')</span>
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            <form id="announcement-delete-form-{{$announcement->id}}"
                  action="{{route('admin.announcements.destroy', $announcement)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::announcement.title')</dt>
                    <dd class="col-sm-8">{{ $announcement->title }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::announcement.annotation')</dt>
                    <dd class="col-sm-8">{!! $announcement->annotation !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::announcement.description')</dt>
                    <dd class="col-sm-8">{!! $announcement->description !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_ferroli')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $announcement->show_ferroli == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_lamborghini')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $announcement->show_lamborghini == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::announcement.date')</dt>
                    <dd class="col-sm-8">{{$announcement->date->format('d.m.Y')}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::announcement.image_id')</dt>
                    <dd class="col-sm-8"><img src="{{$announcement->image()->exists() ? $announcement->image->src() : Storage::disk($announcement->image->storage)->url($announcement->image->path)}}" alt=""></dd>

                </dl>
            </div>
        </div>
    </div>
@endsection