@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::repair.repairs')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <button form="repository-form"
                    type="submit"
                    name="excel" value="{{ route('admin.excel.repairs') }}"
                    class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
                <i class="fa fa-upload"></i>
                <span>@lang('site::messages.upload') @lang('site::messages.to_excel')</span>
            </button>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        {{$repairs->render()}}
        @filter(['repository' => $repository])@endfilter
        <div class="row items-row-view">
            @each('site::admin.repair.index.row', $repairs, 'repair')
        </div>
        {{$repairs->render()}}
    </div>
@endsection
