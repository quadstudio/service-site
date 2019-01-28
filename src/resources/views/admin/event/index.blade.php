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
            <li class="breadcrumb-item active">@lang('site::event.events')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::event.icon')"></i> @lang('site::event.events')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.events.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::event.event')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $events])@endpagination
        {{$events->render()}}
        <table class="table bg-white table-hover">
            <thead>
            <tr>
                <th class="text-center"  rowspan="2">@lang('site::event.image_id')</th>
                <th rowspan="2">@lang('site::event.title') / @lang('site::event.type_id') / @lang('site::event.status_id')</th>
                <th class="text-center" colspan="2">@lang('site::event.date_from_to')</th>
                <th rowspan="2">@lang('site::event.region_id')</th>
                <th rowspan="2">@lang('site::event.city') / @lang('site::event.address')</th>
                <th rowspan="2">@lang('site::member.members')</th>
            </tr>
            <tr>
                <th class="text-center">@lang('site::event.date_from')</th>
                <th class="text-center">@lang('site::event.date_to')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                @include('site::admin.event.index.row')
            @endforeach
            </tbody>
        </table>
        {{$events->render()}}

    </div>
@endsection
