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
            <li class="breadcrumb-item active">@lang('site::act.acts')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('admin.acts.create') }}"
               role="button">
                <i class="fa fa-magic"></i>
                <span>@lang('site::messages.create') @lang('site::act.act')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        {{$acts->render()}}
        @filter(['repository' => $repository])@endfilter
        <div class="row items-row-view">
            @each('site::admin.act.index.row', $acts, 'act', 'site::admin.act.empty')
        </div>
        {{$acts->render()}}
    </div>
@endsection
