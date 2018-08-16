@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::contragent.contragents')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('contragents.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::contragent.contragent')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        @pagination(['pagination' => $contragents])@endpagination
        {{$contragents->render()}}
        <div class="row items-row-view">
            @each('site::contragent.index.row', $contragents, 'contragent')
        </div>
        {{$contragents->render()}}
    </div>
@endsection
