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
            <li class="breadcrumb-item active">@lang('site::engineer.engineers')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::engineer.icon')"></i> @lang('site::engineer.engineers')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $engineers])@endpagination
        {{$engineers->render()}}
        <div class="row items-row-view">
            @each('site::admin.engineer.index.row', $engineers, 'engineer')
        </div>
        {{$engineers->render()}}

    </div>
@endsection
