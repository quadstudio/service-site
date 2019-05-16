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
            <li class="breadcrumb-item active">@lang('site::serial.serials')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::serial.icon')"></i> @lang('site::serial.serials')
        </h1>
        @alert()@endalert

        <div class=" border p-3 mb-4">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.serials.create') }}"
               role="button">
                <i class="fa fa-download"></i>
                <span>@lang('site::messages.load') @lang('site::serial.serials')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $serials])@endpagination
        {{$serials->render()}}
        <div class="row items-row-view">
            @each('site::admin.serial.index.row', $serials, 'serial')
        </div>
        {{$serials->render()}}
    </div>
@endsection
