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
            <li class="breadcrumb-item active">@lang('site::event_type.event_types')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::event_type.icon')"></i> @lang('site::event_type.event_types')
        </h1>
        @alert()@endalert

        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.event_types.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::event_type.event_type')</span>
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


                        <th>@lang('site::event_type.name')</th>
                        <th class="text-center">@lang('site::event_type.active')</th>
                    </tr>
                    </thead>
                    <tbody id="sort-list" data-target="{{route('admin.event_types.sort')}}">
                    @foreach($event_types as $event_type)
                        <tr class="sort-item" data-id="{{$event_type->id}}">
                            <td class="align-middle">
                                <i class="fa fa-arrows"></i>
                                <a href="{{route('admin.event_types.show', $event_type)}}">{!! $event_type->name !!}</a>
                            </td>
                            <td class="align-middle text-center">@bool(['bool' => $event_type->active == 1])@endbool</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
