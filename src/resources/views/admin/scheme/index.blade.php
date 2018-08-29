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
            <li class="breadcrumb-item active">@lang('site::scheme.schemes')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::scheme.icon')"></i> @lang('site::scheme.schemes')</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-scheme d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.schemes.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::scheme.scheme')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-scheme d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $schemes])@endpagination
        {{$schemes->render()}}
        <div class="row items-row-view">
            @each('site::admin.scheme.index.row', $schemes, 'scheme')
        </div>
        {{$schemes->render()}}
    </div>
@endsection
