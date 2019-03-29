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
            <li class="breadcrumb-item active">@lang('site::engineer.engineers')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::engineer.icon')"></i> @lang('site::engineer.engineers')</h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('engineers.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::engineer.engineer')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        <div class="card-deck mb-4">
            @foreach($engineers as $engineer)
                <div class="card mb-2" id="engineer-{{$engineer->id}}">
                    <div class="card-body">
                        <h4 class="card-title">{{$engineer->name}}</h4>
                        <h6 class="card-subtitle mb-2">{{$engineer->country->phone}} {{$engineer->phone}}</h6>
                        <p class="card-text">{{$engineer->address}}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('engineers.edit', $engineer)}}"
                           class="@cannot('edit', $engineer) disabled @endcannot btn btn-sm btn-secondary">
                            <i class="fa fa-pencil"></i>
                            @lang('site::messages.edit')
                        </a>

                        <a class="@cannot('delete', $engineer) disabled @endcannot btn btn-sm btn-danger btn-row-delete"
                           title="@lang('site::messages.delete')"
                           href="javascript:void(0);"
                           data-form="#engineer-delete-form-{{$engineer->id}}"
                           data-btn-delete="@lang('site::messages.delete')"
                           data-btn-cancel="@lang('site::messages.cancel')"
                           data-label="@lang('site::messages.delete_confirm')"
                           data-message="@lang('site::messages.delete_sure') {{ $engineer->name }}?"
                           data-toggle="modal"
                           data-target="#form-modal">
                            <i class="fa fa-close"></i>
                            @lang('site::messages.delete')
                        </a>
                        <form id="engineer-delete-form-{{$engineer->id}}"
                              action="{{route('engineers.destroy', $engineer)}}"
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
