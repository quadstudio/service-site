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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.acts.index') }}">@lang('site::act.acts')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-magic"></i> @lang('site::messages.create') @lang('site::act.act')
        </h1>
        @alert()@endalert()
        {{--<div class=" border p-3 mb-4">--}}
        {{--<a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('admin.acts.create') }}"--}}
        {{--role="button">--}}
        {{--<i class="fa fa-plus"></i>--}}
        {{--<span>@lang('site::messages.add') @lang('site::act.act')</span>--}}
        {{--</a>--}}
        {{--<a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">--}}
        {{--<i class="fa fa-reply"></i>--}}
        {{--<span>@lang('site::messages.back_admin')</span>--}}
        {{--</a>--}}
        {{--</div>--}}
        @if($errors->has('repair'))
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('site::messages.error')</h4>
                {!! implode('', $errors->all('<p class="mb-0">:message</p>')) !!}
            </div>
        @endif
        @filter(['repository' => $repository])@endfilter
        @if($users->isNotEmpty())
            <form id="act-form" method="POST"
                  action="{{ route('admin.acts.store') }}">
                @csrf
                <div class="row items-row-view">
                    @each('site::admin.act.create.row', $users, 'user')
                </div>
            </form>
            <div class="border p-2 mb-2 text-right">
                <button form="act-form" type="submit"
                        class="btn btn-ferroli mb-1">
                    <i class="fa fa-check"></i>
                    <span>@lang('site::messages.form')</span>
                </button>
                <a href="{{ route('admin.acts.index') }}" class="btn btn-secondary mb-1">
                    <i class="fa fa-close"></i>
                    <span>@lang('site::messages.cancel')</span>
                </a>
            </div>
        @else
            @include('site::admin.act.empty')
        @endif


    </div>
@endsection
