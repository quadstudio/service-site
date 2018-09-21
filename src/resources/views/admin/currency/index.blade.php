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
            <li class="breadcrumb-item active">@lang('site::currency.currencies')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::currency.icon')"></i> @lang('site::currency.currencies')</h1>

        @alert()@endalert

        <div  class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin.currency_archives.index') }}" class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::archive.icon')"></i>
                <span>@lang('site::archive.archives')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @pagination(['pagination' => $currencies])@endpagination
        {{$currencies->render()}}
        <div class="row items-row-view">
            @each('site::admin.currency.index.row', $currencies, 'currency')
        </div>
        {{$currencies->render()}}
    </div>
@endsection
