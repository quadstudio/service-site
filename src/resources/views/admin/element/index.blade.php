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
            <li class="breadcrumb-item active">@lang('site::element.elements')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::element.icon')"></i> @lang('site::element.elements')</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="disabled btn btn-ferroli d-element d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.elements.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::element.element')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-element d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $elements])@endpagination
        {{$elements->render()}}
        <div class="row items-row-view" data-target="{{route('admin.elements.sort')}}" id="sort-list">
            @each('site::admin.element.index.row', $elements, 'element')
        </div>
        {{$elements->render()}}
    </div>
@endsection
