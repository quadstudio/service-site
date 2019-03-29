@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::launch.launches')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::launch.icon')"></i> @lang('site::launch.launches')
        </h1>

        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('launches.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::launch.launch')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        <div class="card-deck mb-4">
            @foreach($launches as $launch)
                <div class="card mb-2" id="launch-{{$launch->id}}">
                    <div class="card-body">
                        <h4 class="card-title">{{$launch->name}}</h4>
                        <h6 class="card-subtitle mb-2">{{$launch->country->phone}} {{$launch->phone}}</h6>
                        <dl class="row">
                            @if($launch->address)
                                <dt class="col-12">@lang('site::launch.address')</dt>
                                <dd class="col-12">{{$launch->address}}</dd>
                            @endif
                            @if($launch->document_name)
                                <dt class="col-12">@lang('site::launch.document_name')</dt>
                                <dd class="col-12">{{$launch->document_name}}</dd>
                            @endif
                            @if($launch->document_number)
                                <dt class="col-12">@lang('site::launch.document_number')</dt>
                                <dd class="col-12">{{$launch->document_number}}</dd>
                            @endif
                            @if($launch->document_who)
                                <dt class="col-12">@lang('site::launch.document_who')</dt>
                                <dd class="col-12">{{$launch->document_who}}</dd>
                            @endif
                            @if($launch->document_date)
                                <dt class="col-12">@lang('site::launch.document_date')</dt>
                                <dd class="col-12">{{$launch->document_date}}</dd>
                            @endif

                        </dl>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('launches.edit', $launch)}}"
                           class="@cannot('edit', $launch) disabled @endcannot btn btn-sm btn-secondary">
                            <i class="fa fa-pencil"></i>
                            @lang('site::messages.edit')
                        </a>

                        <a class="@cannot('delete', $launch) disabled @endcannot btn btn-sm btn-danger btn-row-delete"
                           title="@lang('site::messages.delete')"
                           href="javascript:void(0);"
                           data-form="#launch-delete-form-{{$launch->id}}"
                           data-btn-delete="@lang('site::messages.delete')"
                           data-btn-cancel="@lang('site::messages.cancel')"
                           data-label="@lang('site::messages.delete_confirm')"
                           data-message="@lang('site::messages.delete_sure') {{ $launch->name }}?"
                           data-toggle="modal"
                           data-target="#form-modal">
                            <i class="fa fa-close"></i>
                            @lang('site::messages.delete')
                        </a>
                        <form id="launch-delete-form-{{$launch->id}}"
                              action="{{route('launches.destroy', $launch)}}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
