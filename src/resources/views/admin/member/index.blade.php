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
            <li class="breadcrumb-item active">@lang('site::member.members')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::member.icon')"></i> @lang('site::member.members')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.members.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::member.member')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $members])@endpagination
        {{$members->render()}}
        <table class="table bg-white table-hover">
            <thead>
            <tr>
                <th>@lang('site::member.name')</th>
                <th>@lang('site::member.type_id')</th>
                <th>@lang('site::member.date')</th>
                <th>@lang('site::member.event_id')</th>
                <th>@lang('site::member.contact')</th>
                <th>@lang('site::member.region_id')</th>
                <th>@lang('site::member.city')</th>
                <th class="text-center">@lang('site::member.count')</th>
                <th class="text-center">@lang('site::member.status_id')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($members as $member)
                @include('site::admin.member.index.row')
            @endforeach
            </tbody>
        </table>
        {{$members->render()}}

    </div>
@endsection
