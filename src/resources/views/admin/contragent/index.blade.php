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
            <li class="breadcrumb-item active">@lang('site::contragent.contragents')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents')
        </h1>

        @alert()@endalert

        <div class=" border p-3 mb-4">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        {{$contragents->render()}}
        @filter(['repository' => $repository])@endfilter
        <div class="row items-row-view">
            @each('site::admin.contragent.index.row', $contragents, 'contragent')
        </div>
        {{$contragents->render()}}
    </div>
@endsection